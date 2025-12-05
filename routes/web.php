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
use App\Http\Controllers\ProdiController;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\VerificationController;


Route::post('/midtrans/callback', [MidtransCallbackController::class, 'callback'])->name('midtrans.callback');
Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth', 'check.payment'])->group(function () {
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
     ->name('pendaftaran.form');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');
    Route::get('/pendaftaran/sukses', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');
});

Route::get('/api/prodi-by-fakultas/{fakultas}', function ($fakultas) {
    return ProgramStudy::where('fakultas', $fakultas)
        ->orderBy('namaProdi')
        ->get(['kodeProdi', 'namaProdi', 'jenjang']);
});

Route::get('/upload-dokumen', [DokumentController::class, 'index'])->name('dokumen.form');
Route::post('/upload-dokumen', [DokumentController::class, 'store'])->name('dokumen.store');
Route::middleware('auth')->group(function () {

    // Tagihan & Pembayaran
    Route::get('/tagihan', [PaymentController::class, 'tagihan'])
        ->name('tagihan');

    Route::get('/bayar/{tipe}', [PaymentController::class, 'bayar'])
        ->name('bayar');

    Route::post('/midtrans/webhook', [PaymentController::class, 'webhook']);

    Route::get('/payment/finish', [PaymentController::class, 'selesai'])
        ->name('payment.finish');
});



// register
Route::get('/register', [AuthRegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthRegisterController::class, 'register'])->name('register');

// route verification (signed)
Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = Registrasi::findOrFail($id);

    // Validasi hash email
    if ($hash !== sha1($user->email)) {
        abort(403);
    }

    // Tandai sudah diverifikasi
    $user->email_verified_at = now();
    $user->save();

    return view('emails.verified-success');
})
->name('verification.verify')
->middleware('signed');

// Login
Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthLoginController::class, 'login'])->name('login.process');

// Logout
Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');

Route::get('/api/prodi-by-fakultas', [ProdiController::class, 'getProdiByFakultas'])
    ->name('api.prodi-by-fakultas');
Route::post('/pilih-prodi', [ProdiController::class, 'store'])->middleware('auth')->name('prodi.store');


// Dashboard Mahasiswa
Route::get('/mahasiswa/dashboard', function () {
    $fakultas = ProgramStudy::select('fakultas')->distinct()->get();
    return view('mahasiswa.dashboard', compact('fakultas'));
})->name('mahasiswa.dashboard')->middleware('auth');

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return 'Ini Dashboard Admin';
})->name('admin.dashboard')->middleware(['auth', AdminMiddleware::class]);