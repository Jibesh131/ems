<?php

use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\User\AvailabilityController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('index');

Route::get('/', [UserController::class, 'index'])->name('user.dashboard');
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

Route::as('web.')->group(function () {
    Route::prefix('availability')->as('availability.')->group( function() {
        Route::get('/', [AvailabilityController::class, 'index'])->name('index');
    });
    
});


Route::get('/checkout', [StripeController::class, 'checkout'])->name('payment.checkout');
Route::get('/success', [StripeController::class, 'success'])->name('payment.success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('payment.cancel');