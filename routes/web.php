<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Home page
Route::get('/', function () {
    return view('welcome');
});


// Demo Deal Page
Route::get('/demo-deal', [DealController::class, 'demoDeal'])->name('demo.deal');


// Show deal details
Route::get('/deal/{id}', [DealController::class, 'show'])->name('deal.show');


// Join deal
Route::post('/deal/join', [DealController::class, 'joinDeal'])->name('deal.join');


// Real-time participant API
Route::get('/deal/{id}/participants', [DealController::class, 'participants']);


// Payment request
Route::post('/payment/request', [PaymentController::class, 'store'])->name('payment.request');


// Admin approve payment (API)
Route::put('/admin/payment/approve/{id}', [PaymentController::class, 'approve'])->name('payment.approve');


// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Profile
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


// -------------------- ADMIN ROUTES --------------------


// Admin Login Page
Route::get('/admin/login',[AdminController::class,'loginPage'])->name('admin.login');


// Admin Login Action
Route::post('/admin/login',[AdminController::class,'login']);


// Admin Dashboard
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');


// Approve Payment from Dashboard
Route::post('/admin/orders/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');


// Generate Payment Bill
Route::get('/admin/bill/{id}', [AdminController::class,'bill'])->name('admin.bill');


// Admin Logout
Route::get('/admin/logout',[AdminController::class,'logout'])->name('admin.logout');


// Authentication routes
require __DIR__.'/auth.php';
=======
use App\Http\Controllers\Vendor\VendorDealController;

// Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard — redirects based on role after login
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'vendor') {
        return redirect()->route('vendor.deals.index');
    } elseif ($user->role === 'admin') {
        return redirect()->route('home');
    } else {
        return redirect()->route('home');
    }
})->middleware(['auth'])->name('dashboard');

// Auth Routes
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// Force logout route
Route::get('/logout-now', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// Clear session route
Route::get('/clear-session', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// Vendor Routes
Route::middleware(['auth'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::resource('deals', VendorDealController::class);
    Route::post('notifications/{id}/read', [VendorDealController::class, 'markNotificationRead'])
         ->name('notifications.read');
});
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
