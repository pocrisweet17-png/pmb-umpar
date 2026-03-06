<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawabans';
    protected $primaryKey = 'idJawaban';

    protected $fillable = [
        'idUjian',
        'idSoal',
        'JawabanPeserta'
    ];

    public function ujian(){
        return $this->belongsTo(Ujian::class, 'idUjian', 'idUjian');
    }
    public function soal(){
        return $this->belongsTo(Soal::class, 'idSoal', 'idSoal');
    }
}
