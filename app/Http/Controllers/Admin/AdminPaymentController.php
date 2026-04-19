<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\PaymentController;
use App\Models\Deal;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Carbon\Carbon;

class AdminPaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret'));
    }

    // Admin payment dashboard
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login');
        }

        $payments = Payment::with(['order.deal.vendor', 'user'])
                           ->latest()
                           ->paginate(20);

        $totalCollected = Payment::where('status', 'completed')->sum('amount');
        $totalRefunded  = Payment::where('status', 'refunded')->sum('amount');
        $totalPending   = Payment::where('status', 'pending')->sum('amount');

        $pendingDeals = Deal::whereIn('status', ['active', 'completed'])
                            ->with(['orders.payment', 'vendor'])
                            ->get()
                            ->filter(function ($deal) {
                                return $deal->orders->where('status', 'confirmed')->count() > 0
                                    || $deal->orders->where('status', 'pending')->count() > 0;
                            });

        return view('admin.payments.index', compact(
            'payments',
            'totalCollected',
            'totalRefunded',
            'totalPending',
            'pendingDeals'
        ));
    }

    // Admin refunds a failed deal
    public function refundDeal($dealId)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login');
        }

        $deal = Deal::with(['orders.payment', 'orders.user'])
                    ->findOrFail($dealId);

        $refundCount = 0;
        $failedCount = 0;

        $paymentController = new PaymentController();

        foreach ($deal->orders as $order) {
            if ($order->payment && $order->payment->isCompleted()) {
                $result = $paymentController->processRefund($order->id);
                if ($result) {
                    $refundCount++;
                } else {
                    $failedCount++;
                }
            }
        }

        $deal->update(['status' => 'cancelled']);

        $msg = "✅ Refunded {$refundCount} payment(s) successfully.";
        if ($failedCount > 0) {
            $msg .= " ⚠️ {$failedCount} refund(s) failed — check logs.";
        }

        return redirect()->route('admin.payments.index')->with('success', $msg);
    }

    // Admin releases payment to vendor
    public function releaseToVendor(Request $request, $dealId)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login');
        }

        $deal = Deal::with(['orders.payment', 'vendor.user'])
                    ->findOrFail($dealId);

        $releasedCount = 0;

        foreach ($deal->orders as $order) {
            if ($order->payment && $order->payment->isCompleted()) {
                $order->update(['status' => 'confirmed']);
                $releasedCount++;

                // Notify vendor
                if ($deal->vendor) {
                    Notification::create([
                        'user_id' => $deal->vendor->user_id,
                        'type'    => 'payment_released',
                        'message' => "💰 Payment of \${$order->total_amount} for deal \"{$deal->title}\" has been released to you by admin.",
                        'is_read' => false,
                    ]);
                }

                // Notify user
                Notification::create([
                    'user_id' => $order->user_id,
                    'type'    => 'order_confirmed',
                    'message' => "✅ Your order for \"{$deal->title}\" has been confirmed by admin. Your product will be delivered soon.",
                    'is_read' => false,
                ]);
            }
        }

        $deal->update(['status' => 'completed']);

        return redirect()->route('admin.payments.index')
                         ->with('success', "✅ Released {$releasedCount} payment(s) to vendor for \"{$deal->title}\" successfully!");
    }

    // Auto-refund all failed/cancelled deals
    public function autoRefundFailedDeals()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login');
        }

        $failedDeals = Deal::where('status', 'cancelled')
                           ->with(['orders.payment'])
                           ->get();

        $totalRefunded = 0;
        $totalFailed   = 0;

        $paymentController = new PaymentController();

        foreach ($failedDeals as $deal) {
            foreach ($deal->orders as $order) {
                if ($order->payment && $order->payment->isCompleted()) {
                    $result = $paymentController->processRefund($order->id);
                    if ($result) {
                        $totalRefunded++;
                    } else {
                        $totalFailed++;
                    }
                }
            }
        }

        $msg = "✅ Auto-refund complete. {$totalRefunded} payment(s) refunded.";
        if ($totalFailed > 0) {
            $msg .= " ⚠️ {$totalFailed} failed — check logs.";
        }

        return redirect()->route('admin.payments.index')->with('success', $msg);
    }
}