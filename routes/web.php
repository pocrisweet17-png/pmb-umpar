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
use App\Http\Middleware\AdminMiddleware;

// ======================================================================
// PUBLIC ROUTES
// ======================================================================
Route::get('/', fn() => view('welcome'));

// Register & Login
Route::get('/register', [AuthRegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthRegisterController::class, 'register'])->name('register');
Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthLoginController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');

// Email Verification
Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = \App\Models\Registrasi::findOrFail($id);
    if ($hash !== sha1($user->email)) abort(403);
    $user->email_verified_at = now();
    $user->save();
    return view('emails.verified-success');
})->name('verification.verify')->middleware('signed');

// API Prodi (public)
Route::get('/api/prodi-by-fakultas/{fakultas}', function ($fakultas) {
    return \App\Models\ProgramStudy::where('fakultas', $fakultas)
        ->orderBy('namaProdi')
        ->get(['kodeProdi', 'namaProdi', 'jenjang']);
});

Route::get('/api/prodi-by-fakultas', [ProdiController::class, 'getProdiByFakultas'])
    ->name('api.prodi-by-fakultas');

// Midtrans Webhook (public)
Route::post('/midtrans/webhook', [PaymentController::class, 'webhook'])
    ->name('midtrans.webhook');

// ======================================================================
// AUTHENTICATED ROUTES (harus login)
// ======================================================================
Route::middleware('auth')->group(function () {

    Route::get('/mahasiswa/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');

    Route::get('/pilih-prodi', [ProdiController::class, 'show'])->name('prodi.view');
    Route::post('/prodi/store', [ProdiController::class, 'store'])->name('prodi.store');

    // API Status Check
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
        ]);
    });

    // Notification
    Route::post('/notification/mark-read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notification.mark-read');

    // Payment Status Check (bisa diakses semua authenticated user)
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/payment/poll-status', [PaymentController::class, 'pollStatus'])->name('payment.poll');
    Route::get('/payment/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check');
    Route::get('/payment/check-ukt-status', [BayarUktController::class, 'checkStatus'])
        ->name('ukt.check-status');
});

// ======================================================================
// VERIFIED & STEP-BY-STEP ROUTES (harus login DAN verified email)
// ======================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // STEP 1: Prodi (sudah ada di atas)

    // STEP 2: Bayar Pendaftaran
    Route::middleware('step.prodi')->group(function () {
        Route::get('/bayar', [PaymentController::class, 'index'])->name('bayar.index');
        Route::post('/bayar/store', [PaymentController::class, 'store'])->name('bayar.store');
        Route::post('/bayar/upload-manual', [PaymentController::class, 'uploadBukti'])->name('bayar.upload');
        
        // Aliases
        Route::get('/bayar-pendaftaran', [PaymentController::class, 'index'])->name('bayar.index.pendaftaran');
        Route::post('/bayar-pendaftaran', [PaymentController::class, 'store'])->name('bayar.store.pendaftaran');
        Route::post('/qris/upload', [PaymentController::class, 'uploadBukti'])->name('qris.upload');
    });

    // STEP 3: Lengkapi Data
    Route::middleware(['step.prodi', 'check.bayar'])->group(function () {
        Route::get('/lengkapi-data', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::post('/lengkapi-data', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
    });

    // STEP 4: Upload Dokumen
    Route::middleware(['step.prodi', 'check.bayar', 'check.lengkapi'])->group(function () {
        Route::get('/upload-dokumen', [DokumentController::class, 'index'])->name('dokumen.index');
        Route::post('/upload-dokumen', [DokumentController::class, 'store'])->name('dokumen.store');
    });

    // STEP 5: Tes
    Route::middleware(['check.upload'])->group(function () {
        Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
        Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
        
        Route::get('/mahasiswa/ujian', [UjianController::class, 'index'])->name('mahasiswa.ujian');
        Route::post('/mahasiswa/ujian/submit', [UjianController::class, 'submit'])->name('mahasiswa.ujian.submit');
        Route::get('/mahasiswa/hasil/{idUjian}', [UjianController::class, 'hasil'])->name('mahasiswa.hasil');
});

    // STEP 6: Wawancara
    Route::middleware(['check.tes'])->group(function () {
        Route::get('/wawancara', [WawancaraController::class, 'index'])->name('wawancara.index');
        Route::post('/wawancara', [WawancaraController::class, 'store'])->name('wawancara.store');
    });

    // STEP 7: Bayar UKT
    Route::middleware(['check.wawancara'])->group(function () {
        Route::get('/bayar-ukt', [BayarUktController::class, 'index'])->name('ukt.index');
        Route::post('/bayar-ukt', [BayarUktController::class, 'store'])->name('ukt.store');
        Route::post('/bayar-ukt/upload-manual', [BayarUktController::class, 'uploadBukti'])->name('ukt.upload');
    });

    // STEP 8: Daftar Ulang
    Route::middleware(['check.ukt'])->group(function () {
        Route::get('/daftar-ulang', [DaftarUlangController::class, 'index'])->name('daftar-ulang.index');
        Route::post('/daftar-ulang', [DaftarUlangController::class, 'store'])->name('daftar-ulang.store');
    });

});

// ======================================================================
// ADMIN ROUTES
// ======================================================================
Route::get('/admin/dashboard', fn() => 'Ini Dashboard Admin')
    ->name('admin.dashboard')
    ->middleware(['auth', AdminMiddleware::class]);

// ======================================================================
// TEST ROUTES
// ======================================================================
Route::get('/test-snap', function() {
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
    
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
    ];
    
    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return response()->json([
            'snap_token' => $snapToken,
            'success' => true
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'success' => false
        ]);
    }
})->middleware('auth');

// ======================================================================
// UKT POLLING (harus di luar middleware step agar bisa diakses kapan saja)
// ======================================================================
Route::get('/payment/poll-ukt-status', function(\Illuminate\Http\Request $request) {
    if (!Auth::check()) {
        return response()->json(['status' => 'unauthorized'], 401);
    }
    
    $orderId = $request->query('order_id');
    $payment = \App\Models\Payment::where('order_id', $orderId)
        ->where('tipe_pembayaran', 'ukt')
        ->where('user_id', Auth::id())
        ->first();
    
    if (!$payment) {
        return response()->json([
            'status' => 'not_found',
            'message' => 'Payment not found'
        ], 404);
    }
    
    return response()->json([
        'status' => $payment->status_transaksi,
        'is_ukt_paid' => $payment->user->is_ukt_paid ?? false
    ]);
})->name('ukt.poll-status')->middleware('auth');
