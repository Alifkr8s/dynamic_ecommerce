<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Vendor\VendorDealController;
use App\Http\Controllers\Api\DealTrackingController;

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
        return redirect()->route('admin.orders');
    } else {
        return redirect()->route('home');
    }
})->middleware(['auth'])->name('dashboard');

// ==================== DEAL SYSTEM ====================
Route::get('/demo-deal', [DealController::class, 'demo'])->name('demo.deal');
Route::get('/deal/{id}', [DealController::class, 'show'])->name('deal.show');
Route::post('/deal/join', [DealController::class, 'join'])->name('deal.join');

// Participants Page
Route::get('/participants', function () {
    return view('participants');
})->name('participants.page');

// ==================== REAL-TIME DEAL TRACKING API ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/api/deals/{id}/status', [DealTrackingController::class, 'getDealStatus'])
         ->name('api.deals.status');
});

// ==================== ADMIN ROUTES ====================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::get('/bill/{id}', [AdminController::class, 'bill'])->name('bill');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
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