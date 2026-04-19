<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Vendor\VendorDealController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// -------------------- DEAL SYSTEM --------------------

// Demo Deal Page
Route::get('/demo-deal', [DealController::class, 'demoDeal'])->name('demo.deal');

// Show deal details
Route::get('/deal/{id}', [DealController::class, 'show'])->name('deal.show');

// Join deal
Route::post('/deal/join', [DealController::class, 'joinDeal'])->name('deal.join');

// Real-time API
Route::get('/api/deal/{id}', [DealController::class, 'getDeal'])->name('deal.api');


// -------------------- PAYMENT --------------------

// ✅ PROTECTED PAYMENT (IMPORTANT FIX)
Route::post('/payment/request', [PaymentController::class, 'store'])
    ->middleware('auth')
    ->name('payment.request');


// -------------------- DASHBOARD --------------------

Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect('/login');
    }

    $user = auth()->user();

    // ✅ SAFE CHECK
    if (isset($user->role) && $user->role === 'vendor') {
        return redirect()->route('vendor.deals.index');
    }

    return view('dashboard');

})->middleware(['auth'])->name('dashboard');


// -------------------- FEATURE PAGES --------------------

// Participants Page
Route::get('/participants', [DealController::class, 'participantsPage'])
    ->middleware('auth')
    ->name('participants.page');


// Dynamic Pricing
Route::get('/pricing', function () {

    $participants = DB::table('deal_user')->count();

    if ($participants <= 5) {
        $price = 1000;
    } elseif ($participants <= 10) {
        $price = 900;
    } elseif ($participants <= 20) {
        $price = 800;
    } else {
        $price = 700;
    }

    return view('pricing', [
        'participants' => $participants,
        'currentPrice' => $price
    ]);

})->middleware('auth')->name('pricing.page');


// Orders (User Side)
Route::get('/orders', function () {

    $orders = DB::table('orders')
        ->where('user_id', auth()->id())
        ->get();

    return view('orders', compact('orders'));

})->middleware('auth')->name('orders.page');


// -------------------- PROFILE --------------------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// -------------------- ADMIN --------------------

Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');

// Approve Order
Route::post('/admin/orders/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');

// Bill
Route::get('/admin/bill/{id}', [AdminController::class, 'bill'])->name('admin.bill');

Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


// -------------------- VENDOR --------------------

Route::middleware(['auth'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::resource('deals', VendorDealController::class);

    Route::post('notifications/{id}/read', [VendorDealController::class, 'markNotificationRead'])
        ->name('notifications.read');
});


// -------------------- UTILITY --------------------

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


// -------------------- AUTH --------------------

require __DIR__.'/auth.php';