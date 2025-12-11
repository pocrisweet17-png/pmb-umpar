<?php

use App\Models\Registrasi;
use App\Models\ProgramStudy;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DokumentController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthRegisterController;
use Symfony\Component\HttpKernel\HttpCache\Store;
use App\Http\Controllers\MidtransCallbackController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\VerificationController;
use App\Models\User;
use App\Http\Controllers\BayarUktController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\WawancaraController;
use App\Http\Controllers\DaftarUlangController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\UserController;

// ====================
// MIDTRANS CALLBACK
// ====================
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'callback'])
    ->name('midtrans.callback');


// ====================
// LANDING PAGE
// ====================
Route::get('/', function () {
    return view('welcome');
});


// ====================
// API PRODI
// ====================
Route::get('/api/prodi-by-fakultas/{fakultas}', function ($fakultas) {
    return ProgramStudy::where('fakultas', $fakultas)
        ->orderBy('namaProdi')
        ->get(['kodeProdi', 'namaProdi', 'jenjang']);
});

Route::get('/api/prodi-by-fakultas', [ProdiController::class, 'getProdiByFakultas'])
    ->name('api.prodi-by-fakultas');


// ====================
// REGISTER
// ====================
Route::get('/register', [AuthRegisterController::class, 'showRegisterForm'])
    ->name('register.form');

Route::post('/register', [AuthRegisterController::class, 'register'])
    ->name('register');

// route verification (signed)
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify')
    ->middleware('signed');


// ====================
// LOGIN / LOGOUT
// ====================
Route::get('/login', [AuthLoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthLoginController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthLoginController::class, 'logout'])
    ->name('logout');


// ====================================================================
// AUTH USER ROUTES
// ====================================================================
Route::middleware('auth')->group(function () {

    // --------------------
    // DASHBOARD MAHASISWA
    // --------------------
    Route::get('/mahasiswa/dashboard', [MahasiswaDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('mahasiswa.dashboard');
    // --------------------
    // TAGIHAN & PEMBAYARAN
    // --------------------
    Route::get('/tagihan', [PaymentController::class, 'tagihan'])->name('tagihan');

    Route::get('/bayar/{tipe}', [PaymentController::class, 'bayar'])->name('bayar');

    Route::post('/midtrans/webhook', [PaymentController::class, 'webhook']);

    Route::get('/payment/finish', [PaymentController::class, 'selesai'])
        ->name('payment.finish');
});


// ====================================================================
// ADMIN DASHBOARD
// ====================================================================
Route::get('/admin/dashboard', function () {
    return 'Ini Dashboard Admin';
})->name('admin.dashboard')->middleware(['auth', AdminMiddleware::class]);
// Dashboard Admin
// Dashboard Admin
Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD Soal
    Route::get('/admin/soal', [SoalController::class, 'index'])->name('admin.soal.index');
    Route::get('/admin/soal/create', [SoalController::class, 'showSoal'])->name('admin.soal.create');
    Route::post('/admin/soal/store', [SoalController::class, 'createSoal'])->name('admin.soal.store');
    Route::get('/admin/soal/{id}/edit', [SoalController::class, 'edit'])->name('admin.soal.edit');
    Route::put('/admin/soal/{id}', [SoalController::class, 'update'])->name('admin.soal.update');
    Route::delete('/admin/soal/{id}', [SoalController::class, 'destroy'])->name('admin.soal.destroy');

    // CRUD User
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
});

// Route Ujian Mahasiswa
Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa/ujian', [UjianController::class, 'index'])->name('mahasiswa.ujian');
    Route::post('/mahasiswa/ujian/submit', [UjianController::class, 'submit'])->name('mahasiswa.ujian.submit');
    Route::get('/mahasiswa/hasil/{idUjian}', [UjianController::class, 'hasil'])->name('mahasiswa.hasil');
});




// 1. Pilih Prodi
Route::get('/pilih-prodi', [ProdiController::class, 'show'])
    ->middleware('auth',)
    ->name('prodi.view');

Route::post('/pilih-prodi', [ProdiController::class, 'store'])
    ->middleware('auth')
    ->name('prodi.store');


// 2. Bayar Pendaftaran
Route::get('/bayar-pendaftaran', [PaymentController::class, 'index'])
    ->middleware(['auth', 'step.prodi'])
    ->name('bayar.index');

Route::post('/bayar-pendaftaran', [PaymentController::class, 'store'])
    ->middleware(['auth', 'step.prodi'])
    ->name('bayar.store');
// QRIS Manual
Route::get('/qris', [PaymentController::class, 'qris'])->name('qris.view');
Route::post('/qris/upload', [PaymentController::class, 'uploadBukti'])->name('qris.upload');


// 3. Lengkapi Data
Route::get('/lengkapi-data', [PendaftaranController::class, 'index'])
    ->middleware(['auth', 'check.prodi', 'check.bayar'])
    ->name('pendaftaran.index');

Route::post('/lengkapi-data', [PendaftaranController::class, 'store'])
    ->middleware(['auth', 'check.prodi', 'check.bayar'])
    ->name('pendaftaran.store');


// 4. Upload Dokumen (DIPERTAHANKAN & DISERAGAMKAN)
Route::get('/upload-dokumen', [DokumentController::class, 'index'])
    ->middleware(['auth', 'check.prodi', 'check.bayar', 'check.lengkapi'])
    ->name('dokumen.index');

Route::post('/upload-dokumen', [DokumentController::class, 'store'])
    ->middleware(['auth', 'check.prodi', 'check.bayar', 'check.lengkapi'])
    ->name('dokumen.store');


// 5. Tes
Route::get('/tes', [TesController::class, 'index'])
    ->middleware(['auth', 'check.step4'])
    ->name('tes.index');

Route::post('/tes', [TesController::class, 'store'])
    ->middleware(['auth', 'check.step4'])
    ->name('tes.store');


// 6. Wawancara
Route::get('/wawancara', [WawancaraController::class, 'index'])
    ->middleware(['auth', 'check.step5'])
    ->name('wawancara.index');

Route::post('/wawancara', [WawancaraController::class, 'store'])
    ->middleware(['auth', 'check.step5'])
    ->name('wawancara.store');


// 7. Daftar Ulang
Route::get('/daftar-ulang', [DaftarUlangController::class, 'index'])
    ->middleware(['auth', 'check.step6'])
    ->name('daftar-ulang.index');

Route::post('/daftar-ulang', [DaftarUlangController::class, 'store'])
    ->middleware(['auth', 'check.step6'])
    ->name('daftar-ulang.store');


// 8. Bayar UKT
Route::get('/bayar-ukt', [BayarUktController::class, 'index'])
    ->middleware(['auth', 'check.step7'])
    ->name('ukt.index');

Route::post('/bayar-ukt', [BayarUktController::class, 'store'])
    ->middleware(['auth', 'check.step7'])
    ->name('ukt.store');
