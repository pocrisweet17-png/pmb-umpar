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
        Schema::create('biaya_pmb', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');                        
            $table->string('kodeProdi', 20);         
            $table->bigInteger('biaya_pendaftaran');
            $table->bigInteger('ukt_semester_1');
            $table->timestamps();

            $table->unique(['tahun', 'kodeProdi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya_pmb');
    }
};
