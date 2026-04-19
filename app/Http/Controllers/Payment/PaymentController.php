<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Order;
use App\Models\Payment;
use App\Models\DealParticipant;
use App\Models\Notification;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret'));
    }

    // Show checkout page
    public function checkout($dealId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $deal = Deal::with(['product', 'tiers', 'vendor'])
                    ->findOrFail($dealId);

        if (!in_array($deal->status, ['pending', 'active'])) {
            return redirect()->back()
                             ->with('error', '❌ This deal is no longer available.');
        }

        $alreadyJoined = DealParticipant::where('deal_id', $dealId)
                                        ->where('user_id', Auth::id())
                                        ->exists();
        if ($alreadyJoined) {
            return redirect()->back()
                             ->with('error', '❌ You have already joined this deal.');
        }

        if ($deal->isExpired()) {
            return redirect()->back()
                             ->with('error', '❌ This deal has expired.');
        }

        return view('payment.checkout', compact('deal'));
    }

    // Create Stripe PaymentIntent
    public function createPaymentIntent(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'deal_id' => 'required|exists:deals,id',
        ]);

        try {
            $deal = Deal::findOrFail($request->deal_id);

            $amountInCents = (int)($deal->current_price * 100);

            $paymentIntent = PaymentIntent::create([
                'amount'      => $amountInCents,
                'currency'    => 'usd',
                'metadata'    => [
                    'deal_id'    => $deal->id,
                    'user_id'    => Auth::id(),
                    'deal_title' => $deal->title,
                ],
                'description' => 'TierMart - ' . $deal->title,
            ]);

            return response()->json([
                'client_secret'     => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
                'amount'            => $deal->current_price,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Handle successful payment
    public function paymentSuccess(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'payment_intent_id' => 'required|string',
            'deal_id'           => 'required|exists:deals,id',
        ]);

        try {
            $deal = Deal::with(['tiers', 'participants', 'vendor'])
                        ->findOrFail($request->deal_id);

            // Verify payment with Stripe
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status !== 'succeeded') {
                return redirect()->route('payment.failed')
                                 ->with('error', '❌ Payment was not successful.');
            }

            // Prevent duplicate orders
            $existingOrder = Order::where('user_id', Auth::id())
                                  ->where('deal_id', $request->deal_id)
                                  ->first();
            if ($existingOrder) {
                return redirect()->route('payment.success.page', $existingOrder->id);
            }

            // Create Order
            $order = Order::create([
                'user_id'      => Auth::id(),
                'deal_id'      => $deal->id,
                'total_amount' => $deal->current_price,
                'status'       => 'pending',
            ]);

            // Get charge ID from PaymentIntent
            $chargeId = null;
            if (!empty($paymentIntent->latest_charge)) {
                $chargeId = $paymentIntent->latest_charge;
            }

            // Create Payment record
            Payment::create([
                'order_id'              => $order->id,
                'user_id'               => Auth::id(),
                'amount'                => $deal->current_price,
                'stripe_payment_id'     => $paymentIntent->id,
                'stripe_payment_intent' => $paymentIntent->id,
                'stripe_charge_id'      => $chargeId,
                'status'                => 'completed',
            ]);

            // Add user as participant if not already joined
            $alreadyJoined = DealParticipant::where('deal_id', $deal->id)
                                            ->where('user_id', Auth::id())
                                            ->exists();
            if (!$alreadyJoined) {
                DealParticipant::create([
                    'deal_id'   => $deal->id,
                    'user_id'   => Auth::id(),
                    'joined_at' => Carbon::now(),
                ]);

                $deal->increment('current_participants');
                $deal->refresh();

                // Recalculate price based on new tier
                $newPrice = $deal->calculateCurrentPrice();
                $deal->update(['current_price' => $newPrice]);

                // Activate deal if min participants reached
                if ($deal->isGoalReached() && $deal->status === 'pending') {
                    $deal->update(['status' => 'active']);

                    Notification::create([
                        'user_id' => $deal->vendor->user_id,
                        'type'    => 'deal_activated',
                        'message' => "🎉 Your deal \"{$deal->title}\" has been activated! Minimum participants reached.",
                        'is_read' => false,
                    ]);
                }
            }

            // Generate Invoice
            $invoice = Invoice::create([
                'order_id'       => $order->id,
                'invoice_number' => Invoice::generateNumber(),
                'amount'         => $deal->current_price,
                'issued_at'      => Carbon::now(),
            ]);

            // Notify user
            Notification::create([
                'user_id' => Auth::id(),
                'type'    => 'payment_success',
                'message' => "✅ Payment of \${$deal->current_price} successful for \"{$deal->title}\". Invoice: {$invoice->invoice_number}",
                'is_read' => false,
            ]);

            return redirect()->route('payment.success.page', $order->id);

        } catch (\Exception $e) {
            \Log::error('Payment success error: ' . $e->getMessage());
            return redirect()->route('payment.failed');
        }
    }

    // Payment success page
    public function successPage($orderId)
    {
        $order = Order::with(['deal.product', 'deal.tiers', 'payment', 'invoice'])
                      ->where('user_id', Auth::id())
                      ->findOrFail($orderId);

        return view('payment.success', compact('order'));
    }

    // Payment failed page
    public function failedPage()
    {
        return view('payment.failed');
    }

    // Process refund for a single order
    public function processRefund($orderId)
    {
        $order = Order::with(['payment', 'deal'])->findOrFail($orderId);

        if (!$order->payment || !$order->payment->isCompleted()) {
            return false;
        }

        if ($order->payment->isRefunded()) {
            return true;
        }

        try {
            // Get charge ID if missing
            if (empty($order->payment->stripe_charge_id)) {
                $paymentIntent = PaymentIntent::retrieve($order->payment->stripe_payment_intent);
                $chargeId = $paymentIntent->latest_charge ?? null;

                if ($chargeId) {
                    $order->payment->update(['stripe_charge_id' => $chargeId]);
                } else {
                    \Log::error("No charge ID found for order #{$orderId}");
                    return false;
                }
            }

            // Create Stripe refund
            $refund = Refund::create([
                'charge'   => $order->payment->stripe_charge_id,
                'metadata' => [
                    'order_id' => $order->id,
                    'deal_id'  => $order->deal_id,
                    'reason'   => 'Deal failed - minimum participants not reached',
                ],
            ]);

            // Update payment record
            $order->payment->update([
                'status'      => 'refunded',
                'refund_id'   => $refund->id,
                'refunded_at' => Carbon::now(),
            ]);

            // Update order status
            $order->update(['status' => 'cancelled']);

            // Notify user
            Notification::create([
                'user_id' => $order->user_id,
                'type'    => 'payment_refunded',
                'message' => "💸 Your payment of \${$order->total_amount} for \"{$order->deal->title}\" has been refunded. It will appear in 5-10 business days.",
                'is_read' => false,
            ]);

            return true;

        } catch (\Exception $e) {
            \Log::error('Refund failed for order #' . $orderId . ': ' . $e->getMessage());
            return false;
        }
    }
}