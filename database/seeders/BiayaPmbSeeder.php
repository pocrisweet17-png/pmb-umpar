<?php
// database/seeders/BiayaPmbSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BiayaPmbSeeder extends Seeder
{
    public function run(): void
    {
        $biaya = [
            [
                'tahun' => 2025,
                'kodeProdi' => 'FT01',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 5000000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FT02',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4800000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FT03',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 5500000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FT04',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 5200000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FKIP01',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4500000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FKIP02',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4500000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FKIP03',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4500000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FKIP04',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4200000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FEB01',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4000000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FEB02',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 6000000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FEB03',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4200000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FEB04',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 3800000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FEB05',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4100000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FH01',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4800000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAI01',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4000000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAI02',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 5500000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAI03',
                'biaya_pendaftaran' => 350000.00,
                'biaya_ukt' => 7000000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAI04',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 3800000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAI05',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 3900000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAP01',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4200000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAP02',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4000000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAP03',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 5800000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAP04',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4300000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FAP05',
                'biaya_pendaftaran' => 250000.00,
                'biaya_ukt' => 4100000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FIKES01',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4800000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'FIKES02',
                'biaya_pendaftaran' => 300000.00,
                'biaya_ukt' => 4900000.00,
            ],
            [
                'tahun' => 2025,
                'kodeProdi' => 'PPG01',
                'biaya_pendaftaran' => 500000.00,
                'biaya_ukt' => 8000000.00,
            ],
        ];

        DB::table('biaya_pmb')->insert($biaya);
    }
}