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

    // ROUTE SEMUA JAWABAN
    Route::get('all', [PertanyaanController::class, 'allResponse'])->name('allResponse');
    // DETAIL JAWABAN
    Route::get('responseDetail/{id}', [PertanyaanController::class, 'responseDetail'])->name('responseDetail');
    // ROUTE PER UNIT SMA
    Route::get('sortBySma', [PertanyaanController::class, 'sortBySma'])->name('sortBySma');
    // ROUTE PER UNIT SMP
    Route::get('sortBySmp', [PertanyaanController::class, 'sortBySmp'])->name('sortBySmp');
    // ROUTE PER UNIT ELEMENTARY
    Route::get('sortByEle', [PertanyaanController::class, 'sortByEle'])->name('sortByEle');
});

Route::prefix('student')
    ->middleware(['auth', 'role:siswa'])
    ->group(function () {
        Route::get('/', [PertanyaanController::class, 'index'])->name('dashboardSiswa');

        // HALAMAN PENILAIAN GURU
        Route::get('penilaianForm', [PertanyaanController::class, 'penilaianForm'])->name('penilaianForm');

        // SIMPAN DATA PENILAIAN
        Route::post('penilaianStore', [PertanyaanController::class, 'penilaianStore'])->name('penilaianStore');
});
