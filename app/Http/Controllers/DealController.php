<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{

    // Show Deal Page
    public function show($id)
    {
        $deal = Deal::find($id);

        if (!$deal) {
            abort(404);
        }

        $participants = DB::table('deal_user')
            ->where('deal_id', $id)
            ->count();

        return view('deal_details', compact('deal','participants'));
    }


    // API (optional)
    public function getDeal($id)
    {
        $deal = Deal::find($id);

        if (!$deal) {
            return response()->json([
                'message' => 'Deal not found'
            ], 404);
        }

        $participants = DB::table('deal_user')
            ->where('deal_id', $id)
            ->count();

        return response()->json([
            'deal_id' => $deal->id,
            'participants' => $participants
        ]);
    }


    // ✅ FIXED JOIN DEAL (NO DUPLICATES)
    public function joinDeal(Request $request)
    {
        // Check if user already joined
        $exists = DB::table('deal_user')
            ->where('user_id', $request->user_id)
            ->where('deal_id', $request->deal_id)
            ->exists();

        // If already joined
        if ($exists) {
            return redirect()->back()->with('status', 'You already joined this deal!');
        }

        // Insert if not joined
        DB::table('deal_user')->insert([
            'user_id' => $request->user_id,
            'deal_id' => $request->deal_id
        ]);

        return redirect()->back()->with('status', 'Joined successfully!');
    }

}