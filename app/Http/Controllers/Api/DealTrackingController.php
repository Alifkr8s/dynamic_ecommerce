<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DealTrackingController extends Controller
{
    // Returns live deal data as JSON for real-time updates
    public function getDealStatus($id)
    {
        $deal = Deal::where('id', $id)
                    ->with(['tiers', 'participants.user', 'product'])
                    ->first();

        if (!$deal) {
            return response()->json(['error' => 'Deal not found'], 404);
        }

        $now      = Carbon::now();
        $deadline = Carbon::parse($deal->deadline);
        $expired  = $now->greaterThan($deadline);

        // Auto cancel if expired and min not reached
        if ($expired && !$deal->isGoalReached() && !$deal->isCancelled() && !$deal->isCompleted()) {
            $deal->update(['status' => 'cancelled']);
            $deal->refresh();
        }

        // Calculate time remaining
        $timeRemaining = null;
        if (!$expired) {
            $diff = $now->diff($deadline);
            $timeRemaining = [
                'days'    => $diff->d + ($diff->m * 30) + ($diff->y * 365),
                'hours'   => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s,
                'total_seconds' => $now->diffInSeconds($deadline),
            ];
        }

        // Progress percentage
        $progress = min(100, round(($deal->current_participants / $deal->min_participants) * 100));

        // Current tier
        $currentTier = null;
        foreach ($deal->tiers->sortByDesc('min_count') as $tier) {
            if ($deal->current_participants >= $tier->min_count) {
                $currentTier = $tier;
                break;
            }
        }

        // Next tier
        $nextTier = null;
        foreach ($deal->tiers->sortBy('min_count') as $tier) {
            if ($deal->current_participants < $tier->min_count) {
                $nextTier = $tier;
                break;
            }
        }

        return response()->json([
            'id'                   => $deal->id,
            'title'                => $deal->title,
            'status'               => $deal->status,
            'current_participants' => $deal->current_participants,
            'min_participants'     => $deal->min_participants,
            'remaining_slots'      => max(0, $deal->min_participants - $deal->current_participants),
            'progress_percent'     => $progress,
            'current_price'        => $deal->current_price,
            'is_expired'           => $expired,
            'is_goal_reached'      => $deal->isGoalReached(),
            'time_remaining'       => $timeRemaining,
            'deadline'             => $deal->deadline->format('d M Y, h:i A'),
            'current_tier'         => $currentTier ? [
                'min_count' => $currentTier->min_count,
                'price'     => $currentTier->price,
            ] : null,
            'next_tier'            => $nextTier ? [
                'min_count'      => $nextTier->min_count,
                'price'          => $nextTier->price,
                'slots_needed'   => $nextTier->min_count - $deal->current_participants,
            ] : null,
            'recent_participants'  => $deal->participants->sortByDesc('joined_at')->take(5)->map(function ($p) {
                return [
                    'name'      => $p->user ? $p->user->name : 'Anonymous',
                    'joined_at' => Carbon::parse($p->joined_at)->diffForHumans(),
                ];
            })->values(),
        ]);
    }
}