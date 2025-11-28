<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Registry;

class Dokumen extends Model
{
     protected $table = 'dokumens';
     protected $primaryKey = 'idDokumen';
     protected $fillable = [
    'idRegistrasi',
    'jenisDokumen',
    'namaFile',
    'formatFile',
    'urlFile',
    'tanggalUpload',
    'ukuranVerifikasi',
    'catatanVerifikasi',
];

    public $timestamps = true;

    public function registrasi(){
        return $this->belongsTo(Registrasi::class, 'idRegistrasi', 'idRegistrasi');
    }
}
