<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BiayaPmbSeeder extends Seeder
{
    public function run(): void
    {
        // KODE PRODI BARU (ANGKA, sesuai tabel program_studis)
        $kodeProdi = [
            280, 180, 190, 380,
            200, 210, 220, 230,
            300, 110, 120, 130, 140,
            350,
            160, 170, 290, 150, 270,
            260, 340, 250, 310, 370,
            240, 390, 360
        ];

        $biaya = [];

        foreach ($kodeProdi as $prodi) {
            $biaya[] = [
                'tahun' => 2025,
                'kodeProdi' => $prodi,
                'biaya_pendaftaran' => 50000,
                'biaya_ukt' => 300000,
            ];
        }

        DB::table('biaya_pmb')->truncate();
        DB::table('biaya_pmb')->insert($biaya);
    }
}
