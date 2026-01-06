<?php

use App\Http\Controllers\auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'loginView'])->name('login.view');
    Route::post('login', [AdminAuthController::class, 'loginPost'])->name('login.post');
});