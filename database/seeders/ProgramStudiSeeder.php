<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('program_studis')->delete();

        $now = now();

        $prodis = [
            // ================= FAKULTAS TEKNIK =================
            ['280', 'Teknik Informatika', 'S1', 'Fakultas Teknik'],
            ['180', 'Teknik Elektro', 'S1', 'Fakultas Teknik'],
            ['190', 'Teknik Sipil', 'S1', 'Fakultas Teknik'],
            ['380', 'Perencanaan Wilayah dan Kota', 'S1', 'Fakultas Teknik'],

            // ============ FAKULTAS EKONOMI DAN BISNIS ============
            ['200', 'Manajemen', 'S1', 'Fakultas Ekonomi dan Bisnis'],
            ['210', 'Akuntansi', 'S1', 'Fakultas Ekonomi dan Bisnis'],
            ['220', 'Ekonomi Pembangunan', 'S1', 'Fakultas Ekonomi dan Bisnis'],
            ['230', 'Perbankan Syariah', 'S1', 'Fakultas Ekonomi dan Bisnis'],
            ['300', 'Magister Manajemen', 'S2', 'Fakultas Ekonomi dan Bisnis'],

            // ===== FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN =====
            ['110', 'Pendidikan Matematika', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['120', 'Pendidikan Bahasa Inggris', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['130', 'Pendidikan Biologi', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['140', 'Pendidikan Non Formal', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['350', 'Pendidikan Profesi Guru (PPG)', 'Profesi', 'Fakultas Keguruan dan Ilmu Pendidikan'],

            // ===== FAKULTAS PERTANIAN, PETERNAKAN & PERIKANAN =====
            ['160', 'Agroteknologi', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan'],
            ['170', 'Agribisnis', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan'],
            ['290', 'Magister Agribisnis', 'S2', 'Fakultas Pertanian, Peternakan, dan Perikanan'],
            ['150', 'Peternakan', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan'],
            ['270', 'Budidaya Perairan', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan'],

            // ============ FAKULTAS AGAMA ISLAM ============
            ['260', 'Bimbingan dan Penyuluhan Islam', 'S1', 'Fakultas Agama Islam'],
            ['340', 'Pendidikan Islam Anak Usia Dini', 'S1', 'Fakultas Agama Islam'],
            ['250', 'Pendidikan Agama Islam', 'S1', 'Fakultas Agama Islam'],
            ['310', 'Magister Pendidikan Agama Islam', 'S2', 'Fakultas Agama Islam'],
            ['370', 'Doktor Pendidikan Agama Islam', 'S3', 'Fakultas Agama Islam'],

            // ============ FAKULTAS ILMU KESEHATAN ============
            ['240', 'Kesehatan Masyarakat', 'S1', 'Fakultas Ilmu Kesehatan'],
            ['390', 'Gizi', 'S1', 'Fakultas Ilmu Kesehatan'],

            // ============ FAKULTAS HUKUM ============
            ['360', 'Ilmu Hukum', 'S1', 'Fakultas Hukum'],
        ];

        foreach ($prodis as $p) {
            DB::table('program_studis')->insert([
                'kodeProdi'     => $p[0],
                'namaProdi'     => $p[1],
                'jenjang'       => $p[2],
                'fakultas'      => $p[3],
                'kuota'         => 0,
                'passingGrade'  => null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        $this->command->info('Program studi berhasil disesuaikan dengan data Excel.');
    }
}
