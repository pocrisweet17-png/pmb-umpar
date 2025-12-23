<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{

    protected $table = 'soals';
    protected $primaryKey = 'idSoal';
    // akses ke fild yang ada di tabel soals
    protected $fillable = [
        'textSoal',
        'gambar_soal',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawabanBenar'
    ];
}
