<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\FormulirPendaftaran;
use App\Models\ProgramStudy;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    // GENERATE NOMOR PENDAFTARAN DULU — WAJIB ADA SEBELUM CREATE!
    $nomor = 'UMPAR' . date('Y') . str_pad((Registrasi::count() + 1), 5, '0', STR_PAD_LEFT);
    // Hasil: UMPAR202500001, UMPAR202500002, dst.

    // SIMPAN KE REGISTRASI — PASTIKAN nomorPendaftaran DIKIRIM!
    Registrasi::create([
        'nomorPendaftaran' => $nomor,           // INI YANG LUPA BRO!
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

    FormulirPendaftaran::create([
        'nomorPendaftaran'    => $nomor,
        'tanggalSubmit'       => now(),
        'programStudiPilihan' => $request->programStudiPilihan,
        'statusVerifikasi'    => 'menunggu',
        'kodeAkses'           => $kodeAkses,
    ]);

    return redirect()->route('pendaftaran.sukses')
        ->with([
            'nomorPendaftaran' => $nomor,
            'kodeAkses'        => $kodeAkses,
            'success'          => 'Pendaftaran berhasil! Simpan baik-baik nomor pendaftaran dan kode akses Anda.'
        ]);
}

    public function sukses()
    {
        return view('pendaftaran.sukses');
    }

    // Login calon maba menggunakan kode akses
    public function loginForm()
    {
        return view('pendaftaran.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'kodeAkses' => 'required|string|exists:formulir_pendaftarans,kodeAkses'
        ]);

        $formulir = FormulirPendaftaran::where('kodeAkses', $request->kodeAkses)
                    ->with('registrasi')
                    ->firstOrFail();

        // Simpan ke session
        session([
            'calon_maba' => true,
            'nomorPendaftaran' => $formulir->nomorPendaftaran,
            'namaLengkap'      => $formulir->registrasi->namaLengkap,
        ]);

        return redirect()->route('dashboard.calon');
    }

    public function dashboardCalon()
    {
        if (!session('calon_maba')) {
            return redirect()->route('pendaftaran.login');
        }

        $formulir = FormulirPendaftaran::where('nomorPendaftaran', session('nomorPendaftaran'))
                    ->with('registrasi', 'programStudi')
                    ->firstOrFail();

        return view('pendaftaran.dashboard', compact('formulir'));
    }

    public function logout()
    {
        session()->forget(['calon_maba', 'nomorPendaftaran', 'namaLengkap']);
        return redirect()->route('pendaftaran.login');
    }
}
