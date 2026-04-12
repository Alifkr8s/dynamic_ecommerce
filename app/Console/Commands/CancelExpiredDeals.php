<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Deal;
use App\Models\Notification;
use Carbon\Carbon;

class CancelExpiredDeals extends Command
{
    protected $signature   = 'deals:cancel-expired';
    protected $description = 'Automatically cancel deals that have passed deadline without meeting minimum participants';

    public function handle()
    {
        $expiredDeals = Deal::whereIn('status', ['pending', 'active'])
                            ->where('deadline', '<', Carbon::now())
                            ->where(function ($query) {
                                $query->whereRaw('current_participants < min_participants')
                                      ->orWhere('status', 'pending');
                            })
                            ->with(['participants.user', 'vendor.user'])
                            ->get();

        if ($expiredDeals->isEmpty()) {
            $this->info('No expired deals found.');
            return 0;
        }

        foreach ($expiredDeals as $deal) {
            // Only cancel if min participants not reached
            if ($deal->current_participants < $deal->min_participants) {
                $deal->update(['status' => 'cancelled']);

                // Notify vendor
                if ($deal->vendor && $deal->vendor->user) {
                    Notification::create([
                        'user_id' => $deal->vendor->user_id,
                        'type'    => 'deal_cancelled',
                        'message' => "Your deal \"{$deal->title}\" has been automatically cancelled because the minimum participant requirement was not met before the deadline.",
                        'is_read' => false,
                    ]);
                }

                // Notify each participant
                foreach ($deal->participants as $participant) {
                    Notification::create([
                        'user_id' => $participant->user_id,
                        'type'    => 'deal_cancelled',
                        'message' => "The deal \"{$deal->title}\" you joined has been cancelled because the minimum participants were not reached before the deadline.",
                        'is_read' => false,
                    ]);
                }

                $this->info("Cancelled deal: {$deal->title} (ID: {$deal->id})");
            }
        }

        $this->info('✅ Expired deals processed successfully.');
        return 0;
    }
}