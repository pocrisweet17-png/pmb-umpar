<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiFormModel extends Model
{
    protected $table = 'registrasis';
    protected $primaryKey = 'idRegistrasi';
    public $incrementing = true;
    protected $keyType = 'int';
    // mengakses tabel registrasi
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
}
