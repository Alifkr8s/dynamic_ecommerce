<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{

    // -------------------- SHOW DEAL --------------------
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


    // -------------------- API --------------------
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
            'participants' => $participants,
            'min_participants' => $deal->min_participants,
            'end_time' => $deal->end_time
        ]);
    }


    // -------------------- JOIN DEAL --------------------
    public function joinDeal(Request $request)
    {
        $deal = Deal::find($request->deal_id);

        if (!$deal) {
            return redirect()->back()->with('status', 'Deal not found!');
        }

        // prevent expired join
        if ($deal->end_time && now()->greaterThan($deal->end_time)) {
            return redirect()->back()->with('status', 'Deal expired!');
        }

        // prevent duplicate join
        $exists = DB::table('deal_user')
            ->where('user_id', $request->user_id)
            ->where('deal_id', $request->deal_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('status', 'You already joined!');
        }

        // insert into deal_user
        DB::table('deal_user')->insert([
            'user_id' => $request->user_id,
            'deal_id' => $request->deal_id
        ]);

        // 🔥 FIXED: use base_price
        DB::table('orders')->insert([
            'user_id' => $request->user_id,
            'deal_id' => $request->deal_id,
            'amount' => $deal->base_price, // ✅ FIX HERE
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('status', 'Joined & Order Created!');
    }


    // -------------------- DEMO DEAL --------------------
    public function demoDeal()
    {
        $deal = Deal::first();

        if (!$deal) {
            return "No deal available!";
        }

        $participants = DB::table('deal_user')
            ->where('deal_id', $deal->id)
            ->count();

        return view('deal_details', compact('deal', 'participants'));
    }


    // -------------------- PARTICIPANTS PAGE --------------------
    public function participantsPage()
    {
        $participants = DB::table('deal_user')
            ->join('users', 'deal_user.user_id', '=', 'users.id')
            ->select(
                'users.name',
                'users.email',
                'deal_user.deal_id'
            )
            ->get();

        return view('participants', compact('participants'));
    }

}