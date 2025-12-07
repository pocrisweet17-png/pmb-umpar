<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
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

        // 1. Create user
        $user = User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nama_lengkap'  => $request->nama_lengkap,
            'nik'           => $request->nik,
            'no_whatsapp'   => $request->no_whatsapp,
            'role'          => 'user',
        ]);

        // 2. Generate nomor registrasi
        $regNo = 'UMPAR-' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        $user->nomor_registrasi = $regNo;
        $user->save();

        // 3. Create registrasi steps row
        Registrasi::create([
            'user_id'               => $user->id,
            'is_prodi_selected'     => false,
            'is_bayar_pendaftaran'  => false,
            'is_data_completed'     => false,
            'is_dokumen_uploaded'   => false,
            'is_tes_selesai'        => false,
            'is_wawancara_selesai'  => false,
            'is_daftar_ulang'       => false,
            'is_ukt_paid'           => false,
        ]);

        // 4. Create signed URL
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            [
                'id'   => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        // 5. Send email
        Mail::to($user->email)->send(
            new VerifyRegistrationMail(
                $user->nama_lengkap,
                $user->nomor_registrasi,
                $verificationUrl
            )
        );

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat. Cek email untuk verifikasi.');
    }
}
