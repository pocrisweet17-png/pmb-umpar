<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\FormulirPendaftaran;
use App\Models\ProgramStudy;

class PendaftaranController extends Controller
{
    public function index()
    {
        $prodis = ProgramStudy::all();
        return view('pendaftaran.form', compact('prodis'));
    }

   public function store(Request $request)
{
    $request->validate([
        'namaLengkap'         => 'required|string|max:255',
        'email'               => 'required|email|unique:registrasis,email',
        'noHP'                => 'required|string|max:15',
        'jenisKelamin'        => 'required|in:Laki-laki,Perempuan',
        'tempatLahir'         => 'required|string',
        'tanggalLahir'        => 'required|date',
        'agama'               => 'required|string',
        'alamat'              => 'required|string',
        'asalSekolah'         => 'required|string',
        'jurusan'             => 'required|string',
        'tahunLulus'          => 'required|integer|min:2000|max:' . (date('Y') + 1),
        'programStudiPilihan' => 'required|exists:program_studis,kodeProdi',
    ]);

    try {
        $last = Registrasi::count();
        $nomor = 'UMPAR' . date('Y') . str_pad($last + 1, 5, '0', STR_PAD_LEFT);

        // CEK APAKAH NOMOR SUDAH ADA (pencegahan duplikat)
        if (Registrasi::where('nomorPendaftaran', $nomor)->exists()) {
            throw new \Exception('Nomor pendaftaran sudah ada! Silakan coba lagi.');
        }

        // SIMPAN KE REGISTRASI
        $registrasi = Registrasi::create([
            'nomorPendaftaran' => $nomor,
            'namaLengkap'      => $request->namaLengkap,
            'jenisKelamin'     => $request->jenisKelamin,
            'tempatLahir'      => $request->tempatLahir,
            'tanggalLahir'     => $request->tanggalLahir,
            'agama'            => $request->agama,
            'alamat'           => $request->alamat,
            'noHP'             => $request->noHP,
            'email'            => $request->email,
            'asalSekolah'      => $request->asalSekolah,
            'jurusan'          => $request->jurusan,
            'tahunLulus'       => $request->tahunLulus,
            'tanggalDaftar'    => now(),
            'statusRegistrasi' => 'pending',
        ]);

        // SIMPAN KE FORMULIR PENDAFTARAN
        $kodeAkses = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10));

        $formulir = FormulirPendaftaran::create([
            'nomorPendaftaran'    => $nomor,
            'tanggalSubmit'       => now(),
            'programStudiPilihan' => $request->programStudiPilihan,
            'statusVerifikasi'    => 'menunggu',
            'kodeAkses'           => $kodeAkses,
        ]);

        // Ambil data program studi
        $programStudi = ProgramStudy::where('kodeProdi', $request->programStudiPilihan)->first();

        // Redirect dengan parameter
        return redirect()->route('pendaftaran.sukses', [
            'nomor' => $nomor,
            'kode' => $kodeAkses
        ]);

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
    }
}

public function sukses(Request $request)
{
    $nomor = $request->query('nomor');
    $kode = $request->query('kode');

    if (!$nomor || !$kode) {
        return redirect()->route('pendaftaran.index');
    }

    // Ambil data dari database
    $registrasi = Registrasi::where('nomorPendaftaran', $nomor)->first();
    $formulir = FormulirPendaftaran::where('nomorPendaftaran', $nomor)->first();
    $programStudi = ProgramStudy::where('kodeProdi', $formulir->programStudiPilihan)->first();

    if (!$registrasi) {
        return redirect()->route('pendaftaran.index');
    }

    $data = [
        'nomor_pendaftaran' => $registrasi->nomorPendaftaran,
        'nama_lengkap' => $registrasi->namaLengkap,
        'program_studi' => $programStudi ? $programStudi->namaProdi . ' (' . $programStudi->jenjang . ')' : $formulir->programStudiPilihan,
        'kode_akses' => $formulir->kodeAkses,
        'tanggal_daftar' => $registrasi->tanggalDaftar->format('d F Y')
    ];

    return view('pendaftaran.sukses', compact('data'));
}
}
