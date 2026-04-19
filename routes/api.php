<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealController;
use App\Http\Controllers\Payment\PaymentController;

Route::get('/deal/{id}', [DealController::class, 'getDeal']);
Route::post('/deal/join', [DealController::class, 'joinDeal']);
Route::post('/payment/request', [PaymentController::class, 'store']);
Route::put('/admin/payment/approve/{id}', [PaymentController::class, 'approve']);