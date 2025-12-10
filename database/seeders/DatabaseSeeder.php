<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProgramStudiSeeder::class,  // Seeder yang sudah ada
            BiayaPmbSeeder::class,      // Seeder baru untuk biaya
        ]);
    }
}