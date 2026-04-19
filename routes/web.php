<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\VendorDealController;
use App\Http\Controllers\Api\DealTrackingController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Admin\AdminPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('home');
})->name('home');

// ==================== DASHBOARD ====================
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'vendor') {
        return redirect()->route('vendor.deals.index');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.payments.index');
    } else {
        return redirect()->route('home');
    }
})->middleware(['auth'])->name('dashboard');

// ==================== REAL-TIME DEAL TRACKING API ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/api/deals/{id}/status', [DealTrackingController::class, 'getDealStatus'])
         ->name('api.deals.status');
});

// ==================== PAYMENT ROUTES (User) ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/checkout/{dealId}', [PaymentController::class, 'checkout'])
         ->name('payment.checkout');
    Route::post('/payment/create-intent', [PaymentController::class, 'createPaymentIntent'])
         ->name('payment.create.intent');
    Route::post('/payment/success', [PaymentController::class, 'paymentSuccess'])
         ->name('payment.success');
    Route::get('/payment/success/{orderId}', [PaymentController::class, 'successPage'])
         ->name('payment.success.page');
    Route::get('/payment/failed', [PaymentController::class, 'failedPage'])
         ->name('payment.failed');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/payments', [AdminPaymentController::class, 'index'])
         ->name('payments.index');
    Route::post('/payments/refund/{dealId}', [AdminPaymentController::class, 'refundDeal'])
         ->name('payments.refund');
    Route::post('/payments/release/{dealId}', [AdminPaymentController::class, 'releaseToVendor'])
         ->name('payments.release');
    Route::post('/payments/auto-refund', [AdminPaymentController::class, 'autoRefundFailedDeals'])
         ->name('payments.auto.refund');
});

// ==================== VENDOR ROUTES ====================
Route::middleware(['auth'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::resource('deals', VendorDealController::class);
    Route::post('notifications/{id}/read', [VendorDealController::class, 'markNotificationRead'])
         ->name('notifications.read');
});

// ==================== AUTH ROUTES ====================
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// ==================== UTILITY ROUTES ====================
Route::get('/logout-now', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

Route::get('/clear-session', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});