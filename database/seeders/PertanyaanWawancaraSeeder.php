<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PertanyaanWawancara;

class PertanyaanWawancaraSeeder extends Seeder
{
    public function run(): void
    {
        $pertanyaans = [
            [
                'pertanyaan' => 'Dari mana Anda mengenal Universitas Muhammadiyah Parepare?',
                'opsi_a' => 'Orang Tua',
                'opsi_b' => 'Teman',
                'opsi_c' => 'Sosial Media',
                'opsi_d' => 'Brosur',
            ],
            [
                'pertanyaan' => 'Mengapa Anda memilih Universitas Muhammadiyah Parepare?',
                'opsi_a' => 'Akreditasinya bagus',
                'opsi_b' => 'Dekat dari tempat tinggal saya',
                'opsi_c' => 'Rekomendasi dari keluarga',
                'opsi_d' => 'Parepare kota yang ramah',
            ],
            [
                'pertanyaan' => 'Menurut Anda, bagaimana kondisi perekonomian keluarga Anda?',
                'opsi_a' => 'Kurang',
                'opsi_b' => 'Cukup',
                'opsi_c' => 'Sedang',
                'opsi_d' => 'Lebih',
            ],
            [
                'pertanyaan' => 'Dari manakah hasil sumber pendapatan untuk biaya kuliah Anda?',
                'opsi_a' => 'Dari orang tua',
                'opsi_b' => 'Dari diri sendiri',
                'opsi_c' => 'Dari Keluarga yang lain',
                'opsi_d' => 'Dari Pemerintah',
            ],
            [
                'pertanyaan' => 'Mengapa Anda tertarik dengan prodi yang Anda pilih sekarang?',
                'opsi_a' => 'Banyak alumninya yang berhasil',
                'opsi_b' => 'Saya tertarik dengan ilmunya',
                'opsi_c' => 'Keluarga saya menyarankan',
                'opsi_d' => 'Keinginan orang tua',
            ],
        ];

        foreach ($pertanyaans as $pertanyaan) {
            PertanyaanWawancara::create($pertanyaan);
        }
    }
}