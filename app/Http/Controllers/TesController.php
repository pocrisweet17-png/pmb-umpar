<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
    {
        return view('tes.index'); // halaman instruksi tes
    }

    public function store(Request $request)
    {
        $registrasi = Registrasi::where('user_id', Auth::id())->first();

        FormulirPendaftaran::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
            ->update([
                'is_tes_selesai' => true,
            ]);

        return redirect()->route('wawancara.index')->with('success', 'Tes selesai. Silakan lanjut wawancara.');
    }
}
