<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Import Controller Custom Anda
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\DataTrainingController;
use App\Http\Controllers\KonsultasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN (LANDING PAGE)
Route::get('/', function () {
    return view('welcome'); // Ganti dengan view landing page skripsi Anda jika ada
});

/*
|--------------------------------------------------------------------------
| GROUP ROUTE: ADMINISTRATOR
| Middleware: Login + Role 'admin'
| URL Prefix: /admin/
| Route Name Prefix: admin.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    // URL: /admin/dashboard
    // Name: admin.dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // --- MANAJEMEN MASTER DATA ---
    
    // CRUD Kriteria (Fitur/Atribut)
    // URL: /admin/kriteria, /admin/kriteria/create, dll
    Route::resource('kriteria', KriteriaController::class);

    // CRUD Jurusan (Class/Label)
    Route::resource('jurusan', JurusanController::class);

    // --- MANAJEMEN DATASET KNN ---

    // CRUD Data Training (Data Alumni)
    Route::resource('datatraining', DataTrainingController::class);
    
    // (Opsional) Fitur Import Excel Data Training
    // Route::post('/datatraining/import', [DataTrainingController::class, 'import'])->name('datatraining.import');

    // --- LAPORAN ---
    // Melihat seluruh riwayat konsultasi siswa
    Route::get('/laporan-konsultasi', [KonsultasiController::class, 'laporan'])->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| GROUP ROUTE: SISWA
| Middleware: Login + Role 'siswa'
| URL Prefix: /siswa/
| Route Name Prefix: siswa.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    // Dashboard Siswa
    // URL: /siswa/dashboard
    // Name: siswa.dashboard
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');

    // --- FITUR UTAMA: KONSULTASI / TES MINAT ---

    // 1. Form Tes Minat (Input Nilai)
    Route::get('/tes-minat', [KonsultasiController::class, 'create'])->name('konsultasi.create');

    // 2. Proses Hitung KNN (Action Submit Form)
    Route::post('/tes-minat', [KonsultasiController::class, 'store'])->name('konsultasi.store');

    // 3. Riwayat Hasil Tes Saya
    Route::get('/riwayat', [KonsultasiController::class, 'index'])->name('konsultasi.index');

    // 4. Detail Hasil Tes (Lihat Perhitungan/Detail)
    Route::get('/riwayat/{id}', [KonsultasiController::class, 'show'])->name('konsultasi.show');
});

/*
|--------------------------------------------------------------------------
| GROUP ROUTE: PROFILE (BAWAAN BREEZE)
| Bisa diakses Admin & Siswa
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load route auth bawaan (login, register, logout)
require __DIR__.'/auth.php';