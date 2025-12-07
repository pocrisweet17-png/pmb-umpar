<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;

class WawancaraController extends Controller
{
    public function index()
    {
        return view('wawancara.index'); // info jadwal wawancara
    }

    public function store(Request $request)
    {
        $registrasi = Registrasi::where('user_id', Auth::id())->first();

        FormulirPendaftaran::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
            ->update([
                'is_wawancara_selesai' => true,
            ]);

        return redirect()->route('daftar-ulang.index')->with('success', 'Wawancara selesai, lanjut daftar ulang.');
    }
}
