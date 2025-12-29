<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SoalSeeder extends Seeder
{
    public function run(): void
    {
        $soals = [
            // Soal 1
            [
                'textSoal' => 'Tes Antonim: Statis',
                'opsi_a' => 'Begitu saja',
                'opsi_b' => 'Terus-terusan',
                'opsi_c' => 'Bergerak',
                'opsi_d' => 'Diam',
                'jawabanBenar' => 'c',
            ],
            // Soal 2
            [
                'textSoal' => 'Tes Antonim: Partisan',
                'opsi_a' => 'Pihak',
                'opsi_b' => 'Netral',
                'opsi_c' => 'Partai Politik',
                'opsi_d' => 'Kelompok',
                'jawabanBenar' => 'b',
            ],
            // Soal 3
            [
                'textSoal' => 'Tes Sinonim: Konjungsi',
                'opsi_a' => 'Tasrif',
                'opsi_b' => 'Pemugaran',
                'opsi_c' => 'Penghubung',
                'opsi_d' => 'Penyesuaian',
                'jawabanBenar' => 'c',
            ],
            // Soal 4
            [
                'textSoal' => 'Tes Antonim: Rigid',
                'opsi_a' => 'Kaku',
                'opsi_b' => 'Keras',
                'opsi_c' => 'Luwes',
                'opsi_d' => 'Bisa ditawar',
                'jawabanBenar' => 'c',
            ],
            // Soal 5
            [
                'textSoal' => 'Tes Sinonim: Assessment',
                'opsi_a' => 'Taksiran',
                'opsi_b' => 'Timbang terima',
                'opsi_c' => 'Suka',
                'opsi_d' => 'Timbang Pilih',
                'jawabanBenar' => 'a',
            ],
            // Soal 6
            [
                'textSoal' => 'Tes Sinonim: Fusi',
                'opsi_a' => 'Gabungan',
                'opsi_b' => 'Reaksi',
                'opsi_c' => 'Inti',
                'opsi_d' => 'Energi',
                'jawabanBenar' => 'a',
            ],
            // Soal 7
            [
                'textSoal' => 'Tes Sinonim: Absorpsi',
                'opsi_a' => 'Penafsiran',
                'opsi_b' => 'Penyerapan',
                'opsi_c' => 'Pengeluaran',
                'opsi_d' => 'Penerimaan',
                'jawabanBenar' => 'b',
            ],
            // Soal 8
            [
                'textSoal' => 'Pizza : Gandum = ?',
                'opsi_a' => 'Patung : Pemahat',
                'opsi_b' => 'Gambar : Pelukis',
                'opsi_c' => 'Genteng : Tanah Liat',
                'opsi_d' => 'Rumah : Tukang',
                'jawabanBenar' => 'b',
            ],
            // Soal 9
            [
                'textSoal' => 'Tes Antonim: Afeksi',
                'opsi_a' => 'Kejahatan',
                'opsi_b' => 'Perasaan',
                'opsi_c' => 'Kasih sayang',
                'opsi_d' => 'Cinta',
                'jawabanBenar' => 'a',
            ],
            // Soal 10
            [
                'textSoal' => 'Tes Pengelompokan Kata: Mana yang tidak masuk dalam kelompoknya?',
                'opsi_a' => 'Minister of economy',
                'opsi_b' => 'Minister of defence',
                'opsi_c' => 'Minister of Trade',
                'opsi_d' => 'Prime minister',
                'jawabanBenar' => 'd',
            ],
            // Soal 11
            [
                'textSoal' => 'Mana yang tidak masuk dalam kelompoknya?',
                'opsi_a' => 'Suzuki',
                'opsi_b' => 'Marcedes',
                'opsi_c' => 'Toyota',
                'opsi_d' => 'Xenia',
                'jawabanBenar' => 'd',
            ],
            // Soal 12
            [
                'textSoal' => 'Tes Sinonim: Anonim',
                'opsi_a' => 'Kepanjangan dari',
                'opsi_b' => 'Nama singkat',
                'opsi_c' => 'Singkatan',
                'opsi_d' => 'Tanpa nama',
                'jawabanBenar' => 'd',
            ],
            // Soal 13
            [
                'textSoal' => 'Tes Antonim: Prematur',
                'opsi_a' => 'Terlambat',
                'opsi_b' => 'Besar',
                'opsi_c' => 'Dini',
                'opsi_d' => 'Kecil',
                'jawabanBenar' => 'a',
            ],
            // Soal 14
            [
                'textSoal' => 'Padi : Wereng = Bayam : ?',
                'opsi_a' => 'Belatung',
                'opsi_b' => 'Ulat',
                'opsi_c' => 'Kera',
                'opsi_d' => 'Rumput',
                'jawabanBenar' => 'b',
            ],
            // Soal 15
            [
                'textSoal' => 'Tes Antonim: Persona non grata',
                'opsi_a' => 'Orang yang membumi',
                'opsi_b' => 'Orang Asing',
                'opsi_c' => 'Orang yang disukai',
                'opsi_d' => 'Orang pribumi',
                'jawabanBenar' => 'c',
            ],
            // Soal 16
            [
                'textSoal' => 'Soekarno Hatta : Indonesia = Changi : ?',
                'opsi_a' => 'Singapura',
                'opsi_b' => 'India',
                'opsi_c' => 'Thailand',
                'opsi_d' => 'Australia',
                'jawabanBenar' => 'a',
            ],
            // Soal 17
            [
                'textSoal' => 'Tes Sinonim: Komputasi',
                'opsi_a' => 'Perhitungan',
                'opsi_b' => 'Canggih',
                'opsi_c' => 'Ilmu tentang komputer',
                'opsi_d' => 'Pemotongan',
                'jawabanBenar' => 'a',
            ],
            // Soal 18
            [
                'textSoal' => 'Tes Antonim: Landai',
                'opsi_a' => 'Datar',
                'opsi_b' => 'Curam',
                'opsi_c' => 'Sedang',
                'opsi_d' => 'Luas',
                'jawabanBenar' => 'b',
            ],
            // Soal 19
            [
                'textSoal' => 'Gudeg : Malioboro = Stadion Manahan : ?',
                'opsi_a' => 'Indonesia Plaza',
                'opsi_b' => 'Pasar Beringharjo',
                'opsi_c' => 'Keraton Solo',
                'opsi_d' => 'Stadion Gajayana',
                'jawabanBenar' => 'c',
            ],
            // Soal 20
            [
                'textSoal' => 'Tes Sinonim: Domain',
                'opsi_a' => 'Website',
                'opsi_b' => 'Situs',
                'opsi_c' => 'Daerah',
                'opsi_d' => 'Internet',
                'jawabanBenar' => 'c',
            ],
            // Soal 21
            [
                'textSoal' => 'Pesawat : Avtur = ?',
                'opsi_a' => 'Hand Phone : Baterai',
                'opsi_b' => 'Pedati : Kuda',
                'opsi_c' => 'Radio : Listrik',
                'opsi_d' => 'Sepeda motor : Bensin',
                'jawabanBenar' => 'd',
            ],
            // Soal 22
            [
                'textSoal' => 'Bodoh : Idiot = ?',
                'opsi_a' => 'Pintar : Pandai',
                'opsi_b' => 'Rajin : Pintar',
                'opsi_c' => 'Dungu : Cerdas',
                'opsi_d' => 'Pandai : Jenius',
                'jawabanBenar' => 'a',
            ],
            // Soal 23
            [
                'textSoal' => 'Tes Sinonim: Nomenklatur',
                'opsi_a' => 'Nominatur',
                'opsi_b' => 'Kandidat',
                'opsi_c' => 'Tata nama',
                'opsi_d' => 'Ilmu hewan',
                'jawabanBenar' => 'c',
            ],
            // Soal 24
            [
                'textSoal' => 'Tes Sinonim: Komposit',
                'opsi_a' => 'Campuran',
                'opsi_b' => 'Komponen',
                'opsi_c' => 'Pupuk Kandang',
                'opsi_d' => 'Kompos',
                'jawabanBenar' => 'a',
            ],
            // Soal 25
            [
                'textSoal' => 'Modern : Tradisional = ?',
                'opsi_a' => 'Mobil : Pedati',
                'opsi_b' => 'Roket : Rudal Scud',
                'opsi_c' => 'Pesawat : Sepeda Motor',
                'opsi_d' => 'Ferrari : Fiat',
                'jawabanBenar' => 'a',
            ],
            // Soal 26
            [
                'textSoal' => 'Tes Sinonim: Artifisial',
                'opsi_a' => 'Buatan',
                'opsi_b' => 'Murni',
                'opsi_c' => 'Campuran',
                'opsi_d' => 'Alami',
                'jawabanBenar' => 'a',
            ],
            // Soal 27
            [
                'textSoal' => 'Ilmu tentang Bumi : Geologi = Ilmu tentang penggambaran Bumi : ?',
                'opsi_a' => 'Demografi',
                'opsi_b' => 'Geomorfologi',
                'opsi_c' => 'Geodesi',
                'opsi_d' => 'Geografi',
                'jawabanBenar' => 'd',
            ],
            // Soal 28
            [
                'textSoal' => 'Tes Sinonim: Efektif',
                'opsi_a' => 'Tepat Sasaran',
                'opsi_b' => 'Tepat waktu',
                'opsi_c' => 'Manjur',
                'opsi_d' => 'Hemat',
                'jawabanBenar' => 'c',
            ],
            // Soal 29
            [
                'textSoal' => 'Mana yang tidak masuk dalam kelompoknya?',
                'opsi_a' => 'Nokia',
                'opsi_b' => 'Sagem',
                'opsi_c' => 'Samsung',
                'opsi_d' => 'Huawei',
                'jawabanBenar' => 'a',
            ],
            // Soal 30
            [
                'textSoal' => 'Gading : Gajah = ?',
                'opsi_a' => 'Kulit : Ular',
                'opsi_b' => 'Gigi : Singa',
                'opsi_c' => 'Taring : Macan',
                'opsi_d' => 'Kuping : Kelinci',
                'jawabanBenar' => 'd',
            ],
            // Soal 31
            [
                'textSoal' => 'Tes Logika: "Semua pejabat Pemda mendapat mobil dinas. Pak Rahmat adalah mantan pejabat Pemda. Jadi, Pak Rahmat tidak lagi mendapatkan mobil dinas". Pilihlah jawaban yang tepat dari pernyataan diatas.',
                'opsi_a' => 'Pernyataan pertama dan kedua salah',
                'opsi_b' => 'Benar Semua',
                'opsi_c' => 'Salah pada pernyataan kedua',
                'opsi_d' => 'Salah pada pernyataan pertama',
                'jawabanBenar' => 'b',
            ],
            // Soal 33 (Soal 32 ada gambar, skip)
            [
                'textSoal' => 'Tes Logika: "Segala tentang hewan dapat dipelajari dalam ilmu anomologi. Burhan tertarik mempelajari kehidupan macan, buaya, singa dan hewan lainnya. Burhan harus mempelajari ilmu Animologi". Pilihlah jawaban yang tepat dari pernyataan diatas.',
                'opsi_a' => 'Salah pada pernyataan kedua',
                'opsi_b' => 'Pernyataan pertama dan kedua salah',
                'opsi_c' => 'Salah pada pernyataan pertama',
                'opsi_d' => 'Benar Semua',
                'jawabanBenar' => 'd',
            ],
            // Soal 34
            [
                'textSoal' => 'Tes Logika Cerita: Dodi seorang anak yatim. Dia memiliki kucing kesayangan yang dinamakan Didi. Dodi dan Didi kemana-mana sering berdua bagaikan kakak beradik. Di sekolah Dodi sangat disayangi oleh Bu Rina di antara seluruh murid kelas 1 SD. Toni adalah teman paling akrab Dodi, meski tidak seangkatan, mereka berdua sangat akrab dan sering bermain di sungai dan sawah bersama. Mana yang mungkin terjadi?',
                'opsi_a' => 'Toni suka mengejek Dodi sehingga Dodi sangat membencinya',
                'opsi_b' => 'Dodi tidak disukai teman-teman kelasnya karena berwajah galak',
                'opsi_c' => 'Toni dan Dodi sering berkelahi karena Toni suka mengolok-olok Dodi',
                'opsi_d' => 'Rumah Dodi dan Pak Sobarin berada di sebelah selatan sekolah, sedangkan tempat kerja Pak Sobari berada di sebelah utara sekolah Dodi',
                'jawabanBenar' => 'd',
            ],
            // Soal 35
            [
                'textSoal' => 'Tes Logika Cerita: Ada 8 kotak peti, masing-masing diberi nomor 1 sampai 7. Buah jambu, melon, semangka, jeruk, mangga dan durian akan dimasukkan ke dalam peti-peti tersebut dengan aturan: Durian harus dimasukkan ke peti nomor 4, Semangka tidak boleh diletakkan tepat di samping melon, Jeruk harus diletakkan di samping mangga. Jika jambu diletakkan di nomor 1, jeruk di nomor 2, maka manakah yang tidak boleh?',
                'opsi_a' => 'Melon di nomor 7',
                'opsi_b' => 'Semangka di nomor 3',
                'opsi_c' => 'Mangga di nomor 3',
                'opsi_d' => 'Semangka di nomor 5',
                'jawabanBenar' => 'b',
            ],
            // Soal 37 (Soal 36 ada gambar, skip)
            [
                'textSoal' => 'Tes Logika Umum: Sebagian siswa SDN 02 suka bakso. Semua siswa SDN 02 suka soto. Jadi...',
                'opsi_a' => 'Siswa SDN 02 yang suka soto pastilah juga suka bakso',
                'opsi_b' => 'Siswa SDN 02 yang suka bakso pasti juga suka soto',
                'opsi_c' => 'Siswa SDN 02 yang tidak suka soto suka bakso',
                'opsi_d' => 'Belum tentu siswa SDN 02 yang tidak suka bakso suka soto',
                'jawabanBenar' => 'b',
            ],
            // Soal 38
            [
                'textSoal' => 'Tes Logika Umum: Sebagian orang yang berminat menjadi politikus hanya menginginkan harta dan tahta. Rosyid tidak berminat menjadi politikus. Kesimpulannya...',
                'opsi_a' => 'Rosyid menginginkan tahta tapi tidak berminat menjadi politikus',
                'opsi_b' => 'Rosyid tidak menginginkan harta dan tahta',
                'opsi_c' => 'Tidak Dapat Ditarik Kesimpulan',
                'opsi_d' => 'Tahta bukanlah keinginan Rosyid, tapi harta mungkin ya',
                'jawabanBenar' => 'c',
            ],
            // Soal 39
            [
                'textSoal' => 'Tes Logika Cerita: Ada 8 kotak peti, masing-masing diberi nomor 1 sampai 7. Buah jambu, melon, semangka, jeruk, mangga dan durian akan dimasukkan ke dalam peti-peti tersebut dengan aturan: Durian harus dimasukkan ke peti nomor 4, Semangka tidak boleh diletakkan tepat di samping melon, Jeruk harus diletakkan di samping mangga. Jika semangka diletakkan di peti nomor 5, jambu di nomor 6, dan melon di nomor 7, maka ada berapa kemungkinan pengaturan letak buah sesuai dengan aturan diatas?',
                'opsi_a' => '5',
                'opsi_b' => '4',
                'opsi_c' => '6',
                'opsi_d' => '3',
                'jawabanBenar' => 'b',
            ],
            // Soal 40
            [
                'textSoal' => 'Tes Logika Cerita: Dodi seorang anak yatim. Dia memiliki kucing kesayangan yang dinamakan Didi. Di sekolah Dodi sangat disayangi oleh Bu Rina di antara seluruh murid kelas 1 SD. Toni adalah teman paling akrab Dodi, meski tidak seangkatan. Mana yang mungkin terjadi?',
                'opsi_a' => 'Dodi anak yang sangat manja',
                'opsi_b' => 'Di sekolah, ada teman Dodi bernama Nina dan Dina yang paling disayang Bu Rina karena keduanya adalah anak kembar',
                'opsi_c' => 'Toni adalah murid kelas 2 SD di sekolah Dodi',
                'opsi_d' => 'Ibu Dodi sudah meninggal dunia setelah sakit parah dan dirawat di rumah sakit selama 2 tahun',
                'jawabanBenar' => 'c',
            ],
            // Soal 41
            [
                'textSoal' => 'Tes Logika Angka: X adalah 19,95% dari 77, dan Y = 77% dari 19,95. Maka pernyataan yang benar adalah...',
                'opsi_a' => 'Y > X',
                'opsi_b' => 'X/Y = 1/77',
                'opsi_c' => 'X dan Y nilainya sama',
                'opsi_d' => 'X - Y = bilangan Negatif',
                'jawabanBenar' => 'c',
            ],
            // Soal 42
            [
                'textSoal' => 'Seri huruf: a c f j o selanjutnya adalah...',
                'opsi_a' => 'u',
                'opsi_b' => 'p',
                'opsi_c' => 't',
                'opsi_d' => 'v',
                'jawabanBenar' => 'a',
            ],
            // Soal 43
            [
                'textSoal' => 'Seri huruf: c i o selanjutnya...',
                'opsi_a' => 'w',
                'opsi_b' => 'v',
                'opsi_c' => 't',
                'opsi_d' => 'u',
                'jawabanBenar' => 'd',
            ],
            // Soal 44
            [
                'textSoal' => 'Seri angka: 1 4 15 2 5 14 3 6 13 selanjutnya...',
                'opsi_a' => '4 7 11',
                'opsi_b' => '5 8 13',
                'opsi_c' => '4 8 12',
                'opsi_d' => '4 7 12',
                'jawabanBenar' => 'd',
            ],
            // Soal 45
            [
                'textSoal' => 'Kemal berjalan lurus ke arah barat ke rumah Syaiful sejauh 6 km. Lalu ke rumah Fifi lurus ke utara sejauh 8 km. Bila Kemal langsung berjalan lurus ke rumah Fifi tanpa pergi ke rumah Syaiful, berapa km dia dapat menghemat lintasan?',
                'opsi_a' => '6 km',
                'opsi_b' => '4 km',
                'opsi_c' => '1 km',
                'opsi_d' => '8 km',
                'jawabanBenar' => 'b',
            ],
            // Soal 46
            [
                'textSoal' => '7,95 : 3 = ?',
                'opsi_a' => '3,65',
                'opsi_b' => '2,65',
                'opsi_c' => '2,56',
                'opsi_d' => '1,65',
                'jawabanBenar' => 'b',
            ],
            // Soal 47
            [
                'textSoal' => 'Volume jika penuh adalah 42,5 liter. Namun hanya terisi 3/5 saja saat ini, dan diambil lagi oleh Andi sehingga kini hanya terisi 1/5 saja. Berapa literkah yang diambil Andi?',
                'opsi_a' => '17 liter',
                'opsi_b' => '8,5 liter',
                'opsi_c' => '17,5 liter',
                'opsi_d' => '8 liter',
                'jawabanBenar' => 'a',
            ],
            // Soal 48
            [
                'textSoal' => 'Jika a = 6, b = 5, c = (2a-b)/(ab). Berapakah abc?',
                'opsi_a' => '6',
                'opsi_b' => '7',
                'opsi_c' => '15',
                'opsi_d' => '8',
                'jawabanBenar' => 'a',
            ],
            // Soal 49
            [
                'textSoal' => '2 pangkat 18 / 2 pangkat 6 = ?',
                'opsi_a' => '2 pangkat 3',
                'opsi_b' => '2 pangkat minus 12',
                'opsi_c' => '2 pangkat 24',
                'opsi_d' => '2 pangkat 12',
                'jawabanBenar' => 'd',
            ],
            // Soal 50
            [
                'textSoal' => 'Seri angka: 75 97 60 92 45 selanjutnya...',
                'opsi_a' => '102',
                'opsi_b' => '78',
                'opsi_c' => '75',
                'opsi_d' => '87',
                'jawabanBenar' => 'c',
            ],
            // Soal 51
            [
                'textSoal' => 'Seri angka: 22 26 23 27 24 selanjutnya...',
                'opsi_a' => '28',
                'opsi_b' => '27',
                'opsi_c' => '31',
                'opsi_d' => '26',
                'jawabanBenar' => 'a',
            ],
            // Soal 52
            [
                'textSoal' => 'Pak Hakim memiliki sejumlah x kelereng dan dibagikan merata kepada n orang. Setiap orang mendapatkan masing-masing 12 kelereng. Bila ada 2 orang yang bergabung untuk minta kebagian kelereng, dan kemudian x kelereng tersebut dibagikan merata, maka tiap orang mendapatkan 8 kelereng saja. Berapa jumlah n (kelompok pertama) dan berapa jumlah x (jumlah kelereng)?',
                'opsi_a' => 'n = 8 Orang, x = 48 kelereng',
                'opsi_b' => 'n = 4 orang, x = 48 kelereng',
                'opsi_c' => 'n = 2 orang, x = 48 kelereng',
                'opsi_d' => 'n = 6 orang, x = 44 kelereng',
                'jawabanBenar' => 'b',
            ],
            // Soal 53
            [
                'textSoal' => 'Seri huruf: h m i n j selanjutnya...',
                'opsi_a' => 'm k',
                'opsi_b' => 'z a',
                'opsi_c' => 'l p',
                'opsi_d' => 'o k',
                'jawabanBenar' => 'a',
            ],
            // Soal 54
            [
                'textSoal' => 'Bela membeli baju dengan harga terdiskon 15% dari Rp.80.000,-. Setelah itu karena Bela sedang berulang tahun, dia mendapat diskon tambahan sebesar 25% dari harga awal setelah dikurangi diskon 15% di atas. Berapakah harga yang harus dibayarkan oleh Bela ke kasir?',
                'opsi_a' => 'Rp. 51.000,-',
                'opsi_b' => 'Rp. 84.000,-',
                'opsi_c' => 'Rp. 50.000,-',
                'opsi_d' => 'Rp. 55.000,-',
                'jawabanBenar' => 'a',
            ],
            // Soal 55
            [
                'textSoal' => '2,00486 x 0,5 = ?',
                'opsi_a' => '1,000243',
                'opsi_b' => '1,00243',
                'opsi_c' => '1,00253',
                'opsi_d' => '1,0243',
                'jawabanBenar' => 'b',
            ],
            // Soal 56
            [
                'textSoal' => 'Dani memiliki 18 kelereng di kantong: 7 warna kuning, 5 warna biru, dan 6 warna merah. Berapakah jumlah minimum yang harus diambil Dani untuk memastikan bahwa dia mendapatkan setidaknya 1 kelereng untuk tiap warna?',
                'opsi_a' => '13',
                'opsi_b' => '15',
                'opsi_c' => '12',
                'opsi_d' => '14',
                'jawabanBenar' => 'a',
            ],
            // Soal 57
            [
                'textSoal' => 'Seri angka: 44 35 15 43 33 15 42 32 15 selanjutnya...',
                'opsi_a' => '41 31',
                'opsi_b' => '41 30',
                'opsi_c' => '30 40',
                'opsi_d' => '31 41',
                'jawabanBenar' => 'a',
            ],
            // Soal 58
            [
                'textSoal' => 'Tes Logika Angka: Persamaan X(p + q) + xr nilainya sama dengan persamaan berikut, kecuali:',
                'opsi_a' => 'x(p+r) + xq',
                'opsi_b' => 'x(p+q+r)',
                'opsi_c' => 'xp(q+r)',
                'opsi_d' => 'xp + xr + xq',
                'jawabanBenar' => 'c',
            ],
            // Soal 59
            [
                'textSoal' => '(0,31) pangkat 2 = ?',
                'opsi_a' => '0,0661',
                'opsi_b' => '0,0691',
                'opsi_c' => '0,0971',
                'opsi_d' => '0,0991',
                'jawabanBenar' => 'c',
            ],
            // Soal 60
            [
                'textSoal' => 'Ridho harus mengkredit sebuah laptop dengan lima kali cicilan. Jika uang mukanya sebesar Rp.1.500.000,- yang merupakan 30% dari harga laptop, berapa rupiah yang harus dibayarkan Ridho tiap kali cicilan?',
                'opsi_a' => 'Rp. 800.000,-',
                'opsi_b' => 'Rp. 850.000,-',
                'opsi_c' => 'Rp. 700.000,-',
                'opsi_d' => 'Rp. 750.000,-',
                'jawabanBenar' => 'c',
            ],
        ];

        foreach ($soals as $soal) {
            DB::table('soals')->insert([
                'textSoal' => $soal['textSoal'],
                'opsi_a' => $soal['opsi_a'],
                'opsi_b' => $soal['opsi_b'],
                'opsi_c' => $soal['opsi_c'],
                'opsi_d' => $soal['opsi_d'],
                'jawabanBenar' => $soal['jawabanBenar'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}