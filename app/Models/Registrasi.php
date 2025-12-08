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
        'asalSekolah',
        'jurusan',
        'tahunLulus',
        'tanggalDaftar',
        'statusRegistrasi',
        'programStudiPilihan',

        'is_prodi_selected',
        'is_bayar_pendaftaran',
        'is_data_completed',
        'is_dokumen_uploaded',
        'is_tes_selesai',
        'is_wawancara_selesai',
        'is_daftar_ulang',
        'is_ukt_paid',
    ];

    protected $casts = [
        'tanggalDaftar' => 'datetime',
    ];

    public function formulir()
    {
        return $this->hasOne(FormulirPendaftaran::class, 'nomorPendaftaran', 'nomorPendaftaran');
    }

    public function prodiDipilih()
    {
        return $this->belongsTo(ProgramStudy::class, 'programStudiPilihan', 'kodeProdi');
    }

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