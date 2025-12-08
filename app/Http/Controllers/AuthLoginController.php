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

        // Cari user berdasarkan email/username
        $user = User::where('email', $request->login)
                    ->orWhere('username', $request->login)
                    ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Email/Username atau password tidak cocok.',
            ]);
        }

        // Cek sudah verifikasi?
        if (! $user->is_verified) {
            return back()->withErrors([
                'login' => 'Email belum diverifikasi.',
            ]);
        }

        // Login
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Redirect mahasiswa
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
