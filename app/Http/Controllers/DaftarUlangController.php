<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;

class DaftarUlangController extends Controller
{
    public function index()
    {
        return view('daftar-ulang.index'); // form daftar ulang
    }

    public function store(Request $request)
    {
        $registrasi = Registrasi::where('user_id', Auth::id())->first();

        FormulirPendaftaran::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
            ->update([
                'is_daftar_ulang' => true,
            ]);

        return redirect()->route('ukt.index')->with('success', 'Daftar ulang berhasil. Silakan bayar UKT.');
    }
}
