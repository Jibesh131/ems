<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'loginView'])->name('login.view');
    Route::post('login', [AdminAuthController::class, 'loginPost'])->name('login.post');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::prefix('teacher')->as('teacher.')->group(function (){
    Route::get('login', [TeacherAuthController::class, 'loginView'])->name('login.view');
    Route::post('login', [TeacherAuthController::class, 'loginPost'])->name('login.post');
    Route::get('logout', [TeacherAuthController::class, 'logout'])->name('logout');
});

Route::as('user.')->group(function () {
    Route::get('login', [UserAuthController::class, 'loginView'])->name('login.view');
    Route::post('login', [UserAuthController::class, 'loginPost'])->name('login.post');
    Route::get('signup', [UserAuthController::class, 'signupView'])->name('signup.view');
    Route::post('signup', [UserAuthController::class, 'signupPost'])->name('signup.post');
    Route::get('logout', [UserAuthController::class, 'logout'])->name('logout');
});