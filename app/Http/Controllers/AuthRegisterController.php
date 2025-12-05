<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Mail\RegistrationVerificationMail;
use Illuminate\Support\Facades\Mail;

class AuthRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.login', ['openRegister' => true]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username'      => 'required|unique:users,username',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'nama_lengkap'  => 'required',
            'nik'           => 'required|unique:users,nik',
            'no_whatsapp'   => 'required',
        ]);

        // 1) Create user (registration_number masih null sementara)
        $user = User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nama_lengkap'  => $request->nama_lengkap,
            'nik'           => $request->nik,
            'no_whatsapp'   => $request->no_whatsapp,
            'role'          => 'user',
        ]);

        // 2) Generate registration number berdasarkan ID, contohnya UMPAR-000001
        $regNo = 'UMPAR-' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        $user->nomor_registrasi = $regNo;
        $user->save();

        // 3) Buat signed verification URL (kadaluwarsa 24 jam)
        $expiration = Carbon::now()->addHours(24);
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify', // route name
            $expiration,
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // 4) Send email (langsung, tanpa queue)
        Mail::to($user->email)->send(new RegistrationVerificationMail($user, $verificationUrl));

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan cek email untuk verifikasi (periksa folder spam jika perlu).');
    }
}
