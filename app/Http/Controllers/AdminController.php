<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AdminController extends Controller
{

    // Show admin login page
    public function loginPage()
    {
        return view('admin_login');
    }

    // Handle admin login
    public function login(Request $request)
    {

        if($request->email == "admin@gmail.com" && $request->password == "admin123"){
            session(['admin_logged_in' => true]);

            return redirect('/admin/orders');
        }

        return back()->with('error','Invalid admin credentials');
    }

    // Admin payment dashboard
    public function orders()
    {
        if(!session('admin_logged_in')){
            return redirect('/admin/login');
        }

        $payments = Payment::all();

        return view('admin_orders', compact('payments'));
    }

    // Approve payment
    public function approve($id)
    {
        $payment = Payment::find($id);

        if(!$payment){
            return back()->with('status','Payment not found');
        }

        $payment->status = 'approved';
        $payment->save();

        return back()->with('status','Payment approved');
    }

    // Generate bill
    public function bill($id)
    {

        if(!session('admin_logged_in')){
            return redirect('/admin/login');
        }

        $payment = Payment::find($id);

        return view('payment_bill', compact('payment'));

    }

    // Logout admin
    public function logout()
    {
        session()->forget('admin_logged_in');

        return redirect('/admin/login');
    }

}