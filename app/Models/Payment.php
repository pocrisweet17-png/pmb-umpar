<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'id_transaksi',
        'jumlah',
        'tipe_pembayaran',
        'status_transaksi',
        'bukti_manual',
        'payload',
        'biaya_ukt',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Untuk backward compatibility dengan kode lama
    public function getIdRegistrasiAttribute()
    {
        return $this->user_id;
    }

    // ========== SCOPES ==========
    
    public function scopePendaftaran($query)
    {
        return $query->where('tipe_pembayaran', 'pendaftaran');
    }

    public function scopeUkt($query)
    {
        return $query->where('tipe_pembayaran', 'ukt');
    }

    public function scopeSettled($query)
    {
        return $query->whereIn('status_transaksi', ['settlement', 'manual-upload']);
    }

    public function scopePending($query)
    {
        return $query->where('status_transaksi', 'pending');
    }
    
}