<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    // -------------------- LOGIN --------------------
    public function loginPage()
    {
        return view('admin_login');
    }

    public function login(Request $request)
    {
        if ($request->email == "admin@gmail.com" && $request->password == "admin123") {
            session(['admin_logged_in' => true]);
            return redirect('/admin/orders');
        }

        return back()->with('error', 'Invalid admin credentials');
    }


    // -------------------- ADMIN DASHBOARD (ORDERS) --------------------
    public function orders()
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        // ✅ FETCH ORDERS (NOT PAYMENTS)
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->get();

        return view('admin_orders', compact('orders'));
    }


    // -------------------- APPROVE ORDER --------------------
    public function approve($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $order = DB::table('orders')->where('id', $id)->first();

        if (!$order) {
            return back()->with('status', 'Order not found');
        }

        // ✅ UPDATE ORDER STATUS
        DB::table('orders')
            ->where('id', $id)
            ->update([
                'status' => 'approved'
            ]);

        return back()->with('status', 'Order approved! User can now pay.');
    }


    // -------------------- BILL --------------------
    public function bill($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('orders.id', $id)
            ->first();

        return view('payment_bill', compact('order'));
    }


    // -------------------- LOGOUT --------------------
    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect('/admin/login');
    }

}