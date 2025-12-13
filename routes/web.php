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
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\ProgramStudy;
use App\Models\Registrasi;
use App\Illuminate\Support\Facades\Config;

// ======================================================================
// MIDTRANS WEBHOOK
// ======================================================================
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
    // 2. PEMBAYARAN PENDAFTARAN (SEMUA VERSI DIGABUNG)
    // ======================================================================
    Route::middleware('step.prodi')->group(function () {

        // Route utama
        Route::get('/bayar', [PaymentController::class, 'index'])->name('bayar.index');
        Route::post('/bayar/store', [PaymentController::class, 'store'])->name('bayar.store');
        Route::post('/bayar/upload-manual', [PaymentController::class, 'uploadBukti'])->name('bayar.upload');

        // Route alternatif
        Route::get('/bayar-pendaftaran', [PaymentController::class, 'index'])->name('bayar.index.pendaftaran');
        Route::post('/bayar-pendaftaran', [PaymentController::class, 'store'])->name('bayar.store.pendaftaran');

        // Alias upload QRIS
        Route::post('/qris/upload', [PaymentController::class, 'uploadBukti'])->name('qris.upload');
    });

    // Midtrans redirect
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    
    // PERBAIKAN: Pindahkan route ini ke luar middleware step.prodi
    Route::get('/payment/poll-status', [PaymentController::class, 'pollStatus'])->name('payment.poll');
    Route::get('/payment/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check');

    // Route untuk notifikasi
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
    Route::middleware(['check.upload'])->group(function () {
        Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
        Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
    });

    // ======================================================================
    // 6. WAWANCARA
    // ======================================================================
    Route::middleware(['check.tes'])->group(function () {
        Route::get('/wawancara', [WawancaraController::class, 'index'])->name('wawancara.index');
        Route::post('/wawancara', [WawancaraController::class, 'store'])->name('wawancara.store');
    });

    // ======================================================================
    // 7. BAYAR UKT (VERSI HEAD + PARENT DIGABUNG)
    // ======================================================================
    Route::middleware(['check.wawancara'])->group(function () {
        Route::get('/bayar-ukt', [BayarUktController::class, 'index'])->name('ukt.index');
        Route::post('/bayar-ukt', [BayarUktController::class, 'store'])->name('ukt.store');
        Route::post('/bayar-ukt/upload-manual', [BayarUktController::class, 'uploadBukti'])->name('ukt.upload');
    });
    
    // PERBAIKAN: Route untuk check status UKT - TIDAK perlu middleware step.prodi
    Route::get('/payment/check-ukt-status', [BayarUktController::class, 'checkStatus'])
        ->name('ukt.check-status')
        ->middleware('auth');
});

// Route untuk polling status - LETAKKAN DI LUAR agar bisa diakses tanpa middleware step.prodi
Route::get('/payment/poll-ukt-status', function(\Illuminate\Http\Request $request) {
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
    
    // Jika settlement, update user
    if ($payment->status_transaksi === 'settlement') {
        $user = $payment->user;
        if ($user && !$user->is_ukt_paid) {
            $user->is_ukt_paid = true;
            $user->save();
        }
    }
    
    return response()->json([
        'status' => $payment->status_transaksi,
        'is_ukt_paid' => $payment->user->is_ukt_paid ?? false
    ]);
})->name('ukt.poll-status')->middleware('auth');

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
Route::get('/admin/dashboard', fn() => 'Ini Dashboard Admin')
    ->name('admin.dashboard')
    ->middleware(['auth', AdminMiddleware::class]);

// Route untuk test snap token
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