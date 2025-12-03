<?php

use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Models\ProgramStudy;
use App\Http\Controllers\DokumentController;
use Symfony\Component\HttpKernel\HttpCache\Store;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\SoalController;

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'callback'])->name('midtrans.callback');
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
Route::get('/tagihan/{idRegistrasi}', [PaymentController::class, 'tagihan'])->name('tagihan');
Route::get('/bayar/{idRegistrasi}/{tipe}', [PaymentController::class, 'bayar'])->name('bayar');
Route::post('/midtrans/webhook', [PaymentController::class, 'webhook']);
Route::get('/payment/finish/{idRegistrasi}', [PaymentController::class, 'selesai'])->name('payment.finish');


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
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware(['auth', AdminMiddleware::class]);

// crud soal
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/soal', [SoalController::class, 'index'])->name('admin.soal.index');
    Route::get('/admin/soal/create', [SoalController::class, 'showSoal'])->name('admin.soal.create');
    Route::post('/admin/soal/store', [SoalController::class, 'createSoal'])->name('admin.soal.store');
});

// Dashboard Mahasiswa
Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard');
})->name('mahasiswa.dashboard')->middleware('auth');

// Halaman ujian
Route::get('/mahasiswa/ujian', function(){
    return view('mahasiswa.ujian');
});


//testing payment

Route::get('/tagihan-test-midtrans', function () {

    // Dummy Registrasi (object dengan method)
    $reg = new class {
        public $idRegistrasi = 999;
        public $nama_lengkap = "Test User";
        public $prodi_kode = "TI";
        public $gelombang = "2025";

        public function sudahBayarPendaftaran() { return false; }
        public function sudahBayarUKT() { return false; }
    };

    // Dummy biaya
    $biaya = (object) [
        "biaya_pendaftaran" => 150000,
        "ukt_semester_1"     => 2500000,
    ];

    return view('payment.tagihan', compact('reg', 'biaya'));
});



