<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_registrasi', 'order_id', 'jumlah', 'tipe_pembayaran',
        'status_transaksi', 'id_transaksi', 'status_penipuan', 'payload'
    ];
    protected $casts = ['payload' => 'array'];

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'id_registrasi', 'idRegistrasi');
    }

    public function isLunas()
    {
        return $this->status_transaksi === 'settlement';
    }

    public function tipeText()
    {
        return $this->tipe_pembayaran === 'pendaftaran' 
            ? 'Biaya Pendaftaran' 
            : 'UKT Semester 1';
    }
}