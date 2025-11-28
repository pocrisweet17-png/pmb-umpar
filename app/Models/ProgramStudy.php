<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudy extends Model
{
    protected $table = 'program_studis';
    protected $primaryKey = 'kodeProdi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kodeProdi', 'namaProdi', 'jenjang', 'fakultas', 'kuota', 'passingGrade'
    ];
}
