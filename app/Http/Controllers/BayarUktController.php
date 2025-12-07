<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;

class BayarUktController extends Controller
{
    public function index()
    {
        return view('ukt.index'); // halaman pembayaran UKT
    }

    public function store(Request $request)
    {
        $registrasi = Registrasi::where('user_id', Auth::id())->first();

        FormulirPendaftaran::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
            ->update([
                'is_ukt_paid' => true,
            ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Pembayaran UKT berhasil! Selamat Anda telah diterima.');
    }
}
