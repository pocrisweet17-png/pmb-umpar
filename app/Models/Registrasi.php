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
];
protected $casts = [
    'tanggalDaftar' => 'datetime'
];

    public function formulir()
    {
        return $this->hasOne(FormulirPendaftaran::class, 'nomorPendaftaran', 'nomorPendaftaran');
    }

    public function prodiDipilih()
    {
        return $this->belongsTo(ProgramStudy::class, 'programStudiPilihan', 'kodeProdi');
    }
}
