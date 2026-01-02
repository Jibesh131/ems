<?php

use App\Http\Controllers\Admin\AdminControler;
use App\Http\Controllers\Admin\SubjectController;
use Illuminate\Support\Facades\Route;

// admin is as prefix & name

Route::get('/',[AdminControler::class, 'index'])->name('dashboard');

Route::prefix('subject')->as('subject.')->group(function () {
    Route::get('list', [SubjectController::class, 'index'])->name('index');
    Route::get('add', [SubjectController::class, 'add'])->name('add.view');
    Route::post('add', [SubjectController::class, 'index'])->name('add.post');
});