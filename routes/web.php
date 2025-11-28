<?php

use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Models\ProgramStudy;
use App\Http\Controllers\DokumentController;
use Symfony\Component\HttpKernel\HttpCache\Store;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
     ->name('pendaftaran.form');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
     ->name('pendaftaran.store');
Route::get('/pendaftaran/sukses', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');

Route::get('/api/prodi-by-fakultas/{fakultas}', function ($fakultas) {
    return ProgramStudy::where('fakultas', $fakultas)
        ->orderBy('namaProdi')
        ->get(['kodeProdi', 'namaProdi', 'jenjang']);
});

Route::get('/upload-dokumen', [DokumentController::class, 'index'])->name('dokumen.form');
Route::post('/upload-dokumen', [DokumentController::class, 'store'])->name('dokumen.store');

// register
Route::get('/register', [AuthRegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthRegisterController::class, 'register'])->name('register');


// Login
Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthLoginController::class, 'login'])->name('login.process');

// Logout
Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return 'Ini Dashboard Admin';
})->name('admin.dashboard')->middleware(['auth', AdminMiddleware::class]);

// Dashboard Mahasiswa
Route::get('/mahasiswa/dashboard', function () {
    return 'Ini Dashboard Mahasiswa';
})->name('mahasiswa.dashboard')->middleware('auth');
