<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Siswa\PertanyaanController;
use App\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('welcome');
// });

// ===========================
// ROUTE LOGIN
// ===========================
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('prosLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ROUTE UNIT
    Route::resource('unit', UnitController::class);

    // ROUTE GURU
    Route::resource('guru', GuruController::class);

    // ROUTE SISWA
    Route::resource('siswa', SiswaController::class);
});

Route::prefix('student')
    ->middleware(['auth', 'role:siswa'])
    ->group(function () {
        Route::get('/', [PertanyaanController::class, 'index'])->name('dashboardSiswa');
});
