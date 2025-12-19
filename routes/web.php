<?php

use App\Models\User;
use App\Models\Registrasi;
use App\Models\ProgramStudy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BayarUktController;
use Illuminate\Http\Request;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DokumentController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\WawancaraController;
use App\Http\Controllers\DaftarUlangController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerificationController;
use Symfony\Component\HttpKernel\HttpCache\Store;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\MahasiswaController;

// Midtrans Webhook - TANPA CSRF & AUTH
Route::post('/midtrans/webhook', [PaymentController::class, 'webhook'])
    ->name('midtrans.webhook');
// ======================================================================
// LANDING PAGE
// ======================================================================
Route::get('/', fn() => view('welcome'));

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
// REGISTER
// ======================================================================
Route::get('/register', [AuthRegisterController::class, 'showRegisterForm'])
    ->name('register.form');
Route::post('/register', [AuthRegisterController::class, 'register'])
    ->name('register');

// ======================================================================
// EMAIL VERIFICATION
// ======================================================================
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ======================================================================
// LOGIN / LOGOUT
// ======================================================================
Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthLoginController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');

// ======================================================================
// AUTH USER ROUTES
// ======================================================================
Route::middleware('auth')->group(function () {

    Route::get('/mahasiswa/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');

    Route::get('/pilih-prodi', [ProdiController::class, 'show'])->name('prodi.view');
    Route::post('/prodi/store', [ProdiController::class, 'store'])->name('prodi.store');
});

// ======================================================================
// VERIFIED USER ROUTES
// ======================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // ======================================================================
    // 2. PEMBAYARAN PENDAFTARAN
    // ======================================================================
    Route::middleware('step.prodi')->group(function () {
        Route::get('/bayar', [PaymentController::class, 'index'])->name('bayar.index');
        Route::post('/bayar/store', [PaymentController::class, 'store'])->name('bayar.store');
        Route::post('/bayar/upload-manual', [PaymentController::class, 'uploadBukti'])->name('bayar.upload');
    });

    // Payment finish & status routes
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/payment/poll-status', [PaymentController::class, 'pollStatus'])->name('payment.poll');
    Route::get('/payment/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check');

    // Notification routes
    Route::post('/notification/mark-read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.mark-read');

    // ======================================================================
    // 3. LENGKAPI DATA
    // ======================================================================
    Route::middleware(['step.prodi', 'check.bayar'])->group(function () {
        Route::get('/lengkapi-data', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::post('/lengkapi-data', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
    });

    // ======================================================================
    // 4. UPLOAD DOKUMEN
    // ======================================================================
    Route::middleware(['step.prodi', 'check.bayar', 'check.lengkapi'])->group(function () {
        Route::get('/upload-dokumen', [DokumentController::class, 'index'])->name('dokumen.index');
        Route::post('/upload-dokumen', [DokumentController::class, 'store'])->name('dokumen.store');
    });

    // ======================================================================
    // 5. TES
    // ======================================================================
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
        Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
        
        Route::get('/mahasiswa/ujian', [UjianController::class, 'index'])->name('mahasiswa.ujian');
        Route::post('/mahasiswa/ujian/submit', [UjianController::class, 'submit'])->name('mahasiswa.ujian.submit');
        Route::get('/mahasiswa/hasil/{idUjian}', [UjianController::class, 'hasil'])->name('mahasiswa.hasil');
});

    // ======================================================================
    // 6. WAWANCARA
    // ======================================================================
    Route::middleware(['check.tes'])->group(function () {
        Route::get('/wawancara', [WawancaraController::class, 'index'])->name('wawancara.index');
        Route::post('/wawancara', [WawancaraController::class, 'store'])->name('wawancara.store');
    });

    // ======================================================================
    // 7. BAYAR UKT
    // ======================================================================
    Route::middleware(['check.wawancara'])->group(function () {
        Route::get('/bayar-ukt', [BayarUktController::class, 'index'])->name('ukt.index');
        Route::post('/bayar-ukt', [BayarUktController::class, 'store'])->name('ukt.store');
        Route::post('/bayar-ukt/upload-manual', [BayarUktController::class, 'uploadBukti'])->name('ukt.upload');
    });

    // UKT status check
    Route::get('/payment/check-ukt-status', [BayarUktController::class, 'checkStatus'])
        ->name('ukt.check-status');

    // ======================================================================
    // 8. DAFTAR ULANG
    // ======================================================================
    Route::middleware('check.ukt')->group(function () {
        Route::get('/daftar-ulang', [DaftarUlangController::class, 'index'])->name('daftar-ulang.index');
        Route::post('/daftar-ulang', [DaftarUlangController::class, 'store'])->name('daftar-ulang.store');
    });
});

// ======================================================================
// API CEK STATUS
// ======================================================================
Route::get('/api/check-registration-status', function () {
    $user = Auth::user();
    return response()->json([
        'prodi_selected'        => (bool) $user->is_prodi_selected,
        'pembayaran_completed'  => (bool) $user->is_bayar_pendaftaran,
        'data_pribadi_completed'=> (bool) $user->is_data_completed,
        'dokumen_uploaded'      => (bool) $user->is_dokumen_uploaded,
        'tes_selesai'           => (bool) $user->is_tes_selesai,
        'wawancara_selesai'     => (bool) $user->is_wawancara_selesai,
        'ukt_paid'              => (bool) $user->is_ukt_paid,
        'daftar_ulang'          => (bool) $user->is_daftar_ulang,
        'redirect_url'          => route('mahasiswa.dashboard')
    ]);
})->middleware('auth');

// ======================================================================
// ADMIN DASHBOARD
// ======================================================================
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
    Route::get('/admin/user/{id}', [UserController::class, 'show'])->name('admin.user.show'); 
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/mahasiswa/daftar-ulang', [MahasiswaController::class, 'daftarUlang'])->name('admin.user.daftar-ulang');
    Route::post('/mahasiswa/{id}/verify-daftar-ulang', [MahasiswaController::class, 'verifyDaftarUlang'])->name('admin.mahasiswa.verify-daftar-ulang');
    Route::post('/mahasiswa/{id}/reject-daftar-ulang', [MahasiswaController::class, 'rejectDaftarUlang'])->name('admin.mahasiswa.reject-daftar-ulang');
});
