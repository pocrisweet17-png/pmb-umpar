<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home - Pendaftaran | [Nama Kampus]</title>
  <!-- Tailwind CDN (untuk prototype). Untuk produksi, gunakan build Tailwind. -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js untuk interaktivitas ringan -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    /* Warna utama: biru tua & putih */
    :root {
      --primary: #0b3d91; /* biru tua */
      --primary-600: #0a3690;
      --accent: #ffffff;
    }
    /* overlay gradient for hero */
    .hero-overlay {
      background: linear-gradient(180deg, rgba(11,61,145,0.45) 0%, rgba(11,61,145,0.6) 100%);
    }
  </style>
</head>
<body class="antialiased text-gray-800 bg-white">

  <!-- HEADER -->
  <header class="fixed w-full z-40 bg-white/70 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
      <a href="/" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-md flex items-center justify-center" style="background:var(--primary)">
          <span class="text-white font-bold">KP</span>
        </div>
        <div>
          <h1 class="text-lg font-semibold text-gray-900">[Nama Kampus]</h1>
          <p class="text-xs text-gray-500">Akreditasi A • Siap Kerja</p>
        </div>
      </a>

      <nav class="hidden md:flex items-center gap-6">
        <a href="#program" class="hover:text-sky-700">Program Studi</a>
        <a href="#alur" class="hover:text-sky-700">Alur Pendaftaran</a>
        <a href="#testimoni" class="hover:text-sky-700">Testimoni</a>
        <a href="#berita" class="hover:text-sky-700">Berita</a>
        <a href="/login" class="px-4 py-2 rounded-md border border-slate-200">Masuk</a>
        <a href="/register" class="px-4 py-2 rounded-md bg-[var(--primary)] text-white shadow hover:opacity-95">Daftar</a>
      </nav>

      <!-- Mobile menu button -->
      <div class="md:hidden">
        <button x-data @click="$dispatch('toggle-menu')" class="p-2 rounded-md bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile drawer (Alpine) -->
    <div x-data="{open:false}"
         x-on:toggle-menu.window="open = !open"
         x-show="open"
         x-transition
         class="md:hidden">
      <div class="px-6 pb-6">
        <nav class="flex flex-col gap-3 mt-3">
          <a href="#program" class="py-2">Program Studi</a>
          <a href="#alur" class="py-2">Alur Pendaftaran</a>
          <a href="#testimoni" class="py-2">Testimoni</a>
          <a href="#berita" class="py-2">Berita</a>
          <div class="flex gap-2 mt-2">
            <a href="/login" class="flex-1 text-center py-2 rounded-md border">Masuk</a>
            <a href="/register" class="flex-1 text-center py-2 rounded-md bg-[var(--primary)] text-white">Daftar</a>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <main class="pt-24">

    <!-- HERO -->
    <section class="relative min-h-[70vh] flex items-center">
      <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover brightness-75">
        <!-- Ganti src dengan video mahasiswa atau foto hero (video memberikan efek dinamis) -->
        <source src="/media/hero-campus.mp4" type="video/mp4">
      </video>
      <div class="absolute inset-0 hero-overlay"></div>

      <div class="relative max-w-7xl mx-auto px-6 text-white z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
          <div class="space-y-6">
            <h2 class="text-4xl md:text-5xl font-extrabold leading-tight">Kembangkan Potensimu di <span class="text-amber-200">[Nama Kampus]</span></h2>
            <p class="text-lg md:text-xl opacity-90">Kampus dengan akreditasi A dan jaringan industri terluas. Siapkan masa depan profesionalmu bersama pengajar berpengalaman dan fasilitas modern.</p>
            <div class="flex gap-4 mt-4">
              <a href="{{ route('pendaftaran.form') }}" class="inline-flex items-center gap-3 px-6 py-3 rounded-lg bg-white text-[var(--primary)] font-semibold shadow-lg transform hover:-translate-y-1 transition">
                <!-- CTA besar -->
                DAFTAR SEKARANG
              </a>
              <a href="#info" class="inline-flex items-center gap-3 px-5 py-3 rounded-lg border border-white/60 text-white hover:bg-white/10 transition">INFO LEBIH LANJUT</a>
            </div>

            <!-- quick stats small cards -->
            <div class="mt-6 grid grid-cols-3 sm:grid-cols-3 gap-3 max-w-md">
              <div class="bg-white/10 rounded-lg p-3 text-sm">
                <div class="font-semibold">Akreditasi A</div>
                <div class="text-xs opacity-80">Terakreditasi BAN-PT</div>
              </div>
              <div class="bg-white/10 rounded-lg p-3 text-sm">
                <div class="font-semibold">Beasiswa</div>
                <div class="text-xs opacity-80">Beragam skema</div>
              </div>
              <div class="bg-white/10 rounded-lg p-3 text-sm">
                <div class="font-semibold">Kerja</div>
                <div class="text-xs opacity-80">Jaringan industri luas</div>
              </div>
            </div>

          </div>

          <!-- right column: hero card -->
          <div class="hidden md:block">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
              <img src="/images/hero-students.jpg" alt="Mahasiswa" class="w-full h-72 object-cover" />
              <div class="p-6">
                <h3 class="text-2xl font-semibold text-gray-900">Pendaftaran Gelombang 1 Terbuka</h3>
                <p class="mt-2 text-sm text-gray-600">Daftarkan dirimu sekarang dan dapatkan kesempatan beasiswa serta bimbingan karier.</p>
                <div class="mt-4 flex gap-3">
                  <a href="{{ route('pendaftaran.form') }}" class="px-4 py-2 bg-[var(--primary)] text-white rounded-md">Daftar</a>
                  <a href="/programs" class="px-4 py-2 border rounded-md">Lihat Program</a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- KEUNGGULAN -->
    <section id="info" class="max-w-7xl mx-auto px-6 py-16">
      <div class="text-center mb-10">
        <h4 class="text-2xl font-bold text-[var(--primary)]">Keunggulan Kami</h4>
        <p class="text-gray-600 mt-2">Mengapa memilih kami? Berikut beberapa alasan utama.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="p-6 rounded-xl border hover:shadow-lg transition bg-white">
          <div class="w-14 h-14 rounded-lg flex items-center justify-center bg-[var(--primary)] text-white mb-4">
            <!-- SVG ikon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927C9.469 1.773 10.531 1.773 10.951 2.927l.286.77a1 1 0 00.95.69h.81c1.11 0 1.57 1.42.67 2.11l-.65.51a1 1 0 00-.36 1.11l.24.77c.32 1.03-.78 1.86-1.64 1.28l-.7-.48a1 1 0 00-1.18 0l-.7.48c-.86.58-1.96-.25-1.64-1.28l.24-.77a1 1 0 00-.36-1.11l-.65-.51c-.9-.69-.44-2.11.67-2.11h.81a1 1 0 00.95-.69l.29-.77z"/></svg>
          </div>
          <h5 class="font-semibold">Akreditasi A</h5>
          <p class="text-sm text-gray-600 mt-2">Program studi terakreditasi dan kurikulum terstandar industri.</p>
        </div>

        <!-- Card 2 -->
        <div class="p-6 rounded-xl border hover:shadow-lg transition bg-white">
          <div class="w-14 h-14 rounded-lg flex items-center justify-center bg-[var(--primary)] text-white mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor"><path d="M2 11a1 1 0 011-1h3v7a1 1 0 11-2 0V11zM9 6V3a1 1 0 112 0v3h3a1 1 0 010 2H11v3a1 1 0 11-2 0V8H6a1 1 0 110-2h3z"/></svg>
          </div>
          <h5 class="font-semibold">Beasiswa Lengkap</h5>
          <p class="text-sm text-gray-600 mt-2">Skema beasiswa akademik dan non-akademik yang mendukung mahasiswa berprestasi.</p>
        </div>

        <!-- Card 3 -->
        <div class="p-6 rounded-xl border hover:shadow-lg transition bg-white">
          <div class="w-14 h-14 rounded-lg flex items-center justify-center bg-[var(--primary)] text-white mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor"><path d="M12 2a1 1 0 00-.894.553L9.382 5H5a1 1 0 000 2h3.618l1.724 2.447A1 1 0 0011 11v5a1 1 0 102 0v-5l1.658-2.354A1 1 0 0016 7h3a1 1 0 100-2h-4.382L12.894 2.553A1 1 0 0012 2z"/></svg>
          </div>
          <h5 class="font-semibold">Kampus Hijau & Nyaman</h5>
          <p class="text-sm text-gray-600 mt-2">Fasilitas modern dalam lingkungan yang mendukung kenyamanan belajar.</p>
        </div>

        <!-- Card 4 -->
        <div class="p-6 rounded-xl border hover:shadow-lg transition bg-white">
          <div class="w-14 h-14 rounded-lg flex items-center justify-center bg-[var(--primary)] text-white mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor"><path d="M13 7H7v6h6V7z"/></svg>
          </div>
          <h5 class="font-semibold">Lulusan Siap Kerja</h5>
          <p class="text-sm text-gray-600 mt-2">Program magang dan kerja sama industri membuka jalur karier.
          </p>
        </div>
      </div>
    </section>

    <!-- PROGRAM STUDI POPULER -->
    <section id="program" class="bg-gray-50 py-14">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between mb-8">
          <h4 class="text-2xl font-bold text-[var(--primary)]">Program Studi Populer</h4>
          <a href="/programs" class="text-sm underline">Lihat Semua Program Studi</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

          <!-- Card TI -->
          <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="/images/program-ti.jpg" alt="Teknologi Informasi" class="h-40 w-full object-cover">
            <div class="p-6">
              <h5 class="font-semibold text-lg">Teknologi Informasi</h5>
              <p class="text-sm text-gray-600 mt-2">Kurikulum terkini, laboratorium lengkap, dan dosen berpengalaman di industri.</p>
              <div class="mt-4 flex justify-between items-center">
                <a href="/programs/ti" class="text-[var(--primary)] font-semibold">LIHAT DETAIL</a>
                <a href="/register?program=ti" class="px-3 py-2 rounded-md bg-[var(--primary)] text-white">DAFTAR</a>
              </div>
            </div>
          </div>

          <!-- Card Bisnis -->
          <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="/images/program-bisnis.jpg" alt="Bisnis & Manajemen" class="h-40 w-full object-cover">
            <div class="p-6">
              <h5 class="font-semibold text-lg">Bisnis & Manajemen</h5>
              <p class="text-sm text-gray-600 mt-2">Fokus pada kewirausahaan, manajemen, dan keterampilan bisnis modern.</p>
              <div class="mt-4 flex justify-between items-center">
                <a href="/programs/bisnis" class="text-[var(--primary)] font-semibold">LIHAT DETAIL</a>
                <a href="/register?program=bisnis" class="px-3 py-2 rounded-md bg-[var(--primary)] text-white">DAFTAR</a>
              </div>
            </div>
          </div>

          <!-- Card DKV -->
          <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="/images/program-dkv.jpg" alt="Desain Komunikasi Visual" class="h-40 w-full object-cover">
            <div class="p-6">
              <h5 class="font-semibold text-lg">Desain Komunikasi Visual</h5>
              <p class="text-sm text-gray-600 mt-2">Ruang kreatif, studio desain, dan dosen praktisi di bidang desain.</p>
              <div class="mt-4 flex justify-between items-center">
                <a href="/programs/dkv" class="text-[var(--primary)] font-semibold">LIHAT DETAIL</a>
                <a href="/register?program=dkv" class="px-3 py-2 rounded-md bg-[var(--primary)] text-white">DAFTAR</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ALUR PENDAFTARAN (TIMELINE HORIZONTAL) -->
    <section id="alur" class="max-w-7xl mx-auto px-6 py-16">
      <div class="text-center mb-8">
        <h4 class="text-2xl font-bold text-[var(--primary)]">Alur Pendaftaran</h4>
        <p class="text-gray-600 mt-2">Langkah mudah untuk bergabung bersama kami.</p>
      </div>

      <div class="relative">
        <div class="overflow-x-auto">
          <div class="min-w-[900px] flex gap-6 items-start px-4">
            <!-- Step 1 -->
            <div class="flex-1 min-w-[160px] flex flex-col items-center text-center">
              <div class="w-14 h-14 rounded-full flex items-center justify-center bg-[var(--primary)] text-white font-semibold">1</div>
              <div class="mt-3 font-semibold">Buat Akun</div>
              <div class="text-sm text-gray-500 mt-2">Daftar dengan email atau akun sosial.</div>
            </div>

            <!-- connector -->
            <div class="w-24 flex items-center justify-center">
              <div class="h-0.5 w-full bg-gray-200"></div>
            </div>

            <!-- Step 2 -->
            <div class="flex-1 min-w-[160px] flex flex-col items-center text-center">
              <div class="w-14 h-14 rounded-full flex items-center justify-center bg-[var(--primary)] text-white font-semibold">2</div>
              <div class="mt-3 font-semibold">Isi Formulir</div>
              <div class="text-sm text-gray-500 mt-2">Lengkapi data akademik dan pribadi.</div>
            </div>

            <div class="w-24 flex items-center justify-center">
              <div class="h-0.5 w-full bg-gray-200"></div>
            </div>

            <!-- Step 3 -->
            <div class="flex-1 min-w-[160px] flex flex-col items-center text-center">
              <div class="w-14 h-14 rounded-full flex items-center justify-center bg-[var(--primary)] text-white font-semibold">3</div>
              <div class="mt-3 font-semibold">Unggah Dokumen</div>
              <div class="text-sm text-gray-500 mt-2">Ijazah, transkrip, pas foto, dsb.</div>
            </div>

            <div class="w-24 flex items-center justify-center">
              <div class="h-0.5 w-full bg-gray-200"></div>
            </div>

            <!-- Step 4 -->
            <div class="flex-1 min-w-[160px] flex flex-col items-center text-center">
              <div class="w-14 h-14 rounded-full flex items-center justify-center bg-[var(--primary)] text-white font-semibold">4</div>
              <div class="mt-3 font-semibold">Pembayaran</div>
              <div class="text-sm text-gray-500 mt-2">Bayar biaya pendaftaran melalui metode yang tersedia.</div>
            </div>

            <div class="w-24 flex items-center justify-center">
              <div class="h-0.5 w-full bg-gray-200"></div>
            </div>

            <!-- Step 5 -->
            <div class="flex-1 min-w-[160px] flex flex-col items-center text-center">
              <div class="w-14 h-14 rounded-full flex items-center justify-center bg-[var(--primary)] text-white font-semibold">5</div>
              <div class="mt-3 font-semibold">Pengumuman</div>
              <div class="text-sm text-gray-500 mt-2">Cek hasil seleksi melalui akunmu.</div>
            </div>

          </div>
        </div>

        <div class="mt-6 text-center">
          <a href="/register" class="px-6 py-3 rounded-lg bg-[var(--primary)] text-white font-semibold">Mulai Daftar Sekarang</a>
        </div>
      </div>
    </section>

    <!-- TESTIMONI -->
    <section id="testimoni" class="bg-white py-14">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-8">
          <h4 class="text-2xl font-bold text-[var(--primary)]">Testimoni</h4>
          <p class="text-gray-600 mt-2">Suara alumni dan mahasiswa kami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- testimonial card -->
          <div class="p-6 border rounded-xl shadow-sm">
            <div class="flex items-center gap-4">
              <img src="/images/alumni1.jpg" alt="Alumni" class="w-12 h-12 rounded-full object-cover">
              <div>
                <div class="font-semibold">Aulia Rahma</div>
                <div class="text-sm text-gray-500">Lulusan TI 2022</div>
              </div>
            </div>
            <p class="mt-4 text-gray-600">"Fasilitas lengkap dan dosen yang peduli membuat saya siap menghadapi dunia kerja."</p>
          </div>

          <div class="p-6 border rounded-xl shadow-sm">
            <div class="flex items-center gap-4">
              <img src="/images/alumni2.jpg" alt="Alumni" class="w-12 h-12 rounded-full object-cover">
              <div>
                <div class="font-semibold">Budi Santoso</div>
                <div class="text-sm text-gray-500">Lulusan Bisnis 2021</div>
              </div>
            </div>
            <p class="mt-4 text-gray-600">"Program magang membuka kesempatan kerja yang luas bagi saya."</p>
          </div>

          <div class="p-6 border rounded-xl shadow-sm">
            <div class="flex items-center gap-4">
              <img src="/images/alumni3.jpg" alt="Alumni" class="w-12 h-12 rounded-full object-cover">
              <div>
                <div class="font-semibold">Citra Dewi</div>
                <div class="text-sm text-gray-500">Lulusan DKV 2020</div>
              </div>
            </div>
            <p class="mt-4 text-gray-600">"Lingkungan kampus yang mendukung kreativitas membuat saya berkembang pesat."</p>
          </div>
        </div>
      </div>
    </section>

    <!-- BERITA KAMPUS TERBARU -->
    <section id="berita" class="max-w-7xl mx-auto px-6 py-14">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h4 class="text-2xl font-bold text-[var(--primary)]">Berita Kampus Terbaru</h4>
          <p class="text-gray-600 mt-1">Ikuti berita dan kegiatan terbaru kampus.</p>
        </div>
        <a href="/news" class="text-sm underline">Lihat Semua Berita</a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Berita 1 -->
        <article class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
          <img src="/images/news1.jpg" alt="Berita 1" class="h-44 w-full object-cover">
          <div class="p-5">
            <h5 class="font-semibold">Workshop Kewirausahaan Mahasiswa</h5>
            <p class="text-sm text-gray-500 mt-2">Mahasiswa belajar strategi bisnis modern dari praktisi industri.</p>
            <div class="mt-4 flex justify-between items-center">
              <a href="/news/1" class="text-[var(--primary)]">Baca</a>
              <span class="text-xs text-gray-400">12 Nov 2025</span>
            </div>
          </div>
        </article>

        <!-- Berita 2 -->
        <article class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
          <img src="/images/news2.jpg" alt="Berita 2" class="h-44 w-full object-cover">
          <div class="p-5">
            <h5 class="font-semibold">Penandatanganan MoU dengan Perusahaan Teknologi</h5>
            <p class="text-sm text-gray-500 mt-2">Penguatan kerja sama riset dan magang mahasiswa.</p>
            <div class="mt-4 flex justify-between items-center">
              <a href="/news/2" class="text-[var(--primary)]">Baca</a>
              <span class="text-xs text-gray-400">2 Okt 2025</span>
            </div>
          </div>
        </article>

        <!-- Berita 3 -->
        <article class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
          <img src="/images/news3.jpg" alt="Berita 3" class="h-44 w-full object-cover">
          <div class="p-5">
            <h5 class="font-semibold">Pameran Karya Mahasiswa DKV</h5>
            <p class="text-sm text-gray-500 mt-2">Menampilkan karya terbaik dari mahasiswa desain komunikasi visual.</p>
            <div class="mt-4 flex justify-between items-center">
              <a href="/news/3" class="text-[var(--primary)]">Baca</a>
              <span class="text-xs text-gray-400">25 Sep 2025</span>
            </div>
          </div>
        </article>
      </div>
    </section>

  </main>

  <!-- FOOTER -->
  <footer class="bg-[var(--primary)] text-white mt-12">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-6">
      <div>
        <h6 class="font-bold text-lg">[Nama Kampus]</h6>
        <p class="text-sm mt-2">Alamat kampus, kota, provinsi.</p>
        <p class="text-sm mt-2">Tel: (021) xxxx xxxx</p>
        <p class="text-sm">Email: info@kampus.ac.id</p>
      </div>

      <div>
        <h6 class="font-semibold">Link Cepat</h6>
        <ul class="mt-3 text-sm space-y-2">
          <li><a href="/register" class="opacity-90">Daftar</a></li>
          <li><a href="/programs" class="opacity-90">Program Studi</a></li>
          <li><a href="/news" class="opacity-90">Berita</a></li>
        </ul>
      </div>

      <div>
        <h6 class="font-semibold">Ikuti Kami</h6>
        <div class="mt-3 flex gap-3">
          <a href="#" class="p-2 rounded-md bg-white/10">FB</a>
          <a href="#" class="p-2 rounded-md bg-white/10">IG</a>
          <a href="#" class="p-2 rounded-md bg-white/10">TW</a>
        </div>
      </div>

      <div>
        <h6 class="font-semibold">Alamat</h6>
        <p class="text-sm mt-3">Jalan Merdeka No. 1, Kota Contoh, Kode Pos 12345</p>
      </div>
    </div>

    <div class="border-t border-white/20 py-4">
      <div class="max-w-7xl mx-auto px-6 text-sm text-white/80">© <span x-text="new Date().getFullYear()">2025</span> [Nama Kampus]. All rights reserved.</div>
    </div>
  </footer>

  <!-- Simple entrance animation using IntersectionObserver + CSS classes (progressive enhancement) -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) entry.target.classList.add('translate-y-0','opacity-100');
        });
      }, { threshold: 0.12 });

      document.querySelectorAll('.reveal').forEach(el => {
        el.classList.add('opacity-0','translate-y-6','transition','duration-700');
        observer.observe(el);
      });
    });
  </script>

</body>
</html>
