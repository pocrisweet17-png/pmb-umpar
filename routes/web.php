<?php

use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrasi', [RegistrasiController::class, 'create'])->name('registrasi.create');
Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');
