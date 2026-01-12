<?php

use App\Http\Controllers\Teacher\AvailabilityController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TeacherController::class, 'index'])->name('dashboard');

Route::prefix('availability')->as('availability.')->group(function() {
    Route::get('list', [AvailabilityController::class, 'index'])->name('index');
    Route::get('add', [AvailabilityController::class, 'add'])->name('add');
    Route::get('edit/{id}', [AvailabilityController::class, 'edit'])->name('edit');
    Route::post('save/{id?}', [AvailabilityController::class, 'save'])->name('save');
    Route::get('delete/{id}', [AvailabilityController::class, 'delete'])->name('delete');
    Route::get('getFees/{id}', [AvailabilityController::class, 'getFees'])->name('getFees');
});