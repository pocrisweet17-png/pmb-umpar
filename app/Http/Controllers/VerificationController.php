<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Debug: log request
        Log::info('Verification attempt', [
            'id' => $request->id,
            'hash' => $request->hash,
            'has_valid_signature' => $request->hasValidSignature()
        ]);

        // Pastikan signed URL valid
        if (! $request->hasValidSignature()) {
            \Log::error('Invalid signature');
            return redirect()->route('login')->with('error', 'Link verifikasi tidak valid atau sudah kedaluwarsa.');
        }

        $user = User::find($request->id);
        if (! $user) {
            \Log::error('User not found', ['id' => $request->id]);
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        // Cek hash email cocok
        if (sha1($user->email) !== $request->hash) {
            \Log::error('Hash mismatch');
            return redirect()->route('login')->with('error', 'Token verifikasi tidak sesuai.');
        }

        // Jika sudah verified
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email sudah terverifikasi. Silakan login.');
        }

        // UPDATE KEDUA FIELD
        $user->email_verified_at = Carbon::now();
        $user->is_verified = 1;
        $saved = $user->save();

        \Log::info('User verified', [
            'user_id' => $user->id,
            'saved' => $saved,
            'is_verified' => $user->is_verified
        ]);

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi. Anda sekarang dapat login.');
    }
}
