<?php

use App\Http\Controllers\Admin\AdminControler;
use Illuminate\Support\Facades\Route;

// Route::get('/',[AdminControler::class, 'index'])->name('dashboard');

Route::get('/dashboard', function () {
    return "Admin Dashboard";
});

Route::get('/', function () {
    return "Admin Home";
});