<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BiayaPmb extends Model
{
    protected $table = 'biaya_pmb';
    
    protected $fillable = [
        'tahun',
        'kodeProdi',
        'biaya_pendaftaran',
        'biaya_ukt',
    ];

    // relasi ke program study
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudy::class, 'kodeProdi', 'kodeProdi');
    }
}