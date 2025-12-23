<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pertanyaan_wawancaras', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_wawancaras');
    }
};
