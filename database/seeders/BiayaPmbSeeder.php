<?php

namespace Database\Seeders;

use App\Models\BiayaPmb;
use Illuminate\Database\Seeder;

class BiayaPmbSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            
            ['tahun' => 2026, 'kodeProdi' => 'FT01', 'biaya_pendaftaran' => 200000, 'ukt_semester_1' => 7500000],
            ['tahun' => 2026, 'kodeProdi' => 'FT02', 'biaya_pendaftaran' => 250000, 'ukt_semester_1' => 7000000],
            ['tahun' => 2026, 'kodeProdi' => 'FT03', 'biaya_pendaftaran' => 150000, 'ukt_semester_1' => 6500000],
            ['tahun' => 2026, 'kodeProdi' => 'FKIP01', 'biaya_pendaftaran' => 175000, 'ukt_semester_1' => 6800000],
            ['tahun' => 2026, 'kodeProdi' => 'FKIP02', 'biaya_pendaftaran' => 180000, 'ukt_semester_1' => 7200000],
            ['tahun' => 2026, 'kodeProdi' => 'FKIP03', 'biaya_pendaftaran' => 180000, 'ukt_semester_1' => 7200000],
            ['tahun' => 2026, 'kodeProdi' => 'FKIP04', 'biaya_pendaftaran' => 180000, 'ukt_semester_1' => 7200000],
            ['tahun' => 2026, 'kodeProdi' => 'FIKES01', 'biaya_pendaftaran' => 180000, 'ukt_semester_1' => 7200000],
            ['tahun' => 2026, 'kodeProdi' => 'FIKES02', 'biaya_pendaftaran' => 180000, 'ukt_semester_1' => 7200000],
        ];

        foreach ($data as $item) {
            BiayaPmb::updateOrCreate(
                ['tahun' => $item['tahun'], 'kodeProdi' => $item['kodeProdi']],
                $item
            );
        }

        $this->command->info('Biaya PMB semua prodi berhasil di-seed!');
    }
}