<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Vendor\VendorDealController;
use App\Http\Controllers\Api\DealTrackingController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('home');
})->name('home');

// ==================== DEAL SYSTEM ====================
Route::get('/demo-deal', [DealController::class, 'demoDeal'])->name('demo.deal');
Route::get('/deal/{id}', [DealController::class, 'show'])->name('deal.show');
Route::post('/deal/join', [DealController::class, 'joinDeal'])->name('deal.join');

// Real-time API
Route::get('/api/deal/{id}', [DealController::class, 'getDeal'])->name('deal.api');

// ==================== PAYMENT ====================
Route::post('/payment/request', [PaymentController::class, 'store'])
    ->middleware('auth')
    ->name('payment.request');

// ==================== DASHBOARD ====================
Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect('/login');
    }

    $user = auth()->user();

    if ($user->role === 'vendor') {
        return redirect()->route('vendor.deals.index');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.orders');
    }

    return view('dashboard');

})->middleware(['auth'])->name('dashboard');

// ==================== FEATURE PAGES ====================
Route::get('/participants', function () {
    return view('participants');
})->name('participants.page');

// Orders (User)
Route::get('/orders', function () {
    $orders = DB::table('orders')
        ->where('user_id', auth()->id())
        ->get();

    return view('orders', compact('orders'));
})->middleware('auth')->name('orders.page');

// ==================== REAL-TIME TRACKING ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/api/deals/{id}/status', [DealTrackingController::class, 'getDealStatus'])
         ->name('api.deals.status');
});

// ==================== ADMIN ====================
Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::get('/bill/{id}', [AdminController::class, 'bill'])->name('bill');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
});

// ==================== VENDOR ====================
Route::middleware(['auth'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::resource('deals', VendorDealController::class);
    Route::post('notifications/{id}/read', [VendorDealController::class, 'markNotificationRead'])
        ->name('notifications.read');
});

// ==================== AUTH ====================
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// ==================== UTILITY ====================
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