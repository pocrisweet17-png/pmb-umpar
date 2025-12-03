<?php

namespace App\Http\Controllers;
use App\Models\Soal;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function showSoal(){
        return view('admin.soal.create');
    }
    public function createSoal(Request $request){
        $request->validate([
            'textSoal' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawabanBenar' => 'required|in:a,b,c,d'
        ]);

        Soal::create([
        'textSoal' => $request->textSoal,
        'opsi_a' => $request->opsi_a,
        'opsi_b'=> $request->opsi_b,
        'opsi_c'=> $request->opsi_c,
        'opsi_d' => $request->opsi_d,
        'jawabanBenar' => $request->jawabanBenar,
        ]);
        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil di tambahkan');

    }
    public function index(){
        $soals = Soal::all();
        return view('admin.soal.index', compact('soals'));
    }
}
