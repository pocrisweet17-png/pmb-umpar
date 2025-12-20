<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home - Pendaftaran | UMPAR</title>
  @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- ganti dengan vite jika pakai --}}
  {{-- Atau langsung CDN Tailwind jika belum setup Vite --}}
  {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #0f3460;
      --primary-dark: #0c2340;
      --primary-light: #4da8da;
      --primary-lighter: #aed6f1;
      --white: #ffffff;
      --gray-100: #f9fafb;
      --gray-200: #e5e7eb;
      --gray-600: #4b5563;
      --gray-800: #1f2937;
    }
    body {
      font-family: 'Inter', system-ui, sans-serif;
    }
    .btn-primary {
      @apply bg-[#0f3460] text-white font-medium py-2.5 px-6 rounded-lg shadow-sm transition-all hover:bg-[#0c2340] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#4da8da] focus:ring-offset-2;
    }
    .btn-outline {
      @apply border border-[#0f3460] text-[#0f3460] font-medium py-2.5 px-6 rounded-lg transition-all hover:bg-[#0f3460] hover:text-white;
    }
    .card {
      @apply bg-white border border-gray-200 rounded-xl shadow-sm p-6 transition-all hover:shadow-md;
    }
    .section-title {
      @apply text-3xl md:text-4xl font-bold text-[#0c2340] mb-4;
    }
    .section-subtitle {
      @apply text-gray-600 max-w-2xl mb-10;
    }
  </style>
</head>
<body class="antialiased text-gray-800 bg-white">

  <!-- HEADER -->
  <header class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-[#0f3460] flex items-center justify-center">
            <span class="text-white font-bold text-sm">UM</span>
          </div>
          <div>
            <h1 class="text-lg font-bold text-[#0c2340]">UMPAR</h1>
            <p class="text-xs text-gray-500">Universitas Muhammadiyah Parepare</p>
          </div>
        </div>
        <nav class="hidden md:flex items-center gap-6">
          <a href="#program" class="font-medium text-gray-700 hover:text-[#0f3460]">Program Studi</a>
          <a href="#alur" class="font-medium text-gray-700 hover:text-[#0f3460]">Alur Pendaftaran</a>
          <a href="#testimoni" class="font-medium text-gray-700 hover:text-[#0f3460]">Testimoni</a>
          <a href="#berita" class="font-medium text-gray-700 hover:text-[#0f3460]">Berita</a>
        </nav>
        <div class="flex items-center gap-3">
          <a href="{{ route('login') }}" class="text-[#0f3460] font-medium hidden sm:block">Masuk</a>
          <a href="{{ route('register.form') }}" class="btn-primary">Daftar Sekarang</a>
        </div>
      </div>
    </div>
  </header>

  <main>
    <!-- HERO -->
    <section class="py-20 md:py-32 bg-gradient-to-br from-[#0f3460] to-[#0c2340] text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div>
            <span class="inline-block px-3 py-1 bg-white/10 text-white text-sm font-medium rounded-full mb-4">Pendaftaran Gelombang 1 Dibuka</span>
            <h1 class="text-4xl md:text-5xl font-bold max-w-2xl leading-tight mb-6">
              Wujudkan Masa Depanmu <br> Bersama <span class="text-[#4da8da]">UMPAR</span>
            </h1>
            <p class="text-white/90 text-lg mb-8 max-w-xl">
              Kampus berakreditasi unggul dengan nilai-nilai Islami dan kemitraan industri terluas di Sulawesi Selatan.
            </p>
            <div class="flex flex-wrap gap-4">
              <a href="{{ route('register.form') }}" class="btn-primary">Daftar Sekarang</a>
              <a href="#info" class="btn-outline text-white border-white/30 hover:bg-white hover:text-[#0f3460]">Info Lengkap</a>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-1">
              <img src="{{ asset('img/UMPAR-3.jpg') }}" alt="Kampus UMPAR" class="w-full rounded-xl object-cover aspect-[4/3]">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- KEUNGGULAN -->
    <section id="info" class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <span class="inline-block px-3 py-1 bg-[#0f3460]/10 text-[#0f3460] text-sm font-medium rounded-full mb-4">Mengapa Memilih Kami</span>
          <h2 class="section-title">Keunggulan UMPAR</h2>
          <p class="section-subtitle">Kami menggabungkan akademik unggul, nilai Islami, dan kesiapan kerja.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          @foreach([
            ['title' => 'Akreditasi Unggul', 'desc' => 'Program studi terakreditasi BAN-PT dengan kurikulum berbasis industri.'],
            ['title' => 'Beasiswa Lengkap', 'desc' => 'Skema beasiswa untuk prestasi akademik dan keterbatasan ekonomi.'],
            ['title' => 'Nilai Islami', 'desc' => 'Pendidikan berbasis nilai Islam moderat ala Muhammadiyah.'],
            ['title' => 'Siap Kerja', 'desc' => 'Magang, pelatihan soft skill, dan jejaring alumni nasional.']
          ] as $item)
            <div class="card">
              <div class="w-12 h-12 rounded-lg bg-[#0f3460]/10 flex items-center justify-center mb-4">
                <div class="w-6 h-6 bg-[#0f3460] rounded-sm"></div>
              </div>
              <h3 class="font-bold text-lg text-[#0c2340] mb-2">{{ $item['title'] }}</h3>
              <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- PROGRAM STUDI -->
    <section id="program" class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start mb-12">
          <div>
            <span class="inline-block px-3 py-1 bg-[#0f3460]/10 text-[#0f3460] text-sm font-medium rounded-full mb-4">Program Unggulan</span>
            <h2 class="section-title">Program Studi Populer</h2>
          </div>
          <a href="/programs" class="text-[#0f3460] font-medium hover:underline mt-2">Lihat Semua Program →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          @foreach([
            ['name' => 'Teknik Informatika', 'img' => 'teknik-informatika.jpg', 'route' => 'ti'],
            ['name' => 'Bisnis & Manajemen', 'img' => 'manajemen-bisnis.jpg', 'route' => 'bisnis'],
            ['name' => 'Pendidikan & Keguruan', 'img' => 'pendidikan.jpg', 'route' => 'dkv']
          ] as $prog)
            <div class="card">
              <div class="aspect-[4/3] rounded-lg overflow-hidden mb-4">
                <img src="{{ asset('img/' . $prog['img']) }}" alt="{{ $prog['name'] }}" class="w-full h-full object-cover">
              </div>
              <h3 class="font-bold text-lg text-[#0c2340] mb-2">{{ $prog['name'] }}</h3>
              <p class="text-gray-600 text-sm mb-4">Kurikulum terkini, dosen kompeten, dan fasilitas lengkap.</p>
              <div class="flex gap-3">
                <a href="/programs/{{ $prog['route'] }}" class="btn-outline flex-1 text-center">Detail</a>
                <a href="/register?program={{ $prog['route'] }}" class="btn-primary flex-1 text-center">Daftar</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- ALUR PENDAFTARAN -->
    <section id="alur" class="py-20 bg-white">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <span class="inline-block px-3 py-1 bg-[#0f3460]/10 text-[#0f3460] text-sm font-medium rounded-full mb-4">Alur Pendaftaran</span>
          <h2 class="section-title">Langkah Mudah Bergabung</h2>
          <p class="section-subtitle">Proses online cepat, transparan, dan mudah diikuti.</p>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-start gap-8 relative">
          @foreach([1 => 'Buat Akun', 2 => 'Isi Formulir', 3 => 'Unggah Dokumen', 4 => 'Pembayaran', 5 => 'Pengumuman'] as $step => $label)
            <div class="text-center flex flex-col items-center">
              <div class="w-12 h-12 rounded-full bg-[#0f3460] text-white flex items-center justify-center font-bold mb-3">{{ $step == 5 ? '✓' : $step }}</div>
              <h4 class="font-semibold text-gray-800">{{ $label }}</h4>
            </div>
            @if($step < 5)
              <div class="hidden md:block w-16 h-px bg-gray-200"></div>
            @endif
          @endforeach
        </div>
        <div class="text-center mt-12">
          <a href="{{ route('register.form') }}" class="btn-primary inline-flex items-center gap-2">
            Mulai Pendaftaran
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </a>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#0c2340] text-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
          <div>
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 rounded-lg bg-[#0f3460] flex items-center justify-center">
                <span class="text-white font-bold">UM</span>
              </div>
              <h4 class="font-bold">UMPAR</h4>
            </div>
            <p class="text-gray-400 text-sm">
              Universitas Muhammadiyah Parepare: mencetak pemimpin berintegritas dan berdaya saing global.
            </p>
          </div>
          <div>
            <h5 class="font-semibold mb-4 text-[#4da8da]">Link Cepat</h5>
            <ul class="space-y-2 text-gray-400">
              <li><a href="{{ route('register.form') }}" class="hover:text-white">Pendaftaran</a></li>
              <li><a href="/programs" class="hover:text-white">Program Studi</a></li>
              <li><a href="/news" class="hover:text-white">Berita</a></li>
            </ul>
          </div>
          <div>
            <h5 class="font-semibold mb-4 text-[#4da8da]">Kontak</h5>
            <address class="text-gray-400 not-italic text-sm space-y-2">
              <p>Jl. Jenderal Ahmad Yani KM 6,<br>Parepare, Sulawesi Selatan</p>
              <p>Telp: (0421) 2912 2xxx</p>
              <p>Email: info@umpar.ac.id</p>
            </address>
          </div>
          <div>
            <h5 class="font-semibold mb-4 text-[#4da8da]">Newsletter</h5>
            <p class="text-gray-400 text-sm mb-3">Dapatkan update terbaru seputar kampus.</p>
            <form class="flex gap-2">
              <input type="email" placeholder="Email Anda" class="flex-1 px-3 py-2 rounded text-gray-800 text-sm focus:outline-none focus:ring-1 focus:ring-[#4da8da]">
              <button type="submit" class="bg-[#0f3460] text-white px-3 py-2 rounded hover:bg-[#0c2340]">Kirim</button>
            </form>
          </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-6 text-center text-gray-500 text-sm">
          &copy; {{ date('Y') }} Universitas Muhammadiyah Parepare. All rights reserved.
        </div>
      </div>
    </footer>
  </main>

</body>
</html>