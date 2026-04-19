<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        if (!$request->order_id) {
            return back()->with('error', 'Invalid request');
        }

        // Find order
        $order = DB::table('orders')
            ->where('id', $request->order_id)
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found');
        }

        // Prevent double payment
        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Already paid');
        }

        // Only approved orders can be paid
        if ($order->status !== 'approved') {
            return back()->with('error', 'Order not approved yet');
        }

        // Update payment
        DB::table('orders')
            ->where('id', $request->order_id)
            ->update([
                'payment_status' => 'paid',
                'status' => 'completed',
                'updated_at' => now()
            ]);

        return redirect('/orders')->with('success', 'Payment successful!');
    }
}