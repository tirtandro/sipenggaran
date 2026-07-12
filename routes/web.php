<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SanksiController;
use App\Http\Controllers\SuratPeringatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisPelanggaranController;
use App\Http\Controllers\TahunAjaranController;

// Rute root dialihkan ke login atau dashboard
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Murid (Semua role terautentikasi bisa melihat)
    Route::get('/murid', [MuridController::class, 'index'])->name('murid.index');

    // Admin-only untuk kelola murid & Import/Template Excel
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/murid/create', [MuridController::class, 'create'])->name('murid.create');
        Route::post('/murid', [MuridController::class, 'store'])->name('murid.store');
        Route::get('/murid/download-template', [MuridController::class, 'downloadTemplate'])->name('murid.download-template');
        Route::post('/murid/import-excel', [MuridController::class, 'importExcel'])->name('murid.import-excel');
        Route::get('/murid/{murid}/edit', [MuridController::class, 'edit'])->name('murid.edit');
        Route::put('/murid/{murid}', [MuridController::class, 'update'])->name('murid.update');
        Route::delete('/murid/{murid}', [MuridController::class, 'destroy'])->name('murid.destroy');
    });

    Route::get('/murid/{murid}', [MuridController::class, 'show'])->name('murid.show');

    // Catat Pelanggaran (Admin, Guru BK, Guru Piket)
    Route::middleware(['role:admin,guru_bk,guru_piket'])->group(function () {
        Route::get('/pelanggaran/create', [PelanggaranController::class, 'create'])->name('pelanggaran.create');
        Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
        Route::get('/pelanggaran/{pelanggaran}/edit', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
        Route::put('/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
    });

    // Admin-only untuk hapus pelanggaran
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
    });

    // Riwayat Pelanggaran (Semua role bisa melihat)
    Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::get('/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'show'])->name('pelanggaran.show');

    // Sanksi (Admin & Guru BK)
    Route::middleware(['role:admin,guru_bk'])->group(function () {
        Route::get('/sanksi', [SanksiController::class, 'index'])->name('sanksi.index');
        Route::get('/sanksi/create', [SanksiController::class, 'create'])->name('sanksi.create');
        Route::post('/sanksi', [SanksiController::class, 'store'])->name('sanksi.store');
        Route::patch('/sanksi/{sanksi}/status', [SanksiController::class, 'updateStatus'])->name('sanksi.update-status');
    });

    // Surat Peringatan (Admin, Guru BK, Wali Kelas)
    Route::middleware(['role:admin,guru_bk,wali_kelas'])->group(function () {
        Route::get('/surat', [SuratPeringatanController::class, 'index'])->name('surat.index');
        Route::get('/surat/create', [SuratPeringatanController::class, 'create'])->name('surat.create');
        Route::post('/surat', [SuratPeringatanController::class, 'store'])->name('surat.store');
        Route::get('/surat/{surat}/cetak', [SuratPeringatanController::class, 'cetak'])->name('surat.cetak');
    });

    // Laporan (Semua role)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

    // Referensi Tata Tertib (Semua role)
    Route::get('/referensi', [JenisPelanggaranController::class, 'index'])->name('referensi.index');
    
    // Admin-only untuk kelola referensi tata tertib
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/referensi/create', [JenisPelanggaranController::class, 'create'])->name('referensi.create');
        Route::post('/referensi', [JenisPelanggaranController::class, 'store'])->name('referensi.store');
        Route::get('/referensi/{jenisPelanggaran}/edit', [JenisPelanggaranController::class, 'edit'])->name('referensi.edit');
        Route::put('/referensi/{jenisPelanggaran}', [JenisPelanggaranController::class, 'update'])->name('referensi.update');
        Route::delete('/referensi/{jenisPelanggaran}', [JenisPelanggaranController::class, 'destroy'])->name('referensi.destroy');
    });

    // Manajemen User & Tahun Ajaran (Admin-only)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
        Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
        Route::post('/tahun-ajaran/{tahunAjaran}/aktifkan', [TahunAjaranController::class, 'aktifkan'])->name('tahun-ajaran.aktifkan');
        Route::resource('users', UserController::class);
    });
});
