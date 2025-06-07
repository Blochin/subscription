<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/payments/process', [PaymentController::class, 'process'])->name('payments.process');