<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\RegistrasiFormModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registrasi.registrasi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nomorPendaftaran' => 'required|string|unique:registrasis,nomorPendaftaran',
            'namaLengkap' => 'required|string|max:255',
            'jenisKelamin' => 'required|in:Laki-laki,Perempuan',
            'tempatLahir' => 'required|string|max:255',
            'tanggalLahir' => 'required|date',
            'agama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'noHP' => 'required|string|max:30',
            'email' => 'required|email|unique:registrasis,email',
            'asalSekolah' => 'required|string|max:255',
            'jurusan' => 'required|string|max:50',
            'tahunLulus' => 'required|integer',
            'tanggalDaftar' => 'nullable|date',
        ]);
        if(empty($validate['tanggalDaftar'])){
            // jika tidak diisi, set tanggalDaftar dengan tanggal hari ini
            $validate['tanggalDaftar'] = Carbon::now()->toDateString();
        }
            // mempeding status registrasi secara default, kalau tidak diisi
            $validate['statusRegistrasi'] = 'pending';

        RegistrasiFormModel::create($validate);

        return redirect()->back()->with('success', 'Registrasi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
