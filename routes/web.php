<?php

use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Models\ProgramStudy;
use App\Http\Controllers\DokumentController;
use Symfony\Component\HttpKernel\HttpCache\Store;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/registrasi', [RegistrasiController::class, 'create'])->name('registrasi.create');
Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');


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

