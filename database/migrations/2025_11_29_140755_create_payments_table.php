<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
        $table->id('id_pembayaran');                    
        $table->unsignedBigInteger('id_registrasi');    
        $table->string('order_id')->unique();           
        $table->integer('jumlah');                      
        $table->string('tipe_pembayaran')->nullable();  
        $table->string('status_transaksi')->nullable(); 
        $table->string('id_transaksi')->nullable();     
        $table->string('status_penipuan')->nullable();  
        $table->json('payload')->nullable();            
        $table->timestamps();
        $table->foreign('id_registrasi')
          ->references('idRegistrasi')
          ->on('registrasis')
          ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
