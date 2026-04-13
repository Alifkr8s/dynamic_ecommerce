<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{

    // User requests payment
    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'deal_id' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required'
        ]);

        Payment::create([
            'user_id' => $request->user_id,
            'deal_id' => $request->deal_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        // Redirect back to deal page
        return redirect()->back()->with('status','Payment request submitted successfully!');
    }


    // Admin approves payment
    public function approve($id)
    {

        $payment = Payment::find($id);

        if(!$payment){
            return redirect()->back()->with('status','Payment not found');
        }

        $payment->status = 'approved';
        $payment->save();

        return redirect()->back()->with('status','Payment approved successfully');
    }

}