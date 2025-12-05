<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan username atau email
        $user = User::where('email', $request->login)
                    ->orWhere('username', $request->login)
                    ->first();

        // Cek apakah user tidak ditemukan atau password salah
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Email/Username atau password tidak cocok.',
            ]);
        }

        // Cek apakah email sudah diverifikasi
        if (! $user->is_verified) {
            return back()->withErrors([
                'login' => 'Email belum diverifikasi. Silahkan cek email Anda untuk verifikasi.',
            ]);
        }

        // Login user (tanpa Auth::attempt)
        Auth::login($user);

        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('mahasiswa.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
