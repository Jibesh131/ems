<?php

use App\Http\Controllers\Admin\AdminControler;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\admin\TeacherController;
use Illuminate\Support\Facades\Route;

// admin is as prefix & name

Route::get('/',[AdminControler::class, 'index'])->name('dashboard');

Route::prefix('subject')->as('subject.')->group(function () {
    Route::get('list', [SubjectController::class, 'index'])->name('index');
    Route::get('add', [SubjectController::class, 'add'])->name('add');
    Route::get('edit/{id}', [SubjectController::class, 'edit'])->name('edit');
    Route::post('save/{id?}', [SubjectController::class, 'save'])->name('save');
    Route::get('delete/{id}', [SubjectController::class, 'delete'])->name('delete');
});

Route::prefix('teacher')->as('teacher.')->group(function () {
    Route::get('list', [TeacherController::class, 'index'])->name('index');
    Route::get('add', [TeacherController::class, 'add'])->name('add');
    Route::get('edit/{id}', [TeacherController::class, 'edit'])->name('edit');
    Route::post('save/{id?}', [TeacherController::class, 'save'])->name('save');
    Route::get('delete/{id}', [TeacherController::class, 'delete'])->name('delete');
});