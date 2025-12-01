<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasis';
    protected $primaryKey = 'idRegistrasi';
    public $incrementing = true;
    protected $keyType = 'integer'; 

    protected $fillable = [
        'nomorPendaftaran',
        'namaLengkap',
        'jenisKelamin',
        'tempatLahir',
        'tanggalLahir',
        'agama',
        'alamat',
        'noHP',
        'email',
        'asalSekolah',
        'jurusan',
        'tahunLulus',
        'tanggalDaftar',
        'statusRegistrasi',
        'programStudiPilihan', // ini penting buat relasi prodi
    ];

    protected $casts = [
        'tanggalDaftar' => 'datetime',
    ];

    // === RELASI YANG SUDAH ADA ===
    public function formulir()
    {
        return $this->hasOne(FormulirPendaftaran::class, 'nomorPendaftaran', 'nomorPendaftaran');
    }

    public function prodiDipilih()
    {
        return $this->belongsTo(ProgramStudy::class, 'programStudiPilihan', 'kodeProdi');
    }

    // === RELASI PEMBAYARAN (BARU) ===
    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_registrasi', 'idRegistrasi');
    }

    public function paymentPendaftaran()
    {
        return $this->hasOne(Payment::class, 'id_registrasi', 'idRegistrasi')
                    ->where('tipe_pembayaran', 'pendaftaran');
    }

    public function paymentUkt()
    {
        return $this->hasOne(Payment::class, 'id_registrasi', 'idRegistrasi')
                    ->where('tipe_pembayaran', 'ukt');
    }

    // === CEK STATUS LUNAS ===
    public function sudahBayarPendaftaran()
    {
        return $this->payments()
                    ->where('tipe_pembayaran', 'pendaftaran')
                    ->where('status_transaksi', 'settlement')
                    ->exists();
    }

    public function sudahBayarUkt()
    {
        return $this->payments()
                    ->where('tipe_pembayaran', 'ukt')
                    ->where('status_transaksi', 'settlement')
                    ->exists();
    }

    public function semuaLunas()
    {
        return $this->sudahBayarPendaftaran() && $this->sudahBayarUkt();
    }

    public function biayaPmb()
    {
    $kodeProdi = $this->prodiDipilih?->kodeProdi;

    if (!$kodeProdi) {
        return null; 
    }

    $tahun = $this->gelombang ?? date('Y'); 

    return BiayaPmb::where('tahun', $tahun)
                   ->where('kodeProdi', $kodeProdi)
                   ->first();
    }
}