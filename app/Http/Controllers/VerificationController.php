<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Pastikan signed URL valid
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')->with('error', 'Link verifikasi tidak valid atau sudah kedaluwarsa.');
        }

        $user = User::find($request->id);
        if (! $user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        // Optional: cek hash email cocok
        if (sha1($user->email) !== $request->hash) {
            return redirect()->route('login')->with('error', 'Token verifikasi tidak sesuai.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email sudah terverifikasi. Silakan login.');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi. Anda sekarang dapat login.');
    }
}
