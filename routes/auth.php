<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\TeacherAuthController;
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