<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DokumentController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\BayarUktController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\WawancaraController;
use App\Http\Controllers\DaftarUlangController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\ProgramStudy;
use App\Models\Registrasi;
use App\Http\Controllers\MahasiswaDashboardController;


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


// ====================
// EMAIL VERIFICATION
// ====================
Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = Registrasi::findOrFail($id);

    if ($hash !== sha1($user->email)) abort(403);

    $user->email_verified_at = now();
    $user->save();

    return view('emails.verified-success');
})
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
})
->name('admin.dashboard')
->middleware(['auth', AdminMiddleware::class]);




// 1. Pilih Prodi
Route::get('/pilih-prodi', [ProdiController::class, 'show'])
    ->middleware('auth')
    ->name('prodi.view');

Route::post('/pilih-prodi', [ProdiController::class, 'store'])
    ->middleware('auth')
    ->name('prodi.store');


// 2. Bayar Pendaftaran
Route::get('/bayar-pendaftaran', [PaymentController::class, 'index'])
    ->middleware(['auth', 'check.prodi'])
    ->name('bayar.index');

Route::post('/bayar-pendaftaran', [PaymentController::class, 'store'])
    ->middleware(['auth', 'check.prodi'])
    ->name('bayar.store');


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
