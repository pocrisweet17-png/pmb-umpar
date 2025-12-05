<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Mail\VerifyRegistrationMail;
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

        // 1) Create user
        $user = User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nama_lengkap'  => $request->nama_lengkap,
            'nik'           => $request->nik,
            'no_whatsapp'   => $request->no_whatsapp,
            'role'          => 'user',
        ]);

        // 2) Generate nomor registrasi
        $regNo = 'UMPAR-' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        $user->nomor_registrasi = $regNo;
        $user->save();

        // 3) Generate signed verification URL (24 jam)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );


        // 4) Kirim email verifikasi
        Mail::to($user->email)->send(
            new VerifyRegistrationMail(
                $user->nama_lengkap,
                $user->nomor_registrasi,
                $verificationUrl
            )
        );

        return redirect()->route('login')->with(
            'success',
            'Akun berhasil dibuat. Silakan cek email untuk verifikasi (cek spam jika tidak muncul).'
        );
    }
}
