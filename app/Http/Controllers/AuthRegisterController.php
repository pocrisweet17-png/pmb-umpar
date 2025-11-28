<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.login');
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
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ]);

        User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nama_lengkap'  => $request->nama_lengkap,
            'nik'           => $request->nik,
            'no_whatsapp'   => $request->no_whatsapp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role'          => 'user', // otomatis user
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silahkan login.');
    }
}
