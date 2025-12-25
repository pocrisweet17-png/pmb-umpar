<?php

use App\Models\User;
use App\Models\Registrasi;
use App\Models\ProgramStudy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\UjianController;
use App\Http\Middleware\StepUploadDokumen;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BayarUktController;
use App\Http\Controllers\DokumentController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\WawancaraController;
use App\Http\Controllers\DaftarUlangController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\PertanyaanWawancaraController;
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
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
        Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
        
        Route::get('/mahasiswa/ujian', [UjianController::class, 'index'])->name('mahasiswa.ujian');
        Route::post('/mahasiswa/ujian/submit', [UjianController::class, 'submit'])->name('mahasiswa.ujian.submit');
        Route::get('/mahasiswa/hasil/{idUjian}', [UjianController::class, 'hasil'])->name('mahasiswa.hasil');
});

// STEP 6: Wawancara
    Route::middleware(['auth', 'verified', 'step.prodi', 'check.bayar', 'check.lengkapi',])->group(function () {
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
    Route::get('/mahasiswa/daftar-ulang', [MahasiswaController::class, 'daftarUlang'])->name('admin.user.daftar-ulang');
    Route::post('/mahasiswa/{id}/verify-daftar-ulang', [MahasiswaController::class, 'verifyDaftarUlang'])->name('admin.mahasiswa.verify-daftar-ulang');
    Route::post('/mahasiswa/{id}/reject-daftar-ulang', [MahasiswaController::class, 'rejectDaftarUlang'])->name('admin.mahasiswa.reject-daftar-ulang');

    // CRUD Pertanyaan Wawancara
    Route::get('/admin/wawancara', [PertanyaanWawancaraController::class, 'index'])->name('admin.wawancara.index');
    Route::get('/admin/wawancara/create', [PertanyaanWawancaraController::class, 'create'])->name('admin.wawancara.create');
    Route::post('/admin/wawancara/store', [PertanyaanWawancaraController::class, 'store'])->name('admin.wawancara.store');
    Route::get('/admin/wawancara/{id}/edit', [PertanyaanWawancaraController::class, 'edit'])->name('admin.wawancara.edit');
    Route::put('/admin/wawancara/{id}', [PertanyaanWawancaraController::class, 'update'])->name('admin.wawancara.update');
    Route::delete('/admin/wawancara/{id}', [PertanyaanWawancaraController::class, 'destroy'])->name('admin.wawancara.destroy');
    Route::post('/admin/wawancara/{id}/toggle', [PertanyaanWawancaraController::class, 'toggleStatus'])->name('admin.wawancara.toggle');
        
});


Route::get('/wilayah/{type}/{id?}', function ($type, $id = null) {
    $base = 'https://emsifa.github.io/api-wilayah-indonesia/api';

    $url = match ($type) {
        'provinsi'  => "$base/provinces.json",
        'kabupaten' => "$base/regencies/$id.json",
        'kecamatan' => "$base/districts/$id.json",
        'desa'      => "$base/villages/$id.json",
        default     => abort(404),
    };

    return Http::get($url)->json();
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/mahasiswa/export-excel', [MahasiswaController::class, 'exportExcel'])
        ->name('mahasiswa.export-excel');
});

// routes/web.php - Tambahkan route ini untuk debug
Route::get('/debug-registration', function() {
    $data = \App\Models\Registration::all();
    
    echo "<h2>Total Data: " . $data->count() . "</h2><hr>";
    
    foreach($data as $reg) {
        echo "<div style='background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "<strong>ID:</strong> {$reg->id}<br>";
        echo "<strong>Address:</strong> {$reg->address}<br>";
        echo "<strong>Gender:</strong> {$reg->gender}<br><br>";
        
        // Pecah alamat
        if ($reg->address) {
            $parts = explode(',', $reg->address);
            echo "<strong>📍 Address Parts:</strong><br>";
            foreach($parts as $i => $part) {
                echo "<span style='color: blue;'>[Index $i]</span> = <strong>" . trim($part) . "</strong><br>";
            }
            
            // Tampilkan yang akan diambil
            if (isset($parts[3])) {
                echo "<br><span style='color: green; font-weight: bold;'>✓ Yang akan diambil (Index 3): " . trim($parts[3]) . "</span>";
            }
        }
        echo "</div>";
    }
})->name('debug.registration');