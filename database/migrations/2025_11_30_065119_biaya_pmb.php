<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya_pmb', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('kodeProdi', 50);
            $table->decimal('biaya_pendaftaran', 15, 2);
            $table->decimal('biaya_ukt', 15, 2)->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            // Foreign key
            $table->foreign('kodeProdi')
                  ->references('kodeProdi')
                  ->on('program_studis')
                  ->onDelete('cascade');
            
            // Index untuk query cepat
            $table->index(['tahun', 'kodeProdi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_pmb');
    }
};
