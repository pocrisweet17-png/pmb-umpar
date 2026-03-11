-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 05 Mar 2026 pada 08.54
-- Versi server: 8.0.30
-- Versi PHP: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `pmbumparv2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `idAdmin` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaLengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statusAktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_pmb`
--

CREATE TABLE `biaya_pmb` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun` year NOT NULL,
  `kodeProdi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya_pendaftaran` decimal(15,2) NOT NULL,
  `biaya_ukt` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `biaya_pmb`
--

INSERT INTO `biaya_pmb` (`id`, `tahun`, `kodeProdi`, `biaya_pendaftaran`, `biaya_ukt`, `created_at`) VALUES
(1, '2025', '280', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(2, '2025', '180', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(3, '2025', '190', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(4, '2025', '380', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(5, '2025', '200', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(6, '2025', '210', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(7, '2025', '220', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(8, '2025', '230', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(9, '2025', '300', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(10, '2025', '110', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(11, '2025', '120', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(12, '2025', '130', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(13, '2025', '140', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(14, '2025', '350', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(15, '2025', '160', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(16, '2025', '170', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(17, '2025', '290', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(18, '2025', '150', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(19, '2025', '270', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(20, '2025', '260', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(21, '2025', '340', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(22, '2025', '250', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(23, '2025', '310', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(24, '2025', '370', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(25, '2025', '240', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(26, '2025', '390', 50000.00, 300000.00, '2026-02-26 02:21:11'),
(27, '2025', '360', 50000.00, 300000.00, '2026-02-26 02:21:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumens`
--

CREATE TABLE `dokumens` (
  `idDokumen` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jenisDokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaFile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `formatFile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlFile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggalUpload` date NOT NULL,
  `statusVerifikasi` tinyint(1) NOT NULL DEFAULT '0',
  `catatanVerifikasi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `formulir_pendaftarans`
--

CREATE TABLE `formulir_pendaftarans` (
  `idFormulir` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nomorPendaftaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_tes_selesai` tinyint(1) NOT NULL DEFAULT '0',
  `tanggalSubmit` date NOT NULL,
  `programStudiPilihan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statusVerifikasi` enum('menunggu','diverifikasi','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `kodeAkses` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawabans`
--

CREATE TABLE `jawabans` (
  `idJawaban` bigint UNSIGNED NOT NULL,
  `idUjian` bigint UNSIGNED NOT NULL,
  `idSoal` bigint UNSIGNED NOT NULL,
  `JawabanPeserta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `landing_page_contents`
--

CREATE TABLE `landing_page_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `leaderboards`
--

CREATE TABLE `leaderboards` (
  `idLeaderboard` bigint UNSIGNED NOT NULL,
  `idUser` bigint UNSIGNED NOT NULL,
  `idUjian` bigint UNSIGNED NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaLengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodeProdi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statusMahasiswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `tahun_akademik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2026/2027',
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pernyataan_daftar_ulang` tinyint(1) NOT NULL DEFAULT '0',
  `is_daftar_ulang` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_daftar_ulang` timestamp NULL DEFAULT NULL,
  `status_daftar_ulang` enum('belum','pending','verified','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `tanggalDaftar` date NOT NULL,
  `noPDDikti` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '0001_01_01_000004_create_users_table', 1),
(4, '2025_11_1_071911_create_registrasis_table', 1),
(5, '2025_11_26_072011_create_program_studis_table', 1),
(6, '2025_11_26_072012_create_mahasiswa_table', 1),
(7, '2025_11_26_072210_create_admins_table', 1),
(8, '2025_11_26_072355_create_dokuments_table', 1),
(9, '2025_11_29_140755_create_payments_table', 1),
(10, '2025_11_30_065119_biaya_pmb', 1),
(11, '2025_12_02_093239_create_soals', 1),
(12, '2025_12_02_093400_create_ujians_table', 1),
(13, '2025_12_02_093500_create_jawabans', 1),
(14, '2025_12_02_093600_create_leaderboards', 1),
(15, '2025_12_04_044616_create_formulir_pendaftarans_table', 1),
(16, '2025_12_05_140822_create_notifications_table', 1),
(17, '2025_12_11_060329_add_daftar_ulang_columns_to_mahasiswas_table', 1),
(18, '2025_12_20_130654_add_social_media_to_registrasis_table', 1),
(19, '2025_12_23_100613_create_wawancaras_table', 1),
(20, '2025_12_23_100915_create_pertanyaan_wawancaras_table', 1),
(21, '2025_12_26_025038_add_metode_pembayaran_to_payments_table', 1),
(22, '2026_01_06_141715_landing_page_contents', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_transaksi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tipe_pembayaran` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode_pembayaran` enum('online','offline') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'online',
  `status_transaksi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_manual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaan_wawancaras`
--

CREATE TABLE `pertanyaan_wawancaras` (
  `id` bigint UNSIGNED NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pertanyaan_wawancaras`
--

INSERT INTO `pertanyaan_wawancaras` (`id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dari mana Anda mengenal Universitas Muhammadiyah Parepare?', 'Orang Tua', 'Teman', 'Sosial Media', 'Brosur', 1, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(2, 'Mengapa Anda memilih Universitas Muhammadiyah Parepare?', 'Akreditasinya bagus', 'Dekat dari tempat tinggal saya', 'Rekomendasi dari keluarga', 'Parepare kota yang ramah', 1, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(3, 'Menurut Anda, bagaimana kondisi perekonomian keluarga Anda?', 'Kurang', 'Cukup', 'Sedang', 'Lebih', 1, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(4, 'Dari manakah hasil sumber pendapatan untuk biaya kuliah Anda?', 'Dari orang tua', 'Dari diri sendiri', 'Dari Keluarga yang lain', 'Dari Pemerintah', 1, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(5, 'Mengapa Anda tertarik dengan prodi yang Anda pilih sekarang?', 'Banyak alumninya yang berhasil', 'Saya tertarik dengan ilmunya', 'Keluarga saya menyarankan', 'Keinginan orang tua', 1, '2026-02-25 18:21:11', '2026-02-25 18:21:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_studis`
--

CREATE TABLE `program_studis` (
  `kodeProdi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaProdi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenjang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kuota` int NOT NULL,
  `passingGrade` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `program_studis`
--

INSERT INTO `program_studis` (`kodeProdi`, `namaProdi`, `jenjang`, `fakultas`, `kuota`, `passingGrade`, `created_at`, `updated_at`) VALUES
('110', 'Pendidikan Matematika', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('120', 'Pendidikan Bahasa Inggris', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('130', 'Pendidikan Biologi', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('140', 'Pendidikan Non Formal', 'S1', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('150', 'Peternakan', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('160', 'Agroteknologi', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('170', 'Agribisnis', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('180', 'Teknik Elektro', 'S1', 'Fakultas Teknik', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('190', 'Teknik Sipil', 'S1', 'Fakultas Teknik', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('200', 'Manajemen', 'S1', 'Fakultas Ekonomi dan Bisnis', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('210', 'Akuntansi', 'S1', 'Fakultas Ekonomi dan Bisnis', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('220', 'Ekonomi Pembangunan', 'S1', 'Fakultas Ekonomi dan Bisnis', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('230', 'Perbankan Syariah', 'S1', 'Fakultas Ekonomi dan Bisnis', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('240', 'Kesehatan Masyarakat', 'S1', 'Fakultas Ilmu Kesehatan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('250', 'Pendidikan Agama Islam', 'S1', 'Fakultas Agama Islam', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('260', 'Bimbingan dan Penyuluhan Islam', 'S1', 'Fakultas Agama Islam', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('270', 'Budidaya Perairan', 'S1', 'Fakultas Pertanian, Peternakan, dan Perikanan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('280', 'Teknik Informatika', 'S1', 'Fakultas Teknik', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('290', 'Magister Agribisnis', 'S2', 'Fakultas Pertanian, Peternakan, dan Perikanan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('300', 'Magister Manajemen', 'S2', 'Fakultas Ekonomi dan Bisnis', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('310', 'Magister Pendidikan Agama Islam', 'S2', 'Fakultas Agama Islam', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('340', 'Pendidikan Islam Anak Usia Dini', 'S1', 'Fakultas Agama Islam', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('350', 'Pendidikan Profesi Guru (PPG)', 'Profesi', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('360', 'Ilmu Hukum', 'S1', 'Fakultas Hukum', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('370', 'Doktor Pendidikan Agama Islam', 'S3', 'Fakultas Agama Islam', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('380', 'Perencanaan Wilayah dan Kota', 'S1', 'Fakultas Teknik', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
('390', 'Gizi', 'S1', 'Fakultas Ilmu Kesehatan', 0, NULL, '2026-02-25 18:21:11', '2026-02-25 18:21:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasis`
--

CREATE TABLE `registrasis` (
  `idRegistrasi` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nomorPendaftaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaLengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenisKelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempatLahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggalLahir` date DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asalSekolah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahunLulus` int DEFAULT NULL,
  `programStudiPilihan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggalDaftar` date NOT NULL,
  `statusRegistrasi` enum('pending','lunas','diterima','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_prodi_selected` tinyint(1) NOT NULL DEFAULT '0',
  `is_bayar_pendaftaran` tinyint(1) NOT NULL DEFAULT '0',
  `is_data_completed` tinyint(1) NOT NULL DEFAULT '0',
  `is_dokumen_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_tes_selesai` tinyint(1) NOT NULL DEFAULT '0',
  `is_wawancara_selesai` tinyint(1) NOT NULL DEFAULT '0',
  `is_daftar_ulang` tinyint(1) NOT NULL DEFAULT '0',
  `is_ukt_paid` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `registrasis`
--

INSERT INTO `registrasis` (`idRegistrasi`, `user_id`, `nomorPendaftaran`, `namaLengkap`, `jenisKelamin`, `tempatLahir`, `tanggalLahir`, `agama`, `alamat`, `asalSekolah`, `jurusan`, `tahunLulus`, `programStudiPilihan`, `tanggalDaftar`, `statusRegistrasi`, `is_prodi_selected`, `is_bayar_pendaftaran`, `is_data_completed`, `is_dokumen_uploaded`, `is_tes_selesai`, `is_wawancara_selesai`, `is_daftar_ulang`, `is_ukt_paid`, `created_at`, `updated_at`, `twitter`, `facebook`, `tiktok`, `instagram`) VALUES
(2, 3, 'UMPAR-000003', 'Riswan', NULL, '-', '2026-03-01', '-', '-', '-', '-', 0, NULL, '2026-03-01', 'pending', 0, 0, 0, 0, 0, 0, 0, 0, '2026-02-28 18:20:35', '2026-02-28 18:20:35', NULL, NULL, NULL, NULL),
(3, 4, 'UMPAR-000004', 'Hasni', NULL, '-', '2026-03-01', '-', '-', '-', '-', 0, NULL, '2026-03-01', 'pending', 0, 0, 0, 0, 0, 0, 0, 0, '2026-02-28 18:54:26', '2026-02-28 18:54:26', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `soals`
--

CREATE TABLE `soals` (
  `idSoal` bigint UNSIGNED NOT NULL,
  `textSoal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_soal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opsi_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opsi_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawabanBenar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `soals`
--

INSERT INTO `soals` (`idSoal`, `textSoal`, `gambar_soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawabanBenar`, `created_at`, `updated_at`) VALUES
(1, 'Tes Antonim: Statis', NULL, 'Begitu saja', 'Terus-terusan', 'Bergerak', 'Diam', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(2, 'Tes Antonim: Partisan', NULL, 'Pihak', 'Netral', 'Partai Politik', 'Kelompok', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(3, 'Tes Sinonim: Konjungsi', NULL, 'Tasrif', 'Pemugaran', 'Penghubung', 'Penyesuaian', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(4, 'Tes Antonim: Rigid', NULL, 'Kaku', 'Keras', 'Luwes', 'Bisa ditawar', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(5, 'Tes Sinonim: Assessment', NULL, 'Taksiran', 'Timbang terima', 'Suka', 'Timbang Pilih', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(6, 'Tes Sinonim: Fusi', NULL, 'Gabungan', 'Reaksi', 'Inti', 'Energi', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(7, 'Tes Sinonim: Absorpsi', NULL, 'Penafsiran', 'Penyerapan', 'Pengeluaran', 'Penerimaan', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(8, 'Pizza : Gandum = ?', NULL, 'Patung : Pemahat', 'Gambar : Pelukis', 'Genteng : Tanah Liat', 'Rumah : Tukang', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(9, 'Tes Antonim: Afeksi', NULL, 'Kejahatan', 'Perasaan', 'Kasih sayang', 'Cinta', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(10, 'Tes Pengelompokan Kata: Mana yang tidak masuk dalam kelompoknya?', NULL, 'Minister of economy', 'Minister of defence', 'Minister of Trade', 'Prime minister', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(11, 'Mana yang tidak masuk dalam kelompoknya?', NULL, 'Suzuki', 'Marcedes', 'Toyota', 'Xenia', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(12, 'Tes Sinonim: Anonim', NULL, 'Kepanjangan dari', 'Nama singkat', 'Singkatan', 'Tanpa nama', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(13, 'Tes Antonim: Prematur', NULL, 'Terlambat', 'Besar', 'Dini', 'Kecil', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(14, 'Padi : Wereng = Bayam : ?', NULL, 'Belatung', 'Ulat', 'Kera', 'Rumput', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(15, 'Tes Antonim: Persona non grata', NULL, 'Orang yang membumi', 'Orang Asing', 'Orang yang disukai', 'Orang pribumi', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(16, 'Soekarno Hatta : Indonesia = Changi : ?', NULL, 'Singapura', 'India', 'Thailand', 'Australia', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(17, 'Tes Sinonim: Komputasi', NULL, 'Perhitungan', 'Canggih', 'Ilmu tentang komputer', 'Pemotongan', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(18, 'Tes Antonim: Landai', NULL, 'Datar', 'Curam', 'Sedang', 'Luas', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(19, 'Gudeg : Malioboro = Stadion Manahan : ?', NULL, 'Indonesia Plaza', 'Pasar Beringharjo', 'Keraton Solo', 'Stadion Gajayana', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(20, 'Tes Sinonim: Domain', NULL, 'Website', 'Situs', 'Daerah', 'Internet', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(21, 'Pesawat : Avtur = ?', NULL, 'Hand Phone : Baterai', 'Pedati : Kuda', 'Radio : Listrik', 'Sepeda motor : Bensin', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(22, 'Bodoh : Idiot = ?', NULL, 'Pintar : Pandai', 'Rajin : Pintar', 'Dungu : Cerdas', 'Pandai : Jenius', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(23, 'Tes Sinonim: Nomenklatur', NULL, 'Nominatur', 'Kandidat', 'Tata nama', 'Ilmu hewan', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(24, 'Tes Sinonim: Komposit', NULL, 'Campuran', 'Komponen', 'Pupuk Kandang', 'Kompos', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(25, 'Modern : Tradisional = ?', NULL, 'Mobil : Pedati', 'Roket : Rudal Scud', 'Pesawat : Sepeda Motor', 'Ferrari : Fiat', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(26, 'Tes Sinonim: Artifisial', NULL, 'Buatan', 'Murni', 'Campuran', 'Alami', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(27, 'Ilmu tentang Bumi : Geologi = Ilmu tentang penggambaran Bumi : ?', NULL, 'Demografi', 'Geomorfologi', 'Geodesi', 'Geografi', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(28, 'Tes Sinonim: Efektif', NULL, 'Tepat Sasaran', 'Tepat waktu', 'Manjur', 'Hemat', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(29, 'Mana yang tidak masuk dalam kelompoknya?', NULL, 'Nokia', 'Sagem', 'Samsung', 'Huawei', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(30, 'Gading : Gajah = ?', NULL, 'Kulit : Ular', 'Gigi : Singa', 'Taring : Macan', 'Kuping : Kelinci', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(31, 'Tes Logika: \"Semua pejabat Pemda mendapat mobil dinas. Pak Rahmat adalah mantan pejabat Pemda. Jadi, Pak Rahmat tidak lagi mendapatkan mobil dinas\". Pilihlah jawaban yang tepat dari pernyataan diatas.', NULL, 'Pernyataan pertama dan kedua salah', 'Benar Semua', 'Salah pada pernyataan kedua', 'Salah pada pernyataan pertama', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(32, 'Tes Logika: \"Segala tentang hewan dapat dipelajari dalam ilmu anomologi. Burhan tertarik mempelajari kehidupan macan, buaya, singa dan hewan lainnya. Burhan harus mempelajari ilmu Animologi\". Pilihlah jawaban yang tepat dari pernyataan diatas.', NULL, 'Salah pada pernyataan kedua', 'Pernyataan pertama dan kedua salah', 'Salah pada pernyataan pertama', 'Benar Semua', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(33, 'Tes Logika Cerita: Dodi seorang anak yatim. Dia memiliki kucing kesayangan yang dinamakan Didi. Dodi dan Didi kemana-mana sering berdua bagaikan kakak beradik. Di sekolah Dodi sangat disayangi oleh Bu Rina di antara seluruh murid kelas 1 SD. Toni adalah teman paling akrab Dodi, meski tidak seangkatan, mereka berdua sangat akrab dan sering bermain di sungai dan sawah bersama. Mana yang mungkin terjadi?', NULL, 'Toni suka mengejek Dodi sehingga Dodi sangat membencinya', 'Dodi tidak disukai teman-teman kelasnya karena berwajah galak', 'Toni dan Dodi sering berkelahi karena Toni suka mengolok-olok Dodi', 'Rumah Dodi dan Pak Sobarin berada di sebelah selatan sekolah, sedangkan tempat kerja Pak Sobari berada di sebelah utara sekolah Dodi', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(34, 'Tes Logika Cerita: Ada 8 kotak peti, masing-masing diberi nomor 1 sampai 7. Buah jambu, melon, semangka, jeruk, mangga dan durian akan dimasukkan ke dalam peti-peti tersebut dengan aturan: Durian harus dimasukkan ke peti nomor 4, Semangka tidak boleh diletakkan tepat di samping melon, Jeruk harus diletakkan di samping mangga. Jika jambu diletakkan di nomor 1, jeruk di nomor 2, maka manakah yang tidak boleh?', NULL, 'Melon di nomor 7', 'Semangka di nomor 3', 'Mangga di nomor 3', 'Semangka di nomor 5', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(35, 'Tes Logika Umum: Sebagian siswa SDN 02 suka bakso. Semua siswa SDN 02 suka soto. Jadi...', NULL, 'Siswa SDN 02 yang suka soto pastilah juga suka bakso', 'Siswa SDN 02 yang suka bakso pasti juga suka soto', 'Siswa SDN 02 yang tidak suka soto suka bakso', 'Belum tentu siswa SDN 02 yang tidak suka bakso suka soto', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(36, 'Tes Logika Umum: Sebagian orang yang berminat menjadi politikus hanya menginginkan harta dan tahta. Rosyid tidak berminat menjadi politikus. Kesimpulannya...', NULL, 'Rosyid menginginkan tahta tapi tidak berminat menjadi politikus', 'Rosyid tidak menginginkan harta dan tahta', 'Tidak Dapat Ditarik Kesimpulan', 'Tahta bukanlah keinginan Rosyid, tapi harta mungkin ya', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(37, 'Tes Logika Cerita: Ada 8 kotak peti, masing-masing diberi nomor 1 sampai 7. Buah jambu, melon, semangka, jeruk, mangga dan durian akan dimasukkan ke dalam peti-peti tersebut dengan aturan: Durian harus dimasukkan ke peti nomor 4, Semangka tidak boleh diletakkan tepat di samping melon, Jeruk harus diletakkan di samping mangga. Jika semangka diletakkan di peti nomor 5, jambu di nomor 6, dan melon di nomor 7, maka ada berapa kemungkinan pengaturan letak buah sesuai dengan aturan diatas?', NULL, '5', '4', '6', '3', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(38, 'Tes Logika Cerita: Dodi seorang anak yatim. Dia memiliki kucing kesayangan yang dinamakan Didi. Di sekolah Dodi sangat disayangi oleh Bu Rina di antara seluruh murid kelas 1 SD. Toni adalah teman paling akrab Dodi, meski tidak seangkatan. Mana yang mungkin terjadi?', NULL, 'Dodi anak yang sangat manja', 'Di sekolah, ada teman Dodi bernama Nina dan Dina yang paling disayang Bu Rina karena keduanya adalah anak kembar', 'Toni adalah murid kelas 2 SD di sekolah Dodi', 'Ibu Dodi sudah meninggal dunia setelah sakit parah dan dirawat di rumah sakit selama 2 tahun', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(39, 'Tes Logika Angka: X adalah 19,95% dari 77, dan Y = 77% dari 19,95. Maka pernyataan yang benar adalah...', NULL, 'Y > X', 'X/Y = 1/77', 'X dan Y nilainya sama', 'X - Y = bilangan Negatif', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(40, 'Seri huruf: a c f j o selanjutnya adalah...', NULL, 'u', 'p', 't', 'v', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(41, 'Seri huruf: c i o selanjutnya...', NULL, 'w', 'v', 't', 'u', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(42, 'Seri angka: 1 4 15 2 5 14 3 6 13 selanjutnya...', NULL, '4 7 11', '5 8 13', '4 8 12', '4 7 12', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(43, 'Kemal berjalan lurus ke arah barat ke rumah Syaiful sejauh 6 km. Lalu ke rumah Fifi lurus ke utara sejauh 8 km. Bila Kemal langsung berjalan lurus ke rumah Fifi tanpa pergi ke rumah Syaiful, berapa km dia dapat menghemat lintasan?', NULL, '6 km', '4 km', '1 km', '8 km', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(44, '7,95 : 3 = ?', NULL, '3,65', '2,65', '2,56', '1,65', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(45, 'Volume jika penuh adalah 42,5 liter. Namun hanya terisi 3/5 saja saat ini, dan diambil lagi oleh Andi sehingga kini hanya terisi 1/5 saja. Berapa literkah yang diambil Andi?', NULL, '17 liter', '8,5 liter', '17,5 liter', '8 liter', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(46, 'Jika a = 6, b = 5, c = (2a-b)/(ab). Berapakah abc?', NULL, '6', '7', '15', '8', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(47, '2 pangkat 18 / 2 pangkat 6 = ?', NULL, '2 pangkat 3', '2 pangkat minus 12', '2 pangkat 24', '2 pangkat 12', 'd', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(48, 'Seri angka: 75 97 60 92 45 selanjutnya...', NULL, '102', '78', '75', '87', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(49, 'Seri angka: 22 26 23 27 24 selanjutnya...', NULL, '28', '27', '31', '26', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(50, 'Pak Hakim memiliki sejumlah x kelereng dan dibagikan merata kepada n orang. Setiap orang mendapatkan masing-masing 12 kelereng. Bila ada 2 orang yang bergabung untuk minta kebagian kelereng, dan kemudian x kelereng tersebut dibagikan merata, maka tiap orang mendapatkan 8 kelereng saja. Berapa jumlah n (kelompok pertama) dan berapa jumlah x (jumlah kelereng)?', NULL, 'n = 8 Orang, x = 48 kelereng', 'n = 4 orang, x = 48 kelereng', 'n = 2 orang, x = 48 kelereng', 'n = 6 orang, x = 44 kelereng', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(51, 'Seri huruf: h m i n j selanjutnya...', NULL, 'm k', 'z a', 'l p', 'o k', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(52, 'Bela membeli baju dengan harga terdiskon 15% dari Rp.80.000,-. Setelah itu karena Bela sedang berulang tahun, dia mendapat diskon tambahan sebesar 25% dari harga awal setelah dikurangi diskon 15% di atas. Berapakah harga yang harus dibayarkan oleh Bela ke kasir?', NULL, 'Rp. 51.000,-', 'Rp. 84.000,-', 'Rp. 50.000,-', 'Rp. 55.000,-', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(53, '2,00486 x 0,5 = ?', NULL, '1,000243', '1,00243', '1,00253', '1,0243', 'b', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(54, 'Dani memiliki 18 kelereng di kantong: 7 warna kuning, 5 warna biru, dan 6 warna merah. Berapakah jumlah minimum yang harus diambil Dani untuk memastikan bahwa dia mendapatkan setidaknya 1 kelereng untuk tiap warna?', NULL, '13', '15', '12', '14', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(55, 'Seri angka: 44 35 15 43 33 15 42 32 15 selanjutnya...', NULL, '41 31', '41 30', '30 40', '31 41', 'a', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(56, 'Tes Logika Angka: Persamaan X(p + q) + xr nilainya sama dengan persamaan berikut, kecuali:', NULL, 'x(p+r) + xq', 'x(p+q+r)', 'xp(q+r)', 'xp + xr + xq', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(57, '(0,31) pangkat 2 = ?', NULL, '0,0661', '0,0691', '0,0971', '0,0991', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11'),
(58, 'Ridho harus mengkredit sebuah laptop dengan lima kali cicilan. Jika uang mukanya sebesar Rp.1.500.000,- yang merupakan 30% dari harga laptop, berapa rupiah yang harus dibayarkan Ridho tiap kali cicilan?', NULL, 'Rp. 800.000,-', 'Rp. 850.000,-', 'Rp. 700.000,-', 'Rp. 750.000,-', 'c', '2026-02-25 18:21:11', '2026-02-25 18:21:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujians`
--

CREATE TABLE `ujians` (
  `idUjian` bigint UNSIGNED NOT NULL,
  `idUser` bigint UNSIGNED NOT NULL,
  `waktuMulai` datetime DEFAULT NULL,
  `waktuSelesai` datetime DEFAULT NULL,
  `status` enum('belum_mulai','sedang_berlangsung','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_mulai',
  `nilaiAkhir` decimal(5,2) DEFAULT NULL,
  `jumlahBenar` int NOT NULL DEFAULT '0',
  `jumlahSalah` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akun_fb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akun_instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akun_tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akun_twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_registrasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomorPendaftaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pilihan_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pilihan_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_prodi_selected` tinyint(1) NOT NULL DEFAULT '0',
  `is_bayar_pendaftaran` tinyint(1) NOT NULL DEFAULT '0',
  `is_data_completed` tinyint(1) NOT NULL DEFAULT '0',
  `is_dokumen_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_tes_selesai` tinyint(1) NOT NULL DEFAULT '0',
  `is_wawancara_selesai` tinyint(1) NOT NULL DEFAULT '0',
  `is_daftar_ulang` tinyint(1) NOT NULL DEFAULT '0',
  `is_ukt_paid` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('admin','user','keuangan','wr-3','admisi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `nama_lengkap`, `nik`, `no_whatsapp`, `akun_fb`, `akun_instagram`, `akun_tiktok`, `akun_twitter`, `is_verified`, `email_verified_at`, `verification_token`, `nomor_registrasi`, `nomorPendaftaran`, `nim`, `pilihan_1`, `pilihan_2`, `is_prodi_selected`, `is_bayar_pendaftaran`, `is_data_completed`, `is_dokumen_uploaded`, `is_tes_selesai`, `is_wawancara_selesai`, `is_daftar_ulang`, `is_ukt_paid`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'keuangan', 'keuangan@gmail.com', '$2y$12$j1O8DCDxOE.ZalqQIrchT.GvUYi/Gf9Fr8ePNdJduRFVuZpGNQRZi', 'Keuangan', '7730274894576237', '081242210604', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'admisi', NULL, '2026-02-25 18:31:00', '2026-02-25 18:31:00'),
(3, 'ciwang', 'riswanpnr34@gmail.com', '$2y$12$t8QbJtqkb5Negkf7xU46Gu4Hh.fyiChRDUiUklD3dJ6BBJEOxj2/C', 'Riswan', '7730274894576239', '082194319090', NULL, NULL, NULL, NULL, 1, '2026-02-28 18:58:29', NULL, 'UMPAR-000003', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 'admin', NULL, '2026-02-28 18:20:35', '2026-02-28 18:58:29'),
(4, 'nino', 'hasninino1610@gmail.com', '$2y$12$puICheXADz1bov4o5Tt0J.GQby1r2KBMEV0svkacgWjlf8vGrS5Nq', 'Hasni', '7730274894576257', '082194319090', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'UMPAR-000004', NULL, NULL, '360', '280', 1, 0, 0, 0, 0, 0, 0, 0, 'user', NULL, '2026-02-28 18:54:26', '2026-02-28 19:46:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wawancaras`
--

CREATE TABLE `wawancaras` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jawaban` json NOT NULL,
  `tanggal_wawancara` timestamp NULL DEFAULT NULL,
  `sudah_wawancara` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`idAdmin`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indeks untuk tabel `biaya_pmb`
--
ALTER TABLE `biaya_pmb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biaya_pmb_kodeprodi_foreign` (`kodeProdi`),
  ADD KEY `biaya_pmb_tahun_kodeprodi_index` (`tahun`,`kodeProdi`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `dokumens`
--
ALTER TABLE `dokumens`
  ADD PRIMARY KEY (`idDokumen`),
  ADD KEY `dokumens_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `formulir_pendaftarans`
--
ALTER TABLE `formulir_pendaftarans`
  ADD PRIMARY KEY (`idFormulir`),
  ADD UNIQUE KEY `formulir_pendaftarans_nomorpendaftaran_unique` (`nomorPendaftaran`),
  ADD UNIQUE KEY `formulir_pendaftarans_kodeakses_unique` (`kodeAkses`),
  ADD KEY `formulir_pendaftarans_user_id_foreign` (`user_id`),
  ADD KEY `formulir_pendaftarans_programstudipilihan_foreign` (`programStudiPilihan`);

--
-- Indeks untuk tabel `jawabans`
--
ALTER TABLE `jawabans`
  ADD PRIMARY KEY (`idJawaban`),
  ADD KEY `jawabans_idsoal_foreign` (`idSoal`),
  ADD KEY `jawabans_idujian_foreign` (`idUjian`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `landing_page_contents`
--
ALTER TABLE `landing_page_contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `landing_page_contents_section_key_unique` (`section`,`key`);

--
-- Indeks untuk tabel `leaderboards`
--
ALTER TABLE `leaderboards`
  ADD PRIMARY KEY (`idLeaderboard`),
  ADD KEY `leaderboards_iduser_foreign` (`idUser`),
  ADD KEY `leaderboards_idujian_foreign` (`idUjian`);

--
-- Indeks untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswas_nim_unique` (`nim`),
  ADD KEY `mahasiswas_user_id_foreign` (`user_id`),
  ADD KEY `mahasiswas_kodeprodi_foreign` (`kodeProdi`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_order_id_unique` (`order_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pertanyaan_wawancaras`
--
ALTER TABLE `pertanyaan_wawancaras`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `program_studis`
--
ALTER TABLE `program_studis`
  ADD PRIMARY KEY (`kodeProdi`);

--
-- Indeks untuk tabel `registrasis`
--
ALTER TABLE `registrasis`
  ADD PRIMARY KEY (`idRegistrasi`),
  ADD UNIQUE KEY `registrasis_nomorpendaftaran_unique` (`nomorPendaftaran`),
  ADD KEY `registrasis_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `soals`
--
ALTER TABLE `soals`
  ADD PRIMARY KEY (`idSoal`);

--
-- Indeks untuk tabel `ujians`
--
ALTER TABLE `ujians`
  ADD PRIMARY KEY (`idUjian`),
  ADD KEY `ujians_iduser_foreign` (`idUser`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`),
  ADD UNIQUE KEY `users_akun_fb_unique` (`akun_fb`),
  ADD UNIQUE KEY `users_akun_instagram_unique` (`akun_instagram`),
  ADD UNIQUE KEY `users_akun_tiktok_unique` (`akun_tiktok`),
  ADD UNIQUE KEY `users_akun_twitter_unique` (`akun_twitter`),
  ADD UNIQUE KEY `users_nomor_registrasi_unique` (`nomor_registrasi`),
  ADD UNIQUE KEY `users_nomorpendaftaran_unique` (`nomorPendaftaran`),
  ADD UNIQUE KEY `users_nim_unique` (`nim`);

--
-- Indeks untuk tabel `wawancaras`
--
ALTER TABLE `wawancaras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wawancaras_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `idAdmin` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `biaya_pmb`
--
ALTER TABLE `biaya_pmb`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `dokumens`
--
ALTER TABLE `dokumens`
  MODIFY `idDokumen` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `formulir_pendaftarans`
--
ALTER TABLE `formulir_pendaftarans`
  MODIFY `idFormulir` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jawabans`
--
ALTER TABLE `jawabans`
  MODIFY `idJawaban` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `landing_page_contents`
--
ALTER TABLE `landing_page_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `leaderboards`
--
ALTER TABLE `leaderboards`
  MODIFY `idLeaderboard` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan_wawancaras`
--
ALTER TABLE `pertanyaan_wawancaras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `registrasis`
--
ALTER TABLE `registrasis`
  MODIFY `idRegistrasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `soals`
--
ALTER TABLE `soals`
  MODIFY `idSoal` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `ujians`
--
ALTER TABLE `ujians`
  MODIFY `idUjian` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `wawancaras`
--
ALTER TABLE `wawancaras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `biaya_pmb`
--
ALTER TABLE `biaya_pmb`
  ADD CONSTRAINT `biaya_pmb_kodeprodi_foreign` FOREIGN KEY (`kodeProdi`) REFERENCES `program_studis` (`kodeProdi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dokumens`
--
ALTER TABLE `dokumens`
  ADD CONSTRAINT `dokumens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `formulir_pendaftarans`
--
ALTER TABLE `formulir_pendaftarans`
  ADD CONSTRAINT `formulir_pendaftarans_programstudipilihan_foreign` FOREIGN KEY (`programStudiPilihan`) REFERENCES `program_studis` (`kodeProdi`) ON DELETE RESTRICT,
  ADD CONSTRAINT `formulir_pendaftarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawabans`
--
ALTER TABLE `jawabans`
  ADD CONSTRAINT `jawabans_idsoal_foreign` FOREIGN KEY (`idSoal`) REFERENCES `soals` (`idSoal`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawabans_idujian_foreign` FOREIGN KEY (`idUjian`) REFERENCES `ujians` (`idUjian`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `leaderboards`
--
ALTER TABLE `leaderboards`
  ADD CONSTRAINT `leaderboards_idujian_foreign` FOREIGN KEY (`idUjian`) REFERENCES `ujians` (`idUjian`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaderboards_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD CONSTRAINT `mahasiswas_kodeprodi_foreign` FOREIGN KEY (`kodeProdi`) REFERENCES `program_studis` (`kodeProdi`) ON DELETE RESTRICT,
  ADD CONSTRAINT `mahasiswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `registrasis`
--
ALTER TABLE `registrasis`
  ADD CONSTRAINT `registrasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ujians`
--
ALTER TABLE `ujians`
  ADD CONSTRAINT `ujians_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wawancaras`
--
ALTER TABLE `wawancaras`
  ADD CONSTRAINT `wawancaras_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
