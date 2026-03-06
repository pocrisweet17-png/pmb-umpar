<?php

namespace Database\Seeders;

use App\Models\LandingPageContent;
use Illuminate\Database\Seeder;

class LandingPageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // HERO SECTION
            ['section' => 'hero', 'key' => 'badge_text', 'value' => 'Pendaftaran Gelombang 1 Dibuka', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'title_line1', 'value' => 'Wujudkan', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'title_line2', 'value' => 'Masa Depanmu', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'title_line3', 'value' => 'Bersama UMPAR', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'description', 'value' => 'Universitas Muhammadiyah Parepare - Kampus dengan akreditasi unggulan, nilai-nilai Islami, dan jaringan industri terluas di Sulawesi Selatan.', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'cta_button_text', 'value' => 'DAFTAR SEKARANG', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'cta_secondary_text', 'value' => 'INFO LEBIH LANJUT', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'card_title', 'value' => 'Pendaftaran Mahasiswa Baru', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'card_subtitle', 'value' => 'Gelombang 1 • 2025/2026', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'card_description', 'value' => 'Bergabunglah dengan keluarga besar Muhammadiyah dan raih masa depan gemilang.', 'type' => 'text'],

            // STATS SECTION
            ['section' => 'stats', 'key' => 'stat1_value', 'value' => 'A', 'type' => 'text'],
            ['section' => 'stats', 'key' => 'stat1_label', 'value' => 'Akreditasi', 'type' => 'text'],
            ['section' => 'stats', 'key' => 'stat2_value', 'value' => '20+', 'type' => 'text'],
            ['section' => 'stats', 'key' => 'stat2_label', 'value' => 'Prodi', 'type' => 'text'],
            ['section' => 'stats', 'key' => 'stat3_value', 'value' => '5K+', 'type' => 'text'],
            ['section' => 'stats', 'key' => 'stat3_label', 'value' => 'Alumni', 'type' => 'text'],

            // FEATURES SECTION
            ['section' => 'features', 'key' => 'section_title', 'value' => 'Keunggulan UMPAR', 'type' => 'text'],
            ['section' => 'features', 'key' => 'section_subtitle', 'value' => 'Dengan nilai-nilai Islami dan komitmen pada kualitas, kami siap mencetak generasi unggul.', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature1_title', 'value' => 'Akreditasi Unggul', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature1_desc', 'value' => 'Program studi terakreditasi BAN-PT dengan kurikulum terstandar industri.', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature2_title', 'value' => 'Beasiswa Lengkap', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature2_desc', 'value' => 'Berbagai skema beasiswa untuk mahasiswa berprestasi dan kurang mampu.', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature3_title', 'value' => 'Nilai Islami', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature3_desc', 'value' => 'Pendidikan berbasis nilai-nilai Islam ala Muhammadiyah yang moderat.', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature4_title', 'value' => 'Siap Kerja', 'type' => 'text'],
            ['section' => 'features', 'key' => 'feature4_desc', 'value' => 'Program magang dan kerja sama industri untuk karier profesional.', 'type' => 'text'],

            // PROGRAMS SECTION
            ['section' => 'programs', 'key' => 'section_title', 'value' => 'Program Studi Populer', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program1_title', 'value' => 'Teknik Informatika', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program1_category', 'value' => 'Teknologi', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program1_desc', 'value' => 'Kurikulum terkini, laboratorium lengkap, dan dosen berpengalaman di industri IT.', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program2_title', 'value' => 'Bisnis & Manajemen', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program2_category', 'value' => 'Bisnis', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program2_desc', 'value' => 'Fokus pada kewirausahaan, manajemen, dan keterampilan bisnis modern.', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program3_title', 'value' => 'Pendidikan & Keguruan', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program3_category', 'value' => 'Pendidikan', 'type' => 'text'],
            ['section' => 'programs', 'key' => 'program3_desc', 'value' => 'Mencetak guru profesional dengan nilai-nilai Islam Muhammadiyah.', 'type' => 'text'],

            // TESTIMONIALS SECTION
            ['section' => 'testimonials', 'key' => 'section_title', 'value' => 'Apa Kata Alumni?', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'section_subtitle', 'value' => 'Dengarkan pengalaman dari para alumni dan mahasiswa kami.', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi1_name', 'value' => 'Aulia Rahma', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi1_title', 'value' => 'Lulusan TI 2022', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi1_content', 'value' => 'UMPAR memberikan pengalaman belajar yang luar biasa dengan nilai-nilai Islami yang kuat. Dosen sangat supportif!', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi2_name', 'value' => 'Budi Santoso', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi2_title', 'value' => 'Lulusan Bisnis 2021', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi2_content', 'value' => 'Program magang membuka kesempatan kerja yang luas. Jaringan alumni Muhammadiyah sangat membantu karier saya.', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi3_name', 'value' => 'Citra Dewi', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi3_title', 'value' => 'Lulusan PGSD 2020', 'type' => 'text'],
            ['section' => 'testimonials', 'key' => 'testi3_content', 'value' => 'Lingkungan kampus yang Islami dan modern membuat saya berkembang pesat sebagai pendidik profesional.', 'type' => 'text'],

            // NEWS SECTION
            ['section' => 'news', 'key' => 'section_title', 'value' => 'Berita & Kegiatan', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news1_title', 'value' => 'Workshop Kewirausahaan Mahasiswa', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news1_category', 'value' => 'Kegiatan', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news1_date', 'value' => '12 November 2025', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news1_desc', 'value' => 'Mahasiswa belajar strategi bisnis modern dari praktisi industri.', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news2_title', 'value' => 'Penandatanganan MoU Industri', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news2_category', 'value' => 'Kerjasama', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news2_date', 'value' => '2 Oktober 2025', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news2_desc', 'value' => 'Penguatan kerja sama riset dan program magang mahasiswa.', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news3_title', 'value' => 'Milad Muhammadiyah ke-113', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news3_category', 'value' => 'Milad', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news3_date', 'value' => '25 September 2025', 'type' => 'text'],
            ['section' => 'news', 'key' => 'news3_desc', 'value' => 'Perayaan milad dengan berbagai kegiatan sosial dan keagamaan.', 'type' => 'text'],

            // FOOTER SECTION
            ['section' => 'footer', 'key' => 'description', 'value' => 'Kampus Muhammadiyah dengan nilai-nilai Islam moderat dan komitmen mencetak generasi unggul.', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'address', 'value' => 'Jl. Jenderal Ahmad Yani KM 6, Parepare, Sulawesi Selatan', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'phone', 'value' => '(0421) 2912 2xxx', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'email', 'value' => 'info@umpar.ac.id', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'facebook_url', 'value' => '#', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'instagram_url', 'value' => '#', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'youtube_url', 'value' => '#', 'type' => 'text'],
        ];

        foreach ($contents as $content) {
            LandingPageContent::updateOrCreate(
                ['section' => $content['section'], 'key' => $content['key']],
                ['value' => $content['value'], 'type' => $content['type']]
            );
        }

        $this->command->info('Landing page content seeded successfully!');
    }
}