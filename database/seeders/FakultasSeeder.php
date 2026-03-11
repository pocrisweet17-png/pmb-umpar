<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        $fakultas = [
            [
                'kode_fakultas' => 'FAI',
                'nama_fakultas' => 'Fakultas Agama Islam',
                'singkatan' => 'FAI',
                'is_active' => true
            ],
            [
                'kode_fakultas' => 'FKIP',
                'nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan',
                'singkatan' => 'FKIP',
                'is_active' => true
            ],
            [
                'kode_fakultas' => 'FEB',
                'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis',
                'singkatan' => 'FEB',
                'is_active' => true
            ],
            [
                'kode_fakultas' => 'FT',
                'nama_fakultas' => 'Fakultas Teknik',
                'singkatan' => 'FT',
                'is_active' => true
            ],
            [
                'kode_fakultas' => 'FAPETRIK',
                'nama_fakultas' => 'Fakultas Pertanian, Peternakan, dan Perikanan',
                'singkatan' => 'FISIP',
                'is_active' => true
            ],
            [
                'kode_fakultas' => 'FH',
                'nama_fakultas' => 'Fakultas Hukum',
                'singkatan' => 'FH',
                'is_active' => true
            ],
            [
                'kode_fakultas' => 'FIKES',
                'nama_fakultas' => 'Fakultas Ilmu Kesehatan',
                'singkatan' => 'FIKES',
                'is_active' => true
            ],
        ];

        foreach ($fakultas as $fak) {
            Fakultas::create($fak);
        }
    }
}