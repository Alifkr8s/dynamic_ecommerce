<?php

use Illuminate\Support\Facades\Route;
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