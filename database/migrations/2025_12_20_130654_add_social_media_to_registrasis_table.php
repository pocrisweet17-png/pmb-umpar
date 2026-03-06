<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('instagram')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->dropColumn([
                'twitter',
                'facebook',
                'tiktok',
                'instagram',
            ]);
        });
    }
};
