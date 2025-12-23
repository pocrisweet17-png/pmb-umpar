<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
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
            'gambar_soal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawabanBenar' => 'required|in:a,b,c,d'
        ]);
        $gambarPath = null;
        if($request->hasFile('gambar_soal')){
            $gambarPath = $request->file('gambar_soal')->store('soal_images', 'public');
        }

        Soal::create([
            'textSoal' => $request->textSoal,
            'gambar_soal' => $gambarPath,
            'opsi_a' => $request->opsi_a,
            'opsi_b'=> $request->opsi_b,
            'opsi_c'=> $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'jawabanBenar' => $request->jawabanBenar,
        ]);

        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil ditambahkan');
    }

    public function index(){
        $soals = Soal::all();
        return view('admin.soal.index', compact('soals'));
    }

    public function edit($id){
        $soal = Soal::findOrFail($id);
        return view('admin.soal.edit', compact('soal'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'textSoal' => 'required|string',
            'gambar_soal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawabanBenar' => 'required|in:a,b,c,d'
        ]);

        $soal = Soal::findOrFail($id);

        $gambarPath = $soal->gambar_soal;

        if($request->hasFile('gambar_soal')){
            //hapus gambar kalau sudah ada
            if($soal->gambar_soal && \Storage::disk('public')->exists($soal->gambar_soal)){
                Storage::disk('public')->delete($soal->gambar_soal);
            }
            // upload gambar baru
            $gambarPath = $request->file('gambar_soal')->store('soal_images', 'public');
        }

        $soal->update([
            'textSoal' => $request->textSoal,
            'gambar_soal' => $gambarPath,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'jawabanBenar' => $request->jawabanBenar,
        ]);

        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil diperbarui');
    }

    public function destroy($id){
        
        $soal = Soal::findOrFail($id);
        //hapus gambar kalau ada
        if ($soal->gambar_soal && \Storage::disk('public')->exists($soal->gambar_soal)) {
            \Storage::disk('public')->delete($soal->gambar_soal);
    }
        $soal->delete();

        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil dihapus');
    }
}
