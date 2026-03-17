<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $newsItem['title'] }} | UMPAR</title>
  <meta name="description" content="{{ Str::limit(strip_tags($newsItem['desc']), 160) }}">
  @if($newsItem['image'])
  <meta property="og:image" content="{{ Storage::url($newsItem['image']) }}">
  @endif
  <meta property="og:title"       content="{{ $newsItem['title'] }}">
  <meta property="og:description" content="{{ Str::limit(strip_tags($newsItem['desc']), 160) }}">
  <meta property="og:type"        content="article">

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600;1,700&display=swap" rel="stylesheet">

  <style>
    :root {
      --blue-dark:  #0a1628;
      --blue-900:   #0c2340;
      --blue-800:   #0f3460;
      --blue-light: #4da8da;
      --green:      #00a651;
      --green-dark: #008c44;
      --gold:       #f4d03f;
    }
    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .font-display { font-family: 'Playfair Display', serif; }
    html { scroll-behavior: smooth; }

    /* Gradient hero */
    .hero-gradient {
      background: linear-gradient(160deg,
        rgba(10,22,40,0.96) 0%,
        rgba(15,52,96,0.88) 45%,
        rgba(0,166,81,0.65) 100%);
    }
    .text-gradient-static {
      background: linear-gradient(135deg, var(--blue-light), var(--green));
      -webkit-background-clip: text; background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Progress bar */
    #progress-bar {
      position: fixed; top: 0; left: 0; height: 3px; z-index: 9999;
      background: linear-gradient(90deg, var(--green), var(--blue-light), var(--gold));
      width: 0%; transition: width 0.1s linear;
    }

    /* ── Article typography ── */
    .article-body { color: #374151; line-height: 1.95; font-size: 1.0625rem; }

    /* Setiap paragraf mendapat spasi bawah */
    .article-body p {
      margin-bottom: 1.6rem;
    }

    /* Paragraf pertama — drop cap ringan */
    .article-body p:first-child::first-letter {
      float: left;
      font-family: 'Playfair Display', serif;
      font-size: 3.8rem;
      font-weight: 700;
      line-height: 0.8;
      margin-right: 0.12em;
      margin-top: 0.05em;
      color: var(--green);
    }

    /* Blockquote otomatis jika ada baris mulai dengan "> " */
    .article-body blockquote {
      border-left: 4px solid var(--green);
      background: #f0fdf4;
      padding: 1rem 1.25rem;
      border-radius: 0 0.75rem 0.75rem 0;
      margin: 1.5rem 0;
      font-style: italic;
      color: #166534;
    }

    /* Heading di dalam konten */
    .article-body h2 { font-size: 1.5rem; font-weight: 700; color: var(--blue-900); margin: 2rem 0 0.75rem; }
    .article-body h3 { font-size: 1.2rem; font-weight: 600; color: var(--blue-900); margin: 1.5rem 0 0.5rem; }

    /* Bold & italic */
    .article-body strong { color: var(--blue-900); font-weight: 700; }
    .article-body em     { color: #4b5563; font-style: italic; }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(var(--green), var(--blue-light)); border-radius: 4px; }

    /* Reveal animations */
    .reveal { opacity:0; transform:translateY(30px); transition:all .7s cubic-bezier(.4,0,.2,1); }
    .reveal.active { opacity:1; transform:translateY(0); }
    .delay-1 { transition-delay:.1s; } .delay-2 { transition-delay:.2s; }
    .delay-3 { transition-delay:.3s; } .delay-4 { transition-delay:.4s; }

    /* Card hover */
    .card-hover { transition: all .4s cubic-bezier(.4,0,.2,1); }
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(10,22,40,.15); }

    /* Sidebar card */
    .sidebar-card {
      display:flex; gap:.875rem; padding:.875rem;
      border-radius:1rem; background:white;
      border:1px solid #e5e7eb;
      transition: all .3s ease;
      text-decoration:none;
    }
    .sidebar-card:hover { background:#f0fdf4; border-color:var(--green); transform:translateX(4px); }

    /* Back to top */
    #back-to-top {
      position:fixed; bottom:2rem; right:2rem; z-index:50;
      width:3rem; height:3rem; border-radius:50%;
      background:linear-gradient(135deg,var(--green),var(--blue-800));
      color:white; display:flex; align-items:center; justify-content:center;
      box-shadow:0 8px 24px rgba(0,166,81,.4);
      opacity:0; pointer-events:none; transition:all .3s ease; cursor:pointer;
    }
    #back-to-top.visible { opacity:1; pointer-events:auto; }
    #back-to-top:hover { transform:translateY(-4px); }

    /* Wave svg */
    .wave-divider { position:absolute; bottom:0; left:0; right:0; overflow:hidden; line-height:0; }

    /* Image zoom */
    .img-zoom { overflow:hidden; }
    .img-zoom img { transition:transform .6s cubic-bezier(.4,0,.2,1); }
    .img-zoom:hover img { transform:scale(1.05); }

    /* Print */
    @media print {
      header, #back-to-top, #progress-bar, aside, .no-print { display:none !important; }
      .article-body { font-size:12pt; line-height:1.6; }
    }
  </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 overflow-x-hidden">

<div id="progress-bar"></div>

{{-- ── HEADER ───────────────────────────────────────────────── --}}
<header class="fixed w-full z-50 transition-all duration-500"
        x-data="{ scrolled: false, mobileOpen: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
        :class="scrolled ? 'bg-white/95 backdrop-blur-lg shadow-lg' : 'bg-transparent'">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20">
      <a href="/" class="flex items-center gap-3 group">
        <div class="w-11 h-11 rounded-xl overflow-hidden bg-white flex items-center justify-center shadow-md
                    group-hover:scale-105 transition-transform">
          <img src="{{ asset('img/umpar.png') }}" alt="UMPAR" class="max-w-full max-h-full object-contain p-1">
        </div>
        <div>
          <div class="font-bold text-lg leading-tight transition-colors"
               :class="scrolled ? 'text-[#0c2340]' : 'text-white'">UMPAR</div>
          <div class="text-xs transition-colors"
               :class="scrolled ? 'text-gray-500' : 'text-white/70'">Universitas Muhammadiyah Parepare</div>
        </div>
      </a>

      <nav class="hidden lg:flex items-center gap-6">
        <a href="/#program" class="font-medium transition-colors"
           :class="scrolled ? 'text-gray-600 hover:text-[#00a651]' : 'text-white/80 hover:text-white'">
          Program Studi
        </a>
        <a href="/#berita" class="font-medium text-[#00a651]">Berita</a>
        <a href="{{ route('register.form') }}"
           class="px-5 py-2.5 rounded-xl font-semibold text-white shadow-md
                  bg-gradient-to-r from-[#00a651] to-[#008c44]
                  hover:shadow-lg hover:-translate-y-0.5 transition-all">
          Daftar Sekarang
        </a>
      </nav>

      <button @click="mobileOpen = !mobileOpen"
              class="lg:hidden p-2 rounded-xl transition-all"
              :class="scrolled ? 'bg-gray-100 text-gray-700' : 'bg-white/10 text-white'">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
  </div>
  <div x-show="mobileOpen" x-cloak
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 -translate-y-2"
       x-transition:enter-end="opacity-100 translate-y-0"
       class="lg:hidden bg-white border-t shadow-lg">
    <div class="px-6 py-4 space-y-2">
      <a href="/#program" class="block py-2 px-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-[#00a651] font-medium">Program Studi</a>
      <a href="/#berita"  class="block py-2 px-3 rounded-lg text-[#00a651] font-semibold">Berita</a>
      <div class="pt-3">
        <a href="{{ route('register.form') }}"
           class="block text-center py-3 rounded-xl bg-gradient-to-r from-[#00a651] to-[#008c44] text-white font-semibold">
          Daftar Sekarang
        </a>
      </div>
    </div>
  </div>
</header>

<main>

  {{-- ── HERO COVER ───────────────────────────────────────────── --}}
  <section class="relative min-h-[58vh] flex items-end overflow-hidden">
    @if($newsItem['image'])
    <div class="absolute inset-0">
      <img src="{{ Storage::url($newsItem['image']) }}" alt="{{ $newsItem['title'] }}"
           class="w-full h-full object-cover">
      <div class="absolute inset-0 hero-gradient"></div>
    </div>
    @else
    <div class="absolute inset-0 bg-gradient-to-br from-[#0a1628] via-[#0f3460] to-[#00a651]">
      <div class="absolute inset-0 opacity-10"
           style="background-image:radial-gradient(circle at 2px 2px,white 1px,transparent 0);
                  background-size:40px 40px;"></div>
    </div>
    @endif

    {{-- Orbs dekorasi --}}
    <div class="absolute top-16 left-16 w-56 h-56 rounded-full bg-[#00a651]/20 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-8 right-16 w-72 h-72 rounded-full bg-[#4da8da]/20 blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-14 pt-36 z-10">

      {{-- Breadcrumb --}}
      <nav class="flex items-center gap-2 text-sm text-white/60 mb-5 flex-wrap">
        <a href="/" class="hover:text-white transition-colors">Beranda</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="/#berita" class="hover:text-white transition-colors">Berita</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-white/40 truncate max-w-xs">{{ Str::limit($newsItem['title'], 40) }}</span>
      </nav>

      {{-- Badge kategori --}}
      @if($newsItem['category'])
      <span class="inline-block px-4 py-1.5 rounded-full text-sm font-semibold mb-4
                   bg-[#00a651] text-white shadow-lg shadow-[#00a651]/40">
        {{ $newsItem['category'] }}
      </span>
      @endif

      {{-- Judul --}}
      <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-5 max-w-3xl">
        {{ $newsItem['title'] }}
      </h1>

      {{-- Meta --}}
      @php
          // Hitung estimasi baca dari konten lengkap jika ada, fallback ke desc
          $readSource = !empty($newsItem['content']) ? $newsItem['content'] : $newsItem['desc'];
          $wordCount  = str_word_count(strip_tags($readSource ?? ''));
          $readMins   = max(1, (int)ceil($wordCount / 200));
      @endphp
      <div class="flex flex-wrap items-center gap-4 text-white/70 text-sm">
        @if($newsItem['date'])
        <span class="flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          {{ $newsItem['date'] }}
        </span>
        @endif
        <span class="flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          Humas UMPAR
        </span>
        <span class="flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          {{ $readMins }} menit baca
        </span>
      </div>
    </div>

    {{-- Wave --}}
    <div class="wave-divider">
      <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
           class="w-full h-12 block">
        <path fill="#f9fafb" d="M0,40 C360,0 1080,80 1440,40 L1440,60 L0,60 Z"/>
      </svg>
    </div>
  </section>

  {{-- ── CONTENT + SIDEBAR ────────────────────────────────────── --}}
  <section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col lg:flex-row gap-10">

        {{-- ── ARTICLE ── --}}
        <article class="flex-1 min-w-0">
          <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Gambar besar --}}
            @if($newsItem['image'])
            <div class="img-zoom w-full h-72 sm:h-96">
              <img src="{{ Storage::url($newsItem['image']) }}" alt="{{ $newsItem['title'] }}"
                   class="w-full h-full object-cover">
            </div>
            @endif

            <div class="p-6 sm:p-10">

              {{-- Info bar + share --}}
              <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-6 border-b border-gray-100">
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                  @if($newsItem['category'])
                  <span class="px-3 py-1 rounded-full font-semibold text-[#00a651] bg-[#00a651]/10 border border-[#00a651]/20">
                    {{ $newsItem['category'] }}
                  </span>
                  @endif
                  @if($newsItem['date'])
                  <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $newsItem['date'] }}
                  </span>
                  @endif
                </div>

                {{-- Share --}}
                <div class="flex items-center gap-2 no-print flex-wrap">
                  <span class="text-xs text-gray-400 font-medium">Bagikan:</span>
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                     target="_blank" rel="noopener"
                     class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                            bg-[#1877f2] text-white hover:bg-[#166fe5] transition-colors hover:-translate-y-0.5 transform">
                    Facebook
                  </a>
                  <a href="https://wa.me/?text={{ urlencode($newsItem['title'] . ' — ' . request()->url()) }}"
                     target="_blank" rel="noopener"
                     class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                            bg-[#25d366] text-white hover:bg-[#20ba5a] transition-colors hover:-translate-y-0.5 transform">
                    WhatsApp
                  </a>
                  <button onclick="
                    navigator.clipboard.writeText(window.location.href).then(() => {
                      this.textContent='✓ Disalin!';
                      setTimeout(() => { this.textContent='Salin Link'; }, 2000);
                    })"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                           bg-gray-100 text-gray-700 border border-gray-200
                           hover:bg-gray-200 transition-colors hover:-translate-y-0.5 transform">
                    Salin Link
                  </button>
                </div>
              </div>

              {{-- ══════════════════════════════════════════════
                   KONTEN ARTIKEL
                   Priority: news_content (lengkap) → news_desc (fallback)
                   ══════════════════════════════════════════════ --}}
              @php
                  // Gunakan konten lengkap jika ada, otherwise fallback ke desc
                  $displayContent = !empty($newsItem['content'])
                      ? $newsItem['content']
                      : $newsItem['desc'];

                  // Pisahkan berdasarkan baris kosong → jadikan paragraf
                  $rawParagraphs = preg_split('/\n\s*\n/', trim($displayContent ?? ''));
                  $paragraphs    = array_filter(array_map('trim', $rawParagraphs));
              @endphp

              <div class="article-body reveal">
                @foreach($paragraphs as $para)
                  {{-- Deteksi heading: baris yang hanya berisi HURUF KAPITAL SEMUA dianggap sub-judul --}}
                  @if(preg_match('/^[A-Z\s\-–:]{6,}$/', trim($para)))
                    <h2>{{ $para }}</h2>
                  @elseif(Str::startsWith(trim($para), ['# ']))
                    <h2>{{ ltrim($para, '# ') }}</h2>
                  @elseif(Str::startsWith(trim($para), ['## ']))
                    <h3>{{ ltrim($para, '## ') }}</h3>
                  @elseif(Str::startsWith(trim($para), ['> ']))
                    <blockquote>{{ ltrim($para, '> ') }}</blockquote>
                  @else
                    <p>{{ $para }}</p>
                  @endif
                @endforeach

                {{-- Jika tidak ada konten sama sekali --}}
                @if(empty($paragraphs))
                  <p class="text-gray-400 italic">Konten artikel belum tersedia.</p>
                @endif
              </div>

              {{-- Separator --}}
              <div class="flex items-center gap-3 my-8">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
                <svg class="w-5 h-5 text-[#00a651]" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2L9.1 9.1 2 12l7.1 2.9L12 22l2.9-7.1L22 12l-7.1-2.9z"/>
                </svg>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
              </div>

              {{-- Action bar bawah --}}
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 no-print">
                <a href="/#berita"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                          border-2 border-[#0c2340] text-[#0c2340]
                          hover:bg-[#0c2340] hover:text-white transition-all font-semibold text-sm">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                  </svg>
                  Kembali ke Berita
                </a>
                <button onclick="window.print()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                               bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all font-semibold text-sm">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0
                             002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                  </svg>
                  Cetak
                </button>
              </div>

            </div>
          </div>
        </article>

        {{-- ── SIDEBAR ── --}}
        <aside class="w-full lg:w-80 flex-shrink-0 space-y-6 no-print">

          {{-- Card daftar UMPAR --}}
          <div class="reveal bg-gradient-to-br from-[#0c2340] to-[#0f3460] rounded-3xl p-6 text-white shadow-xl">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('img/umpar.png') }}" alt="UMPAR" class="w-8 h-8 object-contain">
              </div>
              <div>
                <p class="font-bold text-sm">UMPAR</p>
                <p class="text-xs text-white/60">Univ. Muhammadiyah Parepare</p>
              </div>
            </div>
            <p class="text-sm text-white/75 leading-relaxed mb-5">
              Bergabunglah dengan ribuan mahasiswa berprestasi di kampus Muhammadiyah terbaik di Sulawesi Selatan.
            </p>
            <a href="{{ route('register.form') }}"
               class="block text-center py-2.5 rounded-xl font-semibold text-sm
                      bg-gradient-to-r from-[#00a651] to-[#008c44]
                      hover:shadow-lg hover:-translate-y-0.5 transition-all">
              Daftar Sekarang →
            </a>
          </div>

          {{-- Berita Lainnya --}}
          @if(count($newsList) > 0)
          <div class="reveal delay-1">
            <h3 class="text-base font-bold text-[#0c2340] mb-4 flex items-center gap-2">
              <span class="w-1 h-5 bg-[#00a651] rounded-full inline-block"></span>
              Berita Lainnya
            </h3>
            <div class="space-y-3">
              @foreach(array_slice($newsList, 0, 5, true) as $sideIdx => $sideItem)
              <a href="{{ route('news.show', $sideIdx) }}" class="sidebar-card group">
                <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                  @if(isset($sideItem['image']) && $sideItem['image'])
                    <img src="{{ Storage::url($sideItem['image']) }}"
                         alt="{{ $sideItem['title'] ?? '' }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                  @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                      <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0
                                 L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </div>
                  @endif
                </div>
                <div class="flex-1 min-w-0">
                  @if(isset($sideItem['category']))
                  <span class="inline-block text-[10px] font-semibold text-[#00a651]
                               bg-[#00a651]/10 px-2 py-0.5 rounded-full mb-1">
                    {{ $sideItem['category'] }}
                  </span>
                  @endif
                  <p class="text-sm font-semibold text-gray-800 line-clamp-2
                            group-hover:text-[#00a651] transition-colors leading-snug">
                    {{ $sideItem['title'] ?? '' }}
                  </p>
                  @if(isset($sideItem['date']))
                  <p class="text-xs text-gray-400 mt-1">{{ $sideItem['date'] }}</p>
                  @endif
                </div>
              </a>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Kategori --}}
          @php
              $allCats = collect($newsList)->pluck('category')->filter()->unique()->values();
          @endphp
          @if($allCats->count() > 0)
          <div class="reveal delay-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-base font-bold text-[#0c2340] mb-3 flex items-center gap-2">
              <span class="w-1 h-5 bg-[#4da8da] rounded-full inline-block"></span>
              Kategori
            </h3>
            <div class="flex flex-wrap gap-2">
              @foreach($allCats as $cat)
              <a href="/#berita"
                 class="px-3 py-1 rounded-full text-xs font-semibold
                        bg-gray-100 text-gray-600 hover:bg-[#00a651] hover:text-white
                        transition-colors border border-gray-200">
                {{ $cat }}
              </a>
              @endforeach
            </div>
          </div>
          @endif

        </aside>
      </div>
    </div>
  </section>

  {{-- ── CTA ──────────────────────────────────────────────────── --}}
  <section class="py-16 bg-gradient-to-r from-[#0c2340] via-[#0f3460] to-[#00a651] relative overflow-hidden no-print">
    <div class="absolute inset-0 opacity-5"
         style="background-image:radial-gradient(circle at 2px 2px,white 1px,transparent 0);background-size:32px 32px;"></div>
    <div class="relative max-w-3xl mx-auto px-4 text-center">
      <p class="text-white/70 text-sm font-medium mb-2 uppercase tracking-widest">Pendaftaran Mahasiswa Baru</p>
      <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4">
        Siap Bergabung dengan <span class="text-[#f4d03f]">UMPAR?</span>
      </h2>
      <p class="text-white/70 mb-8">
        Daftarkan diri Anda sekarang dan jadilah bagian dari keluarga besar Muhammadiyah.
      </p>
      <a href="{{ route('register.form') }}"
         class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl font-bold shadow-xl
                bg-gradient-to-r from-[#f4d03f] to-[#d4ac0d] text-[#0c2340]
                hover:-translate-y-1 hover:shadow-2xl transition-all">
        Daftar Sekarang
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
    </div>
  </section>

</main>

{{-- FOOTER --}}
<footer class="bg-[#0a1628] text-white py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
              flex flex-col sm:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-3">
      <img src="{{ asset('img/umpar.png') }}" alt="UMPAR" class="w-8 h-8 object-contain">
      <div>
        <p class="font-bold text-sm">UMPAR</p>
        <p class="text-xs text-gray-400">Universitas Muhammadiyah Parepare</p>
      </div>
    </div>
    <p class="text-gray-500 text-sm">
      © <span x-data x-text="new Date().getFullYear()">2025</span> UMPAR. All rights reserved.
    </p>
    <div class="flex gap-4 text-sm text-gray-500">
      <a href="/"          class="hover:text-[#00a651] transition-colors">Beranda</a>
      <a href="/#berita"   class="hover:text-[#4da8da] transition-colors">Berita</a>
      <a href="{{ route('register.form') }}" class="hover:text-[#f4d03f] transition-colors">Daftar</a>
    </div>
  </div>
</footer>

<button id="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Kembali ke atas">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
  </svg>
</button>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Progress bar
  const bar = document.getElementById('progress-bar');
  window.addEventListener('scroll', () => {
    const h = document.documentElement.scrollHeight - window.innerHeight;
    bar.style.width = (h > 0 ? (window.scrollY / h) * 100 : 0) + '%';
  });

  // Back to top
  const btn = document.getElementById('back-to-top');
  window.addEventListener('scroll', () => btn.classList.toggle('visible', window.scrollY > 400));

  // Reveal
  const obs = new IntersectionObserver(
    es => es.forEach(e => { if (e.isIntersecting) e.target.classList.add('active'); }),
    { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
  );
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
});
</script>
</body>
</html>