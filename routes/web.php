<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Vendor\VendorDealController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', function () {
    return view('welcome'); // or 'home' if you prefer
})->name('home');


// -------------------- DEAL SYSTEM --------------------

// Demo Deal Page
Route::get('/demo-deal', [DealController::class, 'demoDeal'])->name('demo.deal');

// Show deal details
Route::get('/deal/{id}', [DealController::class, 'show'])->name('deal.show');

// Join deal
Route::post('/deal/join', [DealController::class, 'joinDeal'])->name('deal.join');

// Real-time participant API
Route::get('/deal/{id}/participants', [DealController::class, 'participants']);


// -------------------- PAYMENT --------------------

Route::post('/payment/request', [PaymentController::class, 'store'])->name('payment.request');
Route::put('/admin/payment/approve/{id}', [PaymentController::class, 'approve'])->name('payment.approve');


// -------------------- DASHBOARD --------------------

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'vendor') {
        return redirect()->route('vendor.deals.index');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// -------------------- PROFILE --------------------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// -------------------- ADMIN --------------------

Route::get('/admin/login',[AdminController::class,'loginPage'])->name('admin.login');
Route::post('/admin/login',[AdminController::class,'login']);

Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::post('/admin/orders/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');

Route::get('/admin/bill/{id}', [AdminController::class,'bill'])->name('admin.bill');

Route::get('/admin/logout',[AdminController::class,'logout'])->name('admin.logout');


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


// Auth routes
require __DIR__.'/auth.php';