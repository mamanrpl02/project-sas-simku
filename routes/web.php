<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardSiswaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:siswa'])->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard');
    Route::get('/riwayat-transaksi', [DashboardSiswaController::class, 'riwayat'])->name('transaksi');
    Route::get('/pengeluaran-kas', [DashboardSiswaController::class, 'catatankas'])->name('pengeluaran-kas');
    Route::get('/pemberitahuan-kas', [DashboardSiswaController::class, 'notifkas'])->name('notif.kas');

    Route::post('/siswa/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('siswa.logout');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
