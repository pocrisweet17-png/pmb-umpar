<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< HEAD
use App\Models\Fakultas;

class FakultasSeeder extends Seeder
{
=======
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
>>>>>>> c725232840e4de2ca89c207adcd8c9dee52d0523
    public function run(): void
    {
        $fakultas = [
            [
<<<<<<< HEAD
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
=======
                'id'             => 1,
                'kode_fakultas'  => 'FAI',
                'nama_fakultas'  => 'Fakultas Agama Islam',
                'singkatan'      => 'FAI',
                'deskripsi'      => null,
                'is_active'      => 1,
                'created_at'     => '2026-03-06 00:53:27',
                'updated_at'     => '2026-03-06 00:53:27',
            ],
            [
                'id'             => 2,
                'kode_fakultas'  => 'FKIP',
                'nama_fakultas'  => 'Fakultas Keguruan dan Ilmu Pendidikan',
                'singkatan'      => 'FKIP',
                'deskripsi'      => null,
                'is_active'      => 1,
                'created_at'     => '2026-03-06 00:53:27',
                'updated_at'     => '2026-03-06 00:53:27',
            ],
            [
                'id'             => 3,
                'kode_fakultas'  => 'FEB',
                'nama_fakultas'  => 'Fakultas Ekonomi dan Bisnis',
                'singkatan'      => 'FEB',
                'deskripsi'      => null,
                'is_active'      => 1,
                'created_at'     => '2026-03-06 00:53:27',
                'updated_at'     => '2026-03-06 00:53:27',
            ],
            [
                'id'             => 4,
                'kode_fakultas'  => 'FT',
                'nama_fakultas'  => 'Fakultas Teknik',
                'singkatan'      => 'FT',
                'deskripsi'      => null,
                'is_active'      => 1,
                'created_at'     => '2026-03-06 00:53:27',
                'updated_at'     => '2026-03-06 00:53:27',
            ],
            [
                'id'             => 5,
                'kode_fakultas'  => 'FAPETRIK',
                'nama_fakultas'  => 'Fakultas Pertanian, Peternakan, dan Perikanan',
                'singkatan'      => 'FAPETRIK',
                'deskripsi'      => null,
                'is_active'      => 1,
                'created_at'     => '2026-03-06 00:53:27',
                'updated_at'     => '2026-03-06 00:53:27',
            ],
            [
                'id'             => 6,
                'kode_fakultas'  => 'FH',
                'nama_fakultas'  => 'Fakultas Hukum',
                'singkatan'      => 'FH',
                'deskripsi'      => null,
                'is_active'      => 1,
                'created_at'     => '2026-03-06 00:53:27',
                'updated_at'     => '2026-03-06 00:53:27',
            ],
            [
                'id'             => 7,
                'kode_fakultas'  => 'FIKES',
                'nama_fakultas'  => 'Fakultas Ilmu Kesehatan',
                'singkatan'      => 'FIKES',
                'deskripsi'      => null,
                'is_active'      => 1,
                'created_at'     => '2026-03-06 00:53:27',
                'updated_at'     => '2026-03-06 00:53:27',
            ],
        ];

        DB::table('fakultas')->insert($fakultas);
>>>>>>> c725232840e4de2ca89c207adcd8c9dee52d0523
    }
}