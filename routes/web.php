<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentsController; 
use App\Http\Controllers\coursesController; 
use App\Http\Controllers\subjectController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('students.index')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('students/export', [studentsController::class, 'exportCSV'])->name('students.export');
    Route::post('students/import', [studentsController::class, 'importCSV'])->name('students.import');
    Route::resource('students', studentsController::class);
    Route::resource('courses', coursesController::class); 
    Route::resource('subjects', subjectController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name("login");
    Route::post('/login', [AuthController::class, 'login'])->name("login.submit");
});