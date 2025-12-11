<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
use App\Http\Controllers\MahasiswaDashboardController;

use App\Http\Middleware\AdminMiddleware;
use App\Models\ProgramStudy;
use App\Models\Registrasi;

// ======================================================================
// API PRODI
// ======================================================================
Route::get('/api/prodi-by-fakultas/{fakultas}', function ($fakultas) {
    return ProgramStudy::where('fakultas', $fakultas)
        ->orderBy('namaProdi')
        ->get(['kodeProdi', 'namaProdi', 'jenjang']);
});

Route::get('/api/prodi-by-fakultas', [ProdiController::class, 'getProdiByFakultas'])
    ->name('api.prodi-by-fakultas');

// ======================================================================
// MIDTRANS WEBHOOK (PUBLIC)
// ======================================================================
Route::post('/midtrans/webhook', [PaymentController::class, 'webhook'])
    ->name('midtrans.webhook');

// ======================================================================
// LANDING PAGE
// ======================================================================
Route::get('/', fn() => view('welcome'));

// ======================================================================
// REGISTER
// ======================================================================
Route::get('/register', [AuthRegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthRegisterController::class, 'register'])->name('register');

// ======================================================================
// EMAIL VERIFICATION
// ======================================================================
Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = Registrasi::findOrFail($id);
    if ($hash !== sha1($user->email)) abort(403);

    $user->email_verified_at = now();
    $user->save();

    return view('emails.verified-success');
})->name('verification.verify')->middleware('signed');

// ======================================================================
// LOGIN / LOGOUT
// ======================================================================
Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthLoginController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');

// ======================================================================
// MAHASISWA DASHBOARD
// ======================================================================
Route::middleware('auth')->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');
});

// ======================================================================
// PEMBAYARAN (Midtrans + Manual Upload)
// ======================================================================
Route::middleware(['auth', 'verified', 'step.prodi'])->group(function () {

    Route::get('/bayar', [PaymentController::class, 'index'])->name('bayar.index');
    Route::post('/bayar/store', [PaymentController::class, 'store'])->name('bayar.store');

    // Upload bukti manual
    Route::post('/bayar/upload-manual', [PaymentController::class, 'uploadBukti'])
        ->name('bayar.upload');
});

// Midtrans redirect (satu kali saja)
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

// ======================================================================
// ADMIN DASHBOARD
// ======================================================================
Route::get('/admin/dashboard', fn() => 'Ini Dashboard Admin')
    ->middleware(['auth', AdminMiddleware::class])
    ->name('admin.dashboard');

// ======================================================================
// 1. PILIH PRODI
// ======================================================================
Route::middleware('auth')->group(function () {
    Route::get('/pilih-prodi', [ProdiController::class, 'show'])->name('prodi.view');
    Route::post('/prodi/store', [ProdiController::class, 'store'])->name('prodi.store');
});

// ======================================================================
// 2. PEMBAYARAN PENDAFTARAN (QRIS)
// ======================================================================
Route::middleware(['auth', 'step.prodi'])->group(function () {
    Route::get('/bayar-pendaftaran', [PaymentController::class, 'index'])->name('bayar.index.pendaftaran');
    Route::post('/bayar-pendaftaran', [PaymentController::class, 'store'])->name('bayar.store.pendaftaran');
    Route::post('/bayar-ukt/upload-manual', [PaymentController::class, 'uploadBukti'])
        ->name('ukt.upload');
});

// Upload bukti qris
Route::post('/qris/upload', [PaymentController::class, 'uploadBukti'])->name('qris.upload');

// ======================================================================
// 3. LENGKAPI DATA
// ======================================================================
Route::middleware(['auth', 'step.prodi', 'check.bayar'])->group(function () {
    Route::get('/lengkapi-data', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/lengkapi-data', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
});

// ======================================================================
// 4. UPLOAD DOKUMEN
// ======================================================================
Route::middleware(['auth', 'step.prodi', 'check.bayar', 'check.lengkapi'])->group(function () {
    Route::get('/upload-dokumen', [DokumentController::class, 'index'])->name('dokumen.index');
    Route::post('/upload-dokumen', [DokumentController::class, 'store'])->name('dokumen.store');
});

// ======================================================================
// 5. TES
// ======================================================================
Route::middleware(['auth', 'check.upload'])->group(function () {
    Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
    Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
});

// ======================================================================
// 6. WAWANCARA
// ======================================================================
Route::middleware(['auth', 'check.tes'])->group(function () {
    Route::get('/wawancara', [WawancaraController::class, 'index'])->name('wawancara.index');
    Route::post('/wawancara', [WawancaraController::class, 'store'])->name('wawancara.store');
});

// ======================================================================
// 7. BAYAR UKT
// ======================================================================
Route::middleware(['auth', 'check.before.ukt'])->group(function () {
    Route::get('/bayar-ukt', [BayarUktController::class, 'index'])->name('ukt.index');
    Route::post('/bayar-ukt', [BayarUktController::class, 'store'])->name('ukt.store');
    Route::post('/bayar-ukt/upload-manual', [BayarUktController::class, 'uploadBukti'])
        ->name('ukt.upload');
});

// ======================================================================
// 8. DAFTAR ULANG
// ======================================================================
Route::middleware(['auth', 'check.ukt'])->group(function () {
    Route::get('/daftar-ulang', [DaftarUlangController::class, 'index'])->name('daftar-ulang.index');
    Route::post('/daftar-ulang', [DaftarUlangController::class, 'store'])->name('daftar-ulang.store');
});

// ======================================================================
// API CEK STATUS
// ======================================================================
Route::get('/api/check-registration-status', function() {
    $user = Auth::user();
    return response()->json([
        'prodi_selected'     => (bool) $user->is_prodi_selected,
        'pembayaran_completed' => (bool) $user->is_bayar_pendaftaran,
        'data_pribadi_completed' => (bool) $user->is_data_completed,
        'dokumen_uploaded'   => (bool) $user->is_dokumen_uploaded,
        'tes_selesai'        => (bool) $user->is_tes_selesai,
        'wawancara_selesai'  => (bool) $user->is_wawancara_selesai,
        'ukt_paid'           => (bool) $user->is_ukt_paid,
        'daftar_ulang'       => (bool) $user->is_daftar_ulang,
        'redirect_url'       => route('mahasiswa.dashboard')
    ]);
})->middleware('auth');
