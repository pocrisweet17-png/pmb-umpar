<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Reference ke users (bukan registrasis)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Midtrans data
            $table->string('order_id', 100)->unique();
            $table->string('id_transaksi', 100)->nullable();
            $table->decimal('jumlah', 15, 2);
            
            // Tipe: pendaftaran atau ukt
            $table->string('tipe_pembayaran', 50);
            
            // Status: pending, settlement, manual-upload, deny, expire, cancel
            $table->string('status_transaksi', 50);
            
            // Untuk upload manual
            $table->string('bukti_manual')->nullable();
            
            // Payload dari Midtrans
            $table->text('payload')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
