<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run()
    {
        DB::table('program_studis')->delete();

        $now = now();

        $prodis = [
            ['FKIP01', 'Pendidikan Matematika', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 80, 70.00],
            ['FKIP02', 'Pendidikan Bahasa Inggris', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 90, 72.00],
            ['FKIP03', 'Pendidikan Biologi', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 70, 68.00],
            ['FKIP04', 'Pendidikan Non Formal (Pendidikan Luar Sekolah)', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 60, 65.00],
            ['PPG01', 'Pendidikan Profesi Guru (PPG)', 'Profesi', 'Fakultas Keguruan dan Ilmu Pendidikan', 100, null],

            ['FAP01', 'Agroteknologi', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 80, 65.00],
            ['FAP02', 'Agribisnis', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 90, 67.00],
            ['FAP03', 'Agribisnis', 'S2', 'Fakultas Pertanian, Peternakan, dan Perikanan', 30, null],
            ['FAP04', 'Peternakan (Ilmu Peternakan)', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 70, 64.00],
            ['FAP05', 'Budidaya Perairan', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 60, 63.00],

            ['FEB01', 'Manajemen', 'S1', 'Fakultas Ekonomi dan Bisnis', 150, 70.00],
            ['FEB02', 'Manajemen', 'S2', 'Fakultas Ekonomi dan Bisnis', 40, null],
            ['FEB03', 'Akuntansi', 'S1', 'Fakultas Ekonomi dan Bisnis', 140, 72.00],
            ['FEB04', 'Ekonomi Pembangunan', 'S1', 'Fakultas Ekonomi dan Bisnis', 100, 68.00],
            ['FEB05', 'Perbankan Syariah', 'S1', 'Fakultas Ekonomi dan Bisnis', 90, 69.00],

            
            ['FT01', 'Teknik Sipil', 'S1', 'Fakultas Teknik', 90, 70.00],
            ['FT02', 'Teknik Elektro', 'S1', 'Fakultas Teknik', 80, 68.00],
            ['FT03', 'Teknik Informatika', 'S1', 'Fakultas Teknik', 120, 75.00],
            ['FT04', 'Teknik Perencanaan Wilayah Kota', 'S1', 'Fakultas Teknik', 120, 75.00],

            ['FAI01', 'Pendidikan Agama Islam', 'S1', 'Fakultas Agama Islam', 100, 70.00],
            ['FAI02', 'Pendidikan Agama Islam', 'S2', 'Fakultas Agama Islam', 30, null],
            ['FAI03', 'Pendidikan Agama Islam', 'S3', 'Fakultas Agama Islam', 20, null],
            ['FAI04', 'Bimbingan dan Penyuluhan Islam', 'S1', 'Fakultas Agama Islam', 80, 68.00],
            ['FAI05', 'Pendidikan Islam Anak Usia Dini (PGRA)', 'S1', 'Fakultas Agama Islam', 90, 65.00],

            ['FIKES01', 'Kesehatan Masyarakat', 'S1', 'Fakultas Ilmu Kesehatan', 100, 72.00],
            ['FIKES02', 'Gizi', 'S1', 'Fakultas Ilmu Kesehatan', 80, 70.00],

            ['FH01', 'Ilmu Hukum', 'S1', 'Fakultas Hukum', 130, 73.00],
        ];

        foreach ($prodis as $p) {
            DB::table('program_studis')->insert([
                'kodeProdi'     => $p[0],
                'namaProdi'     => $p[1],
                'jenjang'       => $p[2],
                'fakultas'      => $p[3],
                'kuota'         => $p[4],
                'passingGrade'  => $p[5],
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        $this->command->info('Program Studi berhasil di-seed ulang! Total: ' . count($prodis) . ' prodi.');
    }
}