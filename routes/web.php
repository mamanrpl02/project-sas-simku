<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\IzinPengajuanController;
use App\Http\Controllers\DashboardSiswaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ExportController;
use App\Livewire\Presensi;
use Illuminate\Support\Facades\Gate;


Route::get('/', function () {
    return view('index');
})->name('landing');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::middleware(['auth:siswa'])->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard');

    Route::get('/presensi', [PresensiController::class, 'presensi'])->name('presensi');
    Route::post('/presensi/masuk', [PresensiController::class, 'presensiMasuk'])->name('presensi.masuk');
    Route::post('/presensi/keluar', [PresensiController::class, 'presensiKeluar'])->name('presensi.keluar');



    Route::get('/pengajuan-izin', [PresensiController::class, 'create'])->name('pengajuan');
    Route::post('/pengajuan-izin', [PresensiController::class, 'store'])->name('siswa.izin.store');

    Route::get('/riwayat-transaksi', [DashboardSiswaController::class, 'riwayat'])->name('transaksi');
    Route::get('/pengeluaran-kas', [DashboardSiswaController::class, 'pengeluaranKas'])->name('pengeluaran-kas');
    Route::get('/pemasukan-kas', [DashboardSiswaController::class, 'pemasukanKas'])->name('pemasukan-kas');
    Route::get('/pemberitahuan-kas', [DashboardSiswaController::class, 'notifkas'])->name('notif.kas');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/siswa/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('siswa.logout');
});



Route::middleware(['auth', 'can:access-export'])->group(function () {
    Route::get('/export/presensi/{bulan?}', [ExportController::class, 'exportPresensi'])->name('presensi.export');

    Route::get('/export/debit/{bulan?}', [ExportController::class, 'exportDebit'])->name('debit.export');

    Route::get('/export/kredit/{bulan?}', [ExportController::class, 'exportkredit'])->name('kredit.export');

    Route::get('/export/pemasukanKas/{bulan?}', [ExportController::class, 'exportPemasukanKas'])->name('pemasukanKas.export');

    Route::get('/export/pengeluaranKas/{bulan?}', [ExportController::class, 'exportpengeluaranKas'])->name('pengeluaranKas.export');

    Route::get('/export/siswa', [ExportController::class, 'exportsiswa'])->name('siswa.export');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
