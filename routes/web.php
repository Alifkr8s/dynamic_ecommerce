<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\VendorDealController;
use App\Http\Controllers\Api\DealTrackingController;

// Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'vendor') {
        return redirect()->route('vendor.deals.index');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// Auth Routes
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// Force logout
Route::get('/logout-now', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// Clear session
Route::get('/clear-session', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// Real-time deal tracking API (accessible to auth users)
Route::middleware(['auth'])->group(function () {
    Route::get('/api/deals/{id}/status', [DealTrackingController::class, 'getDealStatus'])
         ->name('api.deals.status');
});

// Vendor Routes
Route::middleware(['auth'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::resource('deals', VendorDealController::class);
    Route::post('notifications/{id}/read', [VendorDealController::class, 'markNotificationRead'])
         ->name('notifications.read');
});