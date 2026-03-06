<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FormulirPendaftaran extends Model
{
    protected $table = 'formulir_pendaftarans';
    protected $primaryKey = 'idFormulir';
    protected $fillable = [
        'nomorPendaftaran', 'tanggalSubmit', 'programStudiPilihan',
        'statusVerifikasi', 'kodeAkses'
    ];

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'nomorPendaftaran', 'nomorPendaftaran');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudy::class, 'programStudiPilihan', 'kodeProdi');
    }
}
