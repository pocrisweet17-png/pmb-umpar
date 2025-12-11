<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Webhook Midtrans (tanpa CSRF protection)
Route::post('/midtrans/notification', [PaymentController::class, 'notification']);
?>