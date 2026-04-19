<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Deal;
use App\Models\Notification;
use App\Http\Controllers\Payment\PaymentController;
use Carbon\Carbon;

class CancelExpiredDeals extends Command
{
    protected $signature   = 'deals:cancel-expired';
    protected $description = 'Automatically cancel expired deals and process refunds';

    public function handle()
    {
        $expiredDeals = Deal::whereIn('status', ['pending', 'active'])
                            ->where('deadline', '<', Carbon::now())
                            ->whereRaw('current_participants < min_participants')
                            ->with(['participants.user', 'vendor.user', 'orders.payment'])
                            ->get();

        if ($expiredDeals->isEmpty()) {
            $this->info('No expired deals found.');
            return 0;
        }

        $paymentController = new PaymentController();

        foreach ($expiredDeals as $deal) {
            $deal->update(['status' => 'cancelled']);

            // Auto-process refunds
            foreach ($deal->orders as $order) {
                if ($order->payment && $order->payment->isCompleted()) {
                    $paymentController->processRefund($order->id);
                    $this->info("Refunded order #{$order->id} for deal: {$deal->title}");
                }
            }

            // Notify vendor
            if ($deal->vendor && $deal->vendor->user) {
                Notification::create([
                    'user_id' => $deal->vendor->user_id,
                    'type'    => 'deal_cancelled',
                    'message' => "Your deal \"{$deal->title}\" was automatically cancelled. All user payments have been refunded.",
                    'is_read' => false,
                ]);
            }

            // Notify participants
            foreach ($deal->participants as $participant) {
                Notification::create([
                    'user_id' => $participant->user_id,
                    'type'    => 'deal_cancelled',
                    'message' => "The deal \"{$deal->title}\" was cancelled. Your payment has been automatically refunded.",
                    'is_read' => false,
                ]);
            }

            $this->info("Cancelled deal: {$deal->title}");
        }

        $this->info('✅ Done.');
        return 0;
    }
}