<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home - Pendaftaran | UMPAR</title>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      /* MUHAMMADIYAH & UMPAR Color Palette */
      /* Biru Tua */
      --blue-dark: #0a1628;
      --blue-900: #0c2340;
      --blue-800: #0f3460;
      --blue-700: #1a4a7a;
      /* Biru Muda / Light Blue */
      --blue-light: #4da8da;
      --blue-400: #5dade2;
      --blue-300: #85c1e9;
      --blue-200: #aed6f1;
      --blue-100: #d6eaf8;
      /* Hijau Muhammadiyah */
      --green-muhammadiyah: #00a651;
      --green-dark: #008c44;
      --green-light: #2ecc71;
      /* Kuning/Emas (Matahari Muhammadiyah) */
      --gold: #f4d03f;
      --gold-dark: #d4ac0d;
      --gold-light: #f7dc6f;
      /* Putih */
      --white: #ffffff;
    }

    * {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .font-display {
      font-family: 'Playfair Display', serif;
    }

    html {
      scroll-behavior: smooth;
    }

    /* =====================================================
       ANIMATED BACKGROUND EFFECTS
       ===================================================== */

    /* Hero gradient dengan warna Muhammadiyah */
    .hero-overlay {
      background: linear-gradient(
        135deg,
        rgba(10, 22, 40, 0.92) 0%,
        rgba(15, 52, 96, 0.88) 30%,
        rgba(0, 166, 81, 0.75) 70%,
        rgba(77, 168, 218, 0.8) 100%
      );
    }

    /* Animated gradient background */
    .gradient-muhammadiyah {
      background: linear-gradient(-45deg,
        var(--blue-900),
        var(--blue-800),
        var(--green-muhammadiyah),
        var(--blue-light),
        var(--blue-900));
      background-size: 400% 400%;
      animation: gradientFlow 12s ease infinite;
    }

    @keyframes gradientFlow {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Aurora effect */
    .aurora {
      position: absolute;
      inset: 0;
      overflow: hidden;
    }

    .aurora::before,
    .aurora::after {
      content: '';
      position: absolute;
      width: 150%;
      height: 150%;
      background: conic-gradient(
        from 0deg,
        transparent 0%,
        var(--green-muhammadiyah) 10%,
        transparent 20%,
        var(--blue-light) 30%,
        transparent 40%,
        var(--gold) 50%,
        transparent 60%,
        var(--green-muhammadiyah) 70%,
        transparent 80%,
        var(--blue-light) 90%,
        transparent 100%
      );
      animation: auroraRotate 20s linear infinite;
      opacity: 0.15;
      filter: blur(80px);
    }

    .aurora::after {
      animation-delay: -10s;
      animation-direction: reverse;
    }

    @keyframes auroraRotate {
      from { transform: translate(-25%, -25%) rotate(0deg); }
      to { transform: translate(-25%, -25%) rotate(360deg); }
    }

    /* =====================================================
       FLOATING ELEMENTS
       ===================================================== */

    .floating-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(60px);
      animation: floatOrb 15s ease-in-out infinite;
    }

    @keyframes floatOrb {
      0%, 100% {
        transform: translate(0, 0) scale(1);
        opacity: 0.6;
      }
      25% {
        transform: translate(30px, -40px) scale(1.1);
        opacity: 0.8;
      }
      50% {
        transform: translate(-20px, -60px) scale(0.9);
        opacity: 0.5;
      }
      75% {
        transform: translate(40px, -20px) scale(1.05);
        opacity: 0.7;
      }
    }

    /* Geometric shapes animation */
    .geo-shape {
      position: absolute;
      opacity: 0.1;
      animation: geoFloat 20s ease-in-out infinite;
    }

    @keyframes geoFloat {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      25% { transform: translateY(-30px) rotate(90deg); }
      50% { transform: translateY(-50px) rotate(180deg); }
      75% { transform: translateY(-20px) rotate(270deg); }
    }

    /* =====================================================
       PARTICLE SYSTEM
       ===================================================== */

    .particles-container {
      position: absolute;
      inset: 0;
      overflow: hidden;
      pointer-events: none;
    }

    .particle {
      position: absolute;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      opacity: 0;
      animation: particleFloat 10s ease-in-out infinite;
    }

    .particle-green { background: var(--green-muhammadiyah); }
    .particle-blue { background: var(--blue-light); }
    .particle-gold { background: var(--gold); }
    .particle-white { background: white; }

    @keyframes particleFloat {
      0% {
        opacity: 0;
        transform: translateY(100vh) scale(0);
      }
      10% {
        opacity: 0.8;
      }
      90% {
        opacity: 0.8;
      }
      100% {
        opacity: 0;
        transform: translateY(-100vh) scale(1);
      }
    }

    /* =====================================================
       GLOWING EFFECTS
       ===================================================== */

    .glow-green {
      box-shadow: 0 0 40px rgba(0, 166, 81, 0.4);
    }

    .glow-blue {
      box-shadow: 0 0 40px rgba(77, 168, 218, 0.4);
    }

    .glow-gold {
      box-shadow: 0 0 40px rgba(244, 208, 63, 0.4);
    }

    /* Text glow */
    .text-glow-green {
      text-shadow: 0 0 30px rgba(0, 166, 81, 0.5);
    }

    .text-glow-gold {
      text-shadow: 0 0 30px rgba(244, 208, 63, 0.5);
    }

    /* =====================================================
       GRADIENT TEXT ANIMATIONS
       ===================================================== */

    .text-gradient-muhammadiyah {
      background: linear-gradient(90deg,
        var(--blue-light),
        var(--green-muhammadiyah),
        var(--gold),
        var(--green-muhammadiyah),
        var(--blue-light));
      background-size: 300% auto;
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: textGradientFlow 4s linear infinite;
    }

    @keyframes textGradientFlow {
      0% { background-position: 0% center; }
      100% { background-position: 300% center; }
    }

    .text-gradient-static {
      background: linear-gradient(135deg, var(--blue-light), var(--green-muhammadiyah));
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* =====================================================
       BUTTON ANIMATIONS
       ===================================================== */

    .btn-muhammadiyah {
      position: relative;
      background: linear-gradient(135deg, var(--green-muhammadiyah), var(--green-dark));
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-muhammadiyah::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      animation: btnShine 3s ease-in-out infinite;
    }

    @keyframes btnShine {
      0%, 100% { left: -100%; }
      50% { left: 100%; }
    }

    .btn-muhammadiyah:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0, 166, 81, 0.4);
    }

    .btn-blue {
      position: relative;
      background: linear-gradient(135deg, var(--blue-800), var(--blue-900));
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-blue::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(77, 168, 218, 0.4), transparent);
      animation: btnShine 3s ease-in-out infinite;
      animation-delay: 1.5s;
    }

    .btn-blue:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 20px 40px rgba(15, 52, 96, 0.5);
    }

    .btn-gold {
      background: linear-gradient(135deg, var(--gold), var(--gold-dark));
      color: var(--blue-900);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-gold:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 20px 40px rgba(244, 208, 63, 0.4);
    }

    /* =====================================================
       CARD ANIMATIONS
       ===================================================== */

    .card-hover {
      transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
      transform: translateY(-12px) rotateX(5deg);
      box-shadow:
        0 30px 60px -15px rgba(10, 22, 40, 0.25),
        0 0 30px rgba(0, 166, 81, 0.1);
    }

    .card-glow {
      position: relative;
      overflow: hidden;
    }

    .card-glow::before {
      content: '';
      position: absolute;
      inset: -2px;
      background: linear-gradient(45deg,
        var(--green-muhammadiyah),
        var(--blue-light),
        var(--gold),
        var(--green-muhammadiyah));
      background-size: 400% 400%;
      animation: borderGlow 6s linear infinite;
      z-index: -1;
      border-radius: inherit;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .card-glow:hover::before {
      opacity: 1;
    }

    @keyframes borderGlow {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* =====================================================
       REVEAL ANIMATIONS
       ===================================================== */

    .reveal {
      opacity: 0;
      transform: translateY(50px);
      transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }

    .reveal-left {
      opacity: 0;
      transform: translateX(-60px);
      transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reveal-left.active {
      opacity: 1;
      transform: translateX(0);
    }

    .reveal-right {
      opacity: 0;
      transform: translateX(60px);
      transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reveal-right.active {
      opacity: 1;
      transform: translateX(0);
    }

    .reveal-scale {
      opacity: 0;
      transform: scale(0.8);
      transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reveal-scale.active {
      opacity: 1;
      transform: scale(1);
    }

    .reveal-rotate {
      opacity: 0;
      transform: rotate(-10deg) translateY(30px);
      transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reveal-rotate.active {
      opacity: 1;
      transform: rotate(0deg) translateY(0);
    }

    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
    .delay-4 { transition-delay: 0.4s; }
    .delay-5 { transition-delay: 0.5s; }
    .delay-6 { transition-delay: 0.6s; }

    /* =====================================================
       ICON ANIMATIONS
       ===================================================== */

    .icon-bounce {
      animation: iconBounce 2s ease-in-out infinite;
    }

    @keyframes iconBounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    .icon-spin {
      animation: iconSpin 8s linear infinite;
    }

    @keyframes iconSpin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .icon-pulse {
      animation: iconPulse 2s ease-in-out infinite;
    }

    @keyframes iconPulse {
      0%, 100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.1); opacity: 0.8; }
    }

    /* =====================================================
       NUMBER/TIMELINE ANIMATIONS
       ===================================================== */

    .number-glow {
      position: relative;
    }

    .number-glow::after {
      content: '';
      position: absolute;
      inset: -6px;
      border-radius: 20px;
      background: linear-gradient(135deg, var(--green-muhammadiyah), var(--blue-light));
      opacity: 0;
      animation: numberPulse 2s ease-in-out infinite;
      z-index: -1;
    }

    @keyframes numberPulse {
      0%, 100% { opacity: 0; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(1.1); }
    }

    .timeline-connector {
      background: linear-gradient(90deg,
        var(--blue-light),
        var(--green-muhammadiyah),
        var(--gold),
        var(--green-muhammadiyah),
        var(--blue-light));
      background-size: 200% 100%;
      animation: timelineShimmer 3s linear infinite;
    }

    @keyframes timelineShimmer {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }

    /* =====================================================
       LOGO ANIMATION
       ===================================================== */

    .logo-container {
      position: relative;
    }

    .logo-ring {
      position: absolute;
      inset: -8px;
      border: 2px solid;
      border-radius: 16px;
      opacity: 0;
      animation: logoRingExpand 3s ease-out infinite;
    }

    .logo-ring-1 {
      border-color: var(--green-muhammadiyah);
      animation-delay: 0s;
    }
    .logo-ring-2 {
      border-color: var(--blue-light);
      animation-delay: 1s;
    }
    .logo-ring-3 {
      border-color: var(--gold);
      animation-delay: 2s;
    }

    @keyframes logoRingExpand {
      0% { transform: scale(1); opacity: 0.8; }
      100% { transform: scale(1.5); opacity: 0; }
    }

    /* =====================================================
       WAVE ANIMATIONS
       ===================================================== */

    .wave-container {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 150px;
      overflow: hidden;
    }

    .wave {
      position: absolute;
      bottom: 0;
      width: 200%;
      height: 100%;
      animation: waveMove 15s linear infinite;
    }

    .wave-1 {
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.3' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
      animation-duration: 20s;
    }

    .wave-2 {
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.5' d='M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,90.7C672,85,768,107,864,144C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
      animation-duration: 15s;
      animation-delay: -5s;
    }

    .wave-3 {
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='1' d='M0,256L48,240C96,224,192,192,288,181.3C384,171,480,181,576,186.7C672,192,768,192,864,181.3C960,171,1056,149,1152,154.7C1248,160,1344,192,1392,208L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
      animation-duration: 12s;
      animation-delay: -2s;
    }

    @keyframes waveMove {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }

    /* =====================================================
       IMAGE EFFECTS
       ===================================================== */

    .img-zoom {
      overflow: hidden;
    }

    .img-zoom img {
      transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .img-zoom:hover img {
      transform: scale(1.15);
    }

    /* =====================================================
       QUOTE DECORATION
       ===================================================== */

    .quote-mark {
      font-size: 5rem;
      line-height: 1;
      font-family: Georgia, serif;
      background: linear-gradient(135deg, var(--green-muhammadiyah), var(--blue-light));
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      opacity: 0.2;
    }

    /* =====================================================
       CUSTOM SCROLLBAR
       ===================================================== */

    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background: var(--blue-dark);
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(var(--green-muhammadiyah), var(--blue-light));
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(var(--green-dark), var(--blue-800));
    }

    /* =====================================================
       GLASS MORPHISM
       ===================================================== */

    .glass {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }

    .glass-dark {
      background: rgba(10, 22, 40, 0.8);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }

    .glass-green {
      background: rgba(0, 166, 81, 0.1);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }

    /* =====================================================
       DECORATIVE SHAPES
       ===================================================== */

    .hexagon {
      clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    }

    .star-shape {
      clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
    }

    /* Muhammadiyah sun rays */
    .sun-rays {
      position: absolute;
      width: 200px;
      height: 200px;
      background: conic-gradient(
        from 0deg,
        transparent 0deg,
        var(--gold) 5deg,
        transparent 10deg
      );
      animation: sunRotate 30s linear infinite;
      opacity: 0.1;
    }

    @keyframes sunRotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* =====================================================
       TYPING ANIMATION
       ===================================================== */

    .typing-text {
      overflow: hidden;
      white-space: nowrap;
      border-right: 3px solid var(--green-muhammadiyah);
      animation: typing 3s steps(30) forwards, blinkCursor 0.8s infinite;
    }

    @keyframes typing {
      from { width: 0; }
      to { width: 100%; }
    }

    @keyframes blinkCursor {
      0%, 100% { border-color: transparent; }
      50% { border-color: var(--green-muhammadiyah); }
    }

    /* =====================================================
       COUNTER ANIMATION
       ===================================================== */

    .counter-box {
      position: relative;
      overflow: hidden;
    }

    .counter-box::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: conic-gradient(
        from 0deg,
        transparent,
        rgba(0, 166, 81, 0.1),
        transparent
      );
      animation: counterSpin 4s linear infinite;
    }

    @keyframes counterSpin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* =====================================================
       RESPONSIVE FIXES
       ===================================================== */

    @media (max-width: 768px) {
      .floating-orb {
        opacity: 0.4;
      }
      .aurora::before,
      .aurora::after {
        opacity: 0.1;
      }
    }
  </style>
</head>
<body class="antialiased text-gray-800 bg-white overflow-x-hidden">

  <!-- HEADER -->
  <header class="fixed w-full z-50 transition-all duration-500"
          x-data="{ scrolled: false, mobileOpen: false }"
          x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
          :class="scrolled ? 'bg-white/95 backdrop-blur-lg shadow-xl shadow-[#0a1628]/10' : 'bg-transparent'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        <!-- Logo -->

          <div class="logo-container relative">
            <div class="logo-ring logo-ring-1 rounded-xl"></div>
            <div class="logo-ring logo-ring-2 rounded-xl"></div>
            <div class="logo-ring logo-ring-3 rounded-xl"></div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-[#d9e2de] via-[#0f3460] to-[#4da8da] shadow-lg group-hover:scale-110 transition-transform duration-300">
             <div class="w-15 h-15 rounded-xl overflow-hidden bg-white flex items-center justify-center">
                    <img
                        src="{{ asset('img/umpar.png') }}"
                        alt="UMPAR"
                        class="max-w-full max-h-full object-contain"
                    >
                </div>
            </div>
          </div>
          <div>
            <h1 class="text-lg font-bold transition-colors duration-300" :class="scrolled ? 'text-[#0c2340]' : 'text-white'">UMPAR</h1>
            <p class="text-xs transition-colors duration-300" :class="scrolled ? 'text-gray-500' : 'text-white/80'">Universitas Muhammadiyah Parepare</p>
          </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-1">
          <a href="#program" class="px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-[#00a651]/10" :class="scrolled ? 'text-gray-700 hover:text-[#00a651]' : 'text-white/90 hover:text-white hover:bg-white/10'">Program Studi</a>
          <a href="#alur" class="px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-[#00a651]/10" :class="scrolled ? 'text-gray-700 hover:text-[#00a651]' : 'text-white/90 hover:text-white hover:bg-white/10'">Alur Pendaftaran</a>
          <a href="#testimoni" class="px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-[#00a651]/10" :class="scrolled ? 'text-gray-700 hover:text-[#00a651]' : 'text-white/90 hover:text-white hover:bg-white/10'">Testimoni</a>
          <a href="#berita" class="px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-[#00a651]/10" :class="scrolled ? 'text-gray-700 hover:text-[#00a651]' : 'text-white/90 hover:text-white hover:bg-white/10'">Berita</a>

          <div class="flex items-center gap-3 ml-4">
            <a href="/login" class="px-5 py-2.5 rounded-xl font-semibold border-2 transition-all duration-300" :class="scrolled ? 'border-[#0c2340] text-[#0c2340] hover:bg-[#0c2340]/5' : 'border-white/50 text-white hover:bg-white/10'">
              Masuk
            </a>
            <a href="/register?program=ti" class="btn-muhammadiyah px-5 py-2.5 rounded-xl font-semibold text-white shadow-lg shadow-[#00a651]/30">
              Daftar Sekarang
            </a>
          </div>
        </nav>

        <!-- Mobile menu button -->
        <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-xl transition-all duration-300" :class="scrolled ? 'bg-gray-100 text-gray-700' : 'bg-white/10 text-white'">
          <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile drawer -->
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         x-cloak
         class="lg:hidden bg-white border-t shadow-xl">
      <div class="px-6 py-6 space-y-2">
        <a href="#program" @click="mobileOpen = false" class="block py-3 px-4 rounded-xl text-gray-700 hover:bg-[#00a651]/10 hover:text-[#00a651] font-medium transition-colors">Program Studi</a>
        <a href="#alur" @click="mobileOpen = false" class="block py-3 px-4 rounded-xl text-gray-700 hover:bg-[#00a651]/10 hover:text-[#00a651] font-medium transition-colors">Alur Pendaftaran</a>
        <a href="#testimoni" @click="mobileOpen = false" class="block py-3 px-4 rounded-xl text-gray-700 hover:bg-[#00a651]/10 hover:text-[#00a651] font-medium transition-colors">Testimoni</a>
        <a href="#berita" @click="mobileOpen = false" class="block py-3 px-4 rounded-xl text-gray-700 hover:bg-[#00a651]/10 hover:text-[#00a651] font-medium transition-colors">Berita</a>
        <div class="flex gap-3 pt-4">
          <a href="{{ route('login') }}" class="flex-1 text-center py-3 rounded-xl border-2 border-[#0c2340] text-[#0c2340] font-semibold hover:bg-[#0c2340]/5 transition-colors">Masuk</a>
          <a href="{{ route('register.form') }}" class="flex-1 text-center py-3 rounded-xl bg-gradient-to-r from-[#00a651] to-[#008c44] text-white font-semibold shadow-lg">Daftar</a>
        </div>
      </div>
    </div>
  </header>

  <main>

    <!-- HERO -->
    <section class="relative min-h-screen flex items-center overflow-hidden">
      <!-- Video Background -->
      <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
        <source src="/media/hero-campus.mp4" type="video/mp4">
      </video>

      <!-- Gradient Overlay -->
      <div class="absolute inset-0 hero-overlay"></div>

      <!-- Aurora Effect -->
      <div class="aurora"></div>

      <!-- Floating Orbs -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-orb w-80 h-80 bg-[#00a651] top-10 left-10" style="animation-delay: 0s;"></div>
        <div class="floating-orb w-96 h-96 bg-[#4da8da] bottom-20 right-10" style="animation-delay: -5s;"></div>
        <div class="floating-orb w-72 h-72 bg-[#f4d03f] top-1/2 left-1/3" style="animation-delay: -10s;"></div>
      </div>

      <!-- Particles -->
      <div class="particles-container" id="particles"></div>

      <!-- Sun Rays (Muhammadiyah Symbol) -->
      <div class="absolute top-20 right-20 sun-rays hidden lg:block"></div>

      <!-- Geometric Shapes -->
      <div class="geo-shape top-1/4 left-1/4 w-20 h-20 border-2 border-[#00a651] rotate-45" style="animation-delay: -2s;"></div>
      <div class="geo-shape bottom-1/4 right-1/4 w-16 h-16 border-2 border-[#4da8da] rounded-full" style="animation-delay: -5s;"></div>
      <div class="geo-shape top-1/3 right-1/3 w-12 h-12 bg-[#f4d03f]/20 star-shape" style="animation-delay: -8s;"></div>

      <!-- Content -->
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

          <!-- Left Column -->
          <div class="text-white space-y-8">
            <div class="reveal-left">
              <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm font-medium">
                <span class="w-2.5 h-2.5 bg-[#00a651] rounded-full animate-pulse"></span>
                <span class="text-[#f4d03f]">✦</span> Pendaftaran Gelombang 1 Dibuka
              </span>
            </div>

            <h2 class="reveal-left delay-1 text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
              Wujudkan<br>
              <span class="font-display">Masa Depanmu</span><br>
              <span class="text-gradient-muhammadiyah">Bersama UMPAR</span>
            </h2>

            <p class="reveal-left delay-2 text-lg sm:text-xl text-white/80 max-w-lg leading-relaxed">
              Universitas Muhammadiyah Parepare - Kampus dengan akreditasi unggulan, nilai-nilai Islami, dan jaringan industri terluas di Sulawesi Selatan.
            </p>

            <div class="reveal-left delay-3 flex flex-wrap gap-4">
              <a href="{{ route('pendaftaran.form') }}" class="btn-gold group inline-flex items-center gap-3 px-8 py-4 rounded-2xl font-bold shadow-2xl">
                DAFTAR SEKARANG
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </a>
              <a href="#info" class="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl border-2 border-white/40 text-white font-semibold hover:bg-white/10 hover:border-[#00a651] transition-all duration-300">
                INFO LEBIH LANJUT
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
              </a>
            </div>

            <!-- Stats with Muhammadiyah colors -->
            <div class="reveal-left delay-4 grid grid-cols-3 gap-4 pt-8 max-w-lg">
              <div class="counter-box glass-dark rounded-2xl p-4 text-center border border-[#00a651]/30">
                <div class="relative z-10">
                  <div class="text-2xl font-bold text-[#00a651]">A</div>
                  <div class="text-xs text-white/70 mt-1">Akreditasi</div>
                </div>
              </div>
              <div class="counter-box glass-dark rounded-2xl p-4 text-center border border-[#4da8da]/30">
                <div class="relative z-10">
                  <div class="text-2xl font-bold text-[#4da8da]">20+</div>
                  <div class="text-xs text-white/70 mt-1">Prodi</div>
                </div>
              </div>
              <div class="counter-box glass-dark rounded-2xl p-4 text-center border border-[#f4d03f]/30">
                <div class="relative z-10">
                  <div class="text-2xl font-bold text-[#f4d03f]">5K+</div>
                  <div class="text-xs text-white/70 mt-1">Alumni</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column - Hero Card -->
          <div class="hidden lg:block reveal-right delay-2">
            <div class="relative">
              <!-- Decorative glow -->
              <div class="absolute -inset-4 bg-gradient-to-r from-[#00a651] via-[#4da8da] to-[#f4d03f] rounded-3xl blur-2xl opacity-30 animate-pulse"></div>

              <div class="relative glass rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                <div class="img-zoom relative">
                  <img src="/img/UMPAR-3.jpg" alt="Mahasiswa UMPAR" class="w-full h-72 object-cover" />
                  <!-- Muhammadiyah badge -->
                  <div class="absolute top-4 right-4 w-16 h-16 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-2xl">☀️</span>
                  </div>
                </div>
                <div class="p-8">
                  <div class="flex items-center gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full bg-[#00a651]/10 text-[#00a651] text-xs font-semibold border border-[#00a651]/20">BARU</span>
                    <span class="text-sm text-gray-500">Gelombang 1 • 2025/2026</span>
                  </div>
                  <h3 class="text-2xl font-bold text-[#0c2340] mb-3">Pendaftaran Mahasiswa Baru</h3>
                  <p class="text-gray-600 mb-6">Bergabunglah dengan keluarga besar Muhammadiyah dan raih masa depan gemilang.</p>
                  <div class="flex gap-3">
                    <a href="{{ route('pendaftaran.form') }}" class="flex-1 btn-muhammadiyah text-center px-6 py-3 text-white rounded-xl font-semibold">
                      Daftar
                    </a>
                    <a href="/programs" class="flex-1 text-center px-6 py-3 border-2 border-[#0c2340] text-[#0c2340] rounded-xl font-semibold hover:bg-[#0c2340]/5 transition-all duration-300">
                      Lihat Program
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Wave Divider -->
      <div class="wave-container">
        <div class="wave wave-1"></div>
        <div class="wave wave-2"></div>
        <div class="wave wave-3"></div>
      </div>
    </section>

    <!-- KEUNGGULAN -->
    <section id="info" class="relative py-24 bg-white overflow-hidden">
      <!-- Decorative elements -->
      <div class="absolute top-0 right-0 w-96 h-96 bg-[#00a651]/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
      <div class="absolute bottom-0 left-0 w-72 h-72 bg-[#4da8da]/5 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] sun-rays opacity-5"></div>

      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <span class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#00a651]/10 text-[#00a651] text-sm font-semibold mb-4 border border-[#00a651]/20">
            <span class="icon-spin">☀️</span>
            MENGAPA MEMILIH KAMI
          </span>
          <h4 class="reveal delay-1 text-3xl sm:text-4xl font-bold text-[#0c2340] mb-4">
            Keunggulan <span class="text-gradient-static">UMPAR</span>
          </h4>
          <p class="reveal delay-2 text-gray-600 max-w-2xl mx-auto text-lg">
            Dengan nilai-nilai Islami dan komitmen pada kualitas, kami siap mencetak generasi unggul.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
          <!-- Card 1 - Akreditasi -->
          <div class="reveal delay-1 card-hover card-glow group p-8 rounded-3xl bg-white border border-gray-100 shadow-xl">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#00a651] to-[#008c44] text-white mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg shadow-[#00a651]/30">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 icon-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
              </svg>
            </div>
            <h5 class="text-xl font-bold text-[#0c2340] mb-3 group-hover:text-[#00a651] transition-colors">Akreditasi Unggul</h5>
            <p class="text-gray-600">Program studi terakreditasi BAN-PT dengan kurikulum terstandar industri.</p>
          </div>

          <!-- Card 2 - Beasiswa -->
          <div class="reveal delay-2 card-hover card-glow group p-8 rounded-3xl bg-white border border-gray-100 shadow-xl">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#4da8da] to-[#0f3460] text-white mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg shadow-[#4da8da]/30">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 icon-pulse" style="animation-delay: 0.3s;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h5 class="text-xl font-bold text-[#0c2340] mb-3 group-hover:text-[#4da8da] transition-colors">Beasiswa Lengkap</h5>
            <p class="text-gray-600">Berbagai skema beasiswa untuk mahasiswa berprestasi dan kurang mampu.</p>
          </div>

          <!-- Card 3 - Islami -->
          <div class="reveal delay-3 card-hover card-glow group p-8 rounded-3xl bg-white border border-gray-100 shadow-xl">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#f4d03f] to-[#d4ac0d] text-[#0c2340] mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg shadow-[#f4d03f]/30">
              <span class="text-3xl icon-spin" style="animation-duration: 20s;">☀️</span>
            </div>
            <h5 class="text-xl font-bold text-[#0c2340] mb-3 group-hover:text-[#d4ac0d] transition-colors">Nilai Islami</h5>
            <p class="text-gray-600">Pendidikan berbasis nilai-nilai Islam ala Muhammadiyah yang moderat.</p>
          </div>

          <!-- Card 4 - Karir -->
          <div class="reveal delay-4 card-hover card-glow group p-8 rounded-3xl bg-white border border-gray-100 shadow-xl">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#0c2340] to-[#0f3460] text-white mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg shadow-[#0c2340]/30">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 icon-pulse" style="animation-delay: 0.6s;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <h5 class="text-xl font-bold text-[#0c2340] mb-3 group-hover:text-[#0f3460] transition-colors">Siap Kerja</h5>
            <p class="text-gray-600">Program magang dan kerja sama industri untuk karier profesional.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- PROGRAM STUDI POPULER -->
    <section id="program" class="py-24 bg-gradient-to-b from-[#f8fafc] to-white relative overflow-hidden">
      <!-- Decorative -->
      <div class="absolute top-20 left-10 w-32 h-32 border-2 border-[#00a651]/10 rounded-full animate-pulse"></div>
      <div class="absolute bottom-20 right-10 w-24 h-24 border-2 border-[#4da8da]/10 rotate-45"></div>

      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
          <div>
            <span class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#4da8da]/10 text-[#0f3460] text-sm font-semibold mb-4 border border-[#4da8da]/20">
              🎓 PROGRAM UNGGULAN
            </span>
            <h4 class="reveal delay-1 text-3xl sm:text-4xl font-bold text-[#0c2340]">
              Program Studi <span class="text-gradient-static">Populer</span>
            </h4>
          </div>
          <a href="/programs" class="reveal delay-2 group inline-flex items-center gap-2 text-[#00a651] font-semibold hover:text-[#008c44] transition-colors">
            Lihat Semua Program
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Card TI -->
          <div class="reveal delay-1 card-hover card-glow group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="img-zoom relative h-52">
              <img src="/img/teknik-informatika.jpg" alt="Teknik Informatika" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-[#0c2340]/80 to-transparent"></div>
              <span class="absolute bottom-4 left-4 px-3 py-1 rounded-full bg-[#00a651] text-white text-xs font-semibold">Teknologi</span>
            </div>
            <div class="p-6">
              <h5 class="text-xl font-bold text-[#0c2340] mb-2 group-hover:text-[#00a651] transition-colors">Teknik Informatika</h5>
              <p class="text-gray-600 text-sm mb-6">Kurikulum terkini, laboratorium lengkap, dan dosen berpengalaman di industri IT.</p>
              <div class="flex gap-3">
                <a href="/programs/ti" class="flex-1 text-center py-3 rounded-xl border-2 border-[#0c2340] text-[#0c2340] font-semibold hover:bg-[#0c2340]/5 transition-all">
                  Detail
                </a>
                <a href="/register?program=ti" class="flex-1 btn-muhammadiyah text-center py-3 rounded-xl text-white font-semibold">
                  Daftar
                </a>
              </div>
            </div>
          </div>

          <!-- Card Bisnis -->
          <div class="reveal delay-2 card-hover card-glow group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="img-zoom relative h-52">
              <img src="/img/manajemen-bisnis.jpg" alt="Bisnis & Manajemen" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-[#0c2340]/80 to-transparent"></div>
              <span class="absolute bottom-4 left-4 px-3 py-1 rounded-full bg-[#4da8da] text-white text-xs font-semibold">Bisnis</span>
            </div>
            <div class="p-6">
              <h5 class="text-xl font-bold text-[#0c2340] mb-2 group-hover:text-[#4da8da] transition-colors">Bisnis & Manajemen</h5>
              <p class="text-gray-600 text-sm mb-6">Fokus pada kewirausahaan, manajemen, dan keterampilan bisnis modern.</p>
              <div class="flex gap-3">
                <a href="/programs/bisnis" class="flex-1 text-center py-3 rounded-xl border-2 border-[#0c2340] text-[#0c2340] font-semibold hover:bg-[#0c2340]/5 transition-all">
                  Detail
                </a>
                <a href="/register?program=bisnis" class="flex-1 btn-blue text-center py-3 rounded-xl text-white font-semibold">
                  Daftar
                </a>
              </div>
            </div>
          </div>

          <!-- Card Pendidikan -->
          <div class="reveal delay-3 card-hover card-glow group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="img-zoom relative h-52">
              <img src="/img/pendidikan.jpg" alt="Pendidikan" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-[#0c2340]/80 to-transparent"></div>
              <span class="absolute bottom-4 left-4 px-3 py-1 rounded-full bg-[#f4d03f] text-[#0c2340] text-xs font-semibold">Pendidikan</span>
            </div>
            <div class="p-6">
              <h5 class="text-xl font-bold text-[#0c2340] mb-2 group-hover:text-[#d4ac0d] transition-colors">Pendidikan & Keguruan</h5>
              <p class="text-gray-600 text-sm mb-6">Mencetak guru profesional dengan nilai-nilai Islam Muhammadiyah.</p>
              <div class="flex gap-3">
                <a href="/programs/dkv" class="flex-1 text-center py-3 rounded-xl border-2 border-[#0c2340] text-[#0c2340] font-semibold hover:bg-[#0c2340]/5 transition-all">
                  Detail
                </a>
                <a href="/register?program=dkv" class="flex-1 btn-gold text-center py-3 rounded-xl font-semibold">
                  Daftar
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ALUR PENDAFTARAN -->
    <section id="alur" class="py-24 bg-white relative overflow-hidden">
      <!-- Animated background -->
      <div class="absolute inset-0">
        <div class="absolute top-20 left-1/4 w-64 h-64 bg-[#00a651]/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-1/4 w-96 h-96 bg-[#4da8da]/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-[#f4d03f]/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
      </div>

      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <span class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#f4d03f]/10 text-[#d4ac0d] text-sm font-semibold mb-4 border border-[#f4d03f]/20">
            ⭐ LANGKAH MUDAH
          </span>
          <h4 class="reveal delay-1 text-3xl sm:text-4xl font-bold text-[#0c2340] mb-4">
            Alur <span class="text-gradient-static">Pendaftaran</span>
          </h4>
          <p class="reveal delay-2 text-gray-600 max-w-2xl mx-auto text-lg">
            Proses pendaftaran yang mudah dan cepat untuk bergabung bersama keluarga besar Muhammadiyah.
          </p>
        </div>

        <!-- Timeline -->
        <div class="reveal delay-3 relative">
          <div class="overflow-x-auto pb-4 -mx-4 px-4">
            <div class="min-w-[900px] flex items-start gap-0">

              <!-- Step 1 -->
              <div class="flex-1 flex flex-col items-center text-center px-4 group">
                <div class="number-glow w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#00a651] to-[#008c44] text-white text-xl font-bold shadow-lg shadow-[#00a651]/30 mb-4 group-hover:scale-110 transition-transform">
                  1
                </div>
                <h6 class="font-bold text-[#0c2340] mb-2">Buat Akun</h6>
                <p class="text-sm text-gray-500">Daftar dengan email aktif Anda.</p>
              </div>

              <!-- Connector -->
              <div class="w-20 flex items-center justify-center pt-7">
                <div class="timeline-connector h-1.5 w-full rounded-full"></div>
              </div>

              <!-- Step 2 -->
              <div class="flex-1 flex flex-col items-center text-center px-4 group">
                <div class="number-glow w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#4da8da] to-[#0f3460] text-white text-xl font-bold shadow-lg shadow-[#4da8da]/30 mb-4 group-hover:scale-110 transition-transform" style="--delay: 0.4s;">
                  2
                </div>
                <h6 class="font-bold text-[#0c2340] mb-2">Isi Formulir</h6>
                <p class="text-sm text-gray-500">Lengkapi data akademik dan pribadi.</p>
              </div>

              <!-- Connector -->
              <div class="w-20 flex items-center justify-center pt-7">
                <div class="timeline-connector h-1.5 w-full rounded-full"></div>
              </div>

              <!-- Step 3 -->
              <div class="flex-1 flex flex-col items-center text-center px-4 group">
                <div class="number-glow w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#f4d03f] to-[#d4ac0d] text-[#0c2340] text-xl font-bold shadow-lg shadow-[#f4d03f]/30 mb-4 group-hover:scale-110 transition-transform" style="--delay: 0.8s;">
                  3
                </div>
                <h6 class="font-bold text-[#0c2340] mb-2">Unggah Dokumen</h6>
                <p class="text-sm text-gray-500">Ijazah, transkrip, pas foto, dsb.</p>
              </div>

              <!-- Connector -->
              <div class="w-20 flex items-center justify-center pt-7">
                <div class="timeline-connector h-1.5 w-full rounded-full"></div>
              </div>

              <!-- Step 4 -->
              <div class="flex-1 flex flex-col items-center text-center px-4 group">
                <div class="number-glow w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#0f3460] to-[#0c2340] text-white text-xl font-bold shadow-lg shadow-[#0f3460]/30 mb-4 group-hover:scale-110 transition-transform" style="--delay: 1.2s;">
                  4
                </div>
                <h6 class="font-bold text-[#0c2340] mb-2">Pembayaran</h6>
                <p class="text-sm text-gray-500">Bayar via metode yang tersedia.</p>
              </div>

              <!-- Connector -->
              <div class="w-20 flex items-center justify-center pt-7">
                <div class="timeline-connector h-1.5 w-full rounded-full"></div>
              </div>

              <!-- Step 5 -->
              <div class="flex-1 flex flex-col items-center text-center px-4 group">
                <div class="number-glow w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#00a651] via-[#4da8da] to-[#f4d03f] text-white text-xl font-bold shadow-lg mb-4 group-hover:scale-110 transition-transform" style="--delay: 1.6s;">
                  ✓
                </div>
                <h6 class="font-bold text-[#0c2340] mb-2">Pengumuman</h6>
                <p class="text-sm text-gray-500">Cek hasil seleksi via akun.</p>
              </div>

            </div>
          </div>

          <!-- CTA Button -->
          <div class="reveal delay-4 text-center mt-12">
            <a href="/register?program=ti" class="btn-muhammadiyah inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-white font-bold shadow-xl">
              Mulai Daftar Sekarang
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 icon-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- TESTIMONI -->
    <section id="testimoni" class="py-24 bg-gradient-to-b from-[#f8fafc] to-white relative overflow-hidden">
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <span class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#00a651]/10 text-[#00a651] text-sm font-semibold mb-4 border border-[#00a651]/20">
            💬 TESTIMONI
          </span>
          <h4 class="reveal delay-1 text-3xl sm:text-4xl font-bold text-[#0c2340] mb-4">
            Apa Kata <span class="text-gradient-static">Alumni</span>?
          </h4>
          <p class="reveal delay-2 text-gray-600 max-w-2xl mx-auto text-lg">
            Dengarkan pengalaman dari para alumni dan mahasiswa kami.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Testimonial 1 -->
          <div class="reveal delay-1 card-hover card-glow relative p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
            <div class="quote-mark absolute top-4 right-6">"</div>
            <div class="flex items-center gap-4 mb-6">
              <img src="/img/alumni-1.jpg" alt="Alumni" class="w-14 h-14 rounded-2xl object-cover ring-4 ring-[#00a651]/20">
              <div>
                <div class="font-bold text-[#0c2340]">Aulia Rahma</div>
                <div class="text-sm text-[#00a651]">Lulusan TI 2022</div>
              </div>
            </div>
            <p class="text-gray-600 leading-relaxed">"UMPAR memberikan pengalaman belajar yang luar biasa dengan nilai-nilai Islami yang kuat. Dosen sangat supportif!"</p>
            <div class="flex gap-1 mt-4">
              <span class="text-[#f4d03f]">★★★★★</span>
            </div>
          </div>

          <!-- Testimonial 2 -->
          <div class="reveal delay-2 card-hover card-glow relative p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
            <div class="quote-mark absolute top-4 right-6">"</div>
            <div class="flex items-center gap-4 mb-6">
              <img src="/img/alumni-2.jpg" alt="Alumni" class="w-14 h-14 rounded-2xl object-cover ring-4 ring-[#4da8da]/20">
              <div>
                <div class="font-bold text-[#0c2340]">Budi Santoso</div>
                <div class="text-sm text-[#4da8da]">Lulusan Bisnis 2021</div>
              </div>
            </div>
            <p class="text-gray-600 leading-relaxed">"Program magang membuka kesempatan kerja yang luas. Jaringan alumni Muhammadiyah sangat membantu karier saya."</p>
            <div class="flex gap-1 mt-4">
              <span class="text-[#f4d03f]">★★★★★</span>
            </div>
          </div>

          <!-- Testimonial 3 -->
          <div class="reveal delay-3 card-hover card-glow relative p-8 bg-white rounded-3xl shadow-xl border border-gray-100">
            <div class="quote-mark absolute top-4 right-6">"</div>
            <div class="flex items-center gap-4 mb-6">
              <img src="/img/alumni-3.jpg" alt="Alumni" class="w-14 h-14 rounded-2xl object-cover ring-4 ring-[#f4d03f]/20">
              <div>
                <div class="font-bold text-[#0c2340]">Citra Dewi</div>
                <div class="text-sm text-[#d4ac0d]">Lulusan PGSD 2020</div>
              </div>
            </div>
            <p class="text-gray-600 leading-relaxed">"Lingkungan kampus yang Islami dan modern membuat saya berkembang pesat sebagai pendidik profesional."</p>
            <div class="flex gap-1 mt-4">
              <span class="text-[#f4d03f]">★★★★★</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BERITA -->
    <section id="berita" class="py-24 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
          <div>
            <span class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#4da8da]/10 text-[#0f3460] text-sm font-semibold mb-4 border border-[#4da8da]/20">
              📰 BERITA TERBARU
            </span>
            <h4 class="reveal delay-1 text-3xl sm:text-4xl font-bold text-[#0c2340]">
              Berita & <span class="text-gradient-static">Kegiatan</span>
            </h4>
          </div>
          <a href="/news" class="reveal delay-2 group inline-flex items-center gap-2 text-[#00a651] font-semibold hover:text-[#008c44] transition-colors">
            Lihat Semua Berita
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- News 1 -->
          <article class="reveal delay-1 card-hover card-glow group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="img-zoom relative h-52">
              <img src="/img/workshop-wirausaha.jpg" alt="Berita 1" class="w-full h-full object-cover">
              <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#00a651] text-white text-xs font-semibold">Kegiatan</div>
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                12 November 2025
              </div>
              <h5 class="text-lg font-bold text-[#0c2340] mb-2 group-hover:text-[#00a651] transition-colors">Workshop Kewirausahaan Mahasiswa</h5>
              <p class="text-gray-600 text-sm mb-4">Mahasiswa belajar strategi bisnis modern dari praktisi industri.</p>
              <a href="/news/1" class="inline-flex items-center gap-2 text-[#00a651] font-semibold group-hover:gap-3 transition-all">
                Baca Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </a>
            </div>
          </article>

          <!-- News 2 -->
          <article class="reveal delay-2 card-hover card-glow group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="img-zoom relative h-52">
              <img src="/img/MoU-industri.jpg" alt="Berita 2" class="w-full h-full object-cover">
              <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#4da8da] text-white text-xs font-semibold">Kerjasama</div>
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                2 Oktober 2025
              </div>
              <h5 class="text-lg font-bold text-[#0c2340] mb-2 group-hover:text-[#4da8da] transition-colors">Penandatanganan MoU Industri</h5>
              <p class="text-gray-600 text-sm mb-4">Penguatan kerja sama riset dan program magang mahasiswa.</p>
              <a href="/news/2" class="inline-flex items-center gap-2 text-[#4da8da] font-semibold group-hover:gap-3 transition-all">
                Baca Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </a>
            </div>
          </article>

          <!-- News 3 -->
          <article class="reveal delay-3 card-hover card-glow group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="img-zoom relative h-52">
              <img src="/img/milad-muhammadiyah-113.jpg" alt="Berita 3" class="w-full h-full object-cover">
              <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#f4d03f] text-[#0c2340] text-xs font-semibold">Milad</div>
            </div>
            <div class="p-6">
              <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                25 September 2025
              </div>
              <h5 class="text-lg font-bold text-[#0c2340] mb-2 group-hover:text-[#d4ac0d] transition-colors">Milad Muhammadiyah ke-113</h5>
              <p class="text-gray-600 text-sm mb-4">Perayaan milad dengan berbagai kegiatan sosial dan keagamaan.</p>
              <a href="/news/3" class="inline-flex items-center gap-2 text-[#d4ac0d] font-semibold group-hover:gap-3 transition-all">
                Baca Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 relative overflow-hidden">
      <div class="absolute inset-0 gradient-muhammadiyah"></div>
      <div class="aurora"></div>

      <!-- Sun rays decoration -->
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 sun-rays w-[600px] h-[600px] opacity-10"></div>

      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <div class="reveal inline-block mb-6">
          <span class="text-6xl">☀️</span>
        </div>
        <h4 class="reveal delay-1 text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
          Siap Bergabung dengan<br>
          <span class="text-[#f4d03f] text-glow-gold">Keluarga Muhammadiyah?</span>
        </h4>
        <p class="reveal delay-2 text-white/80 text-lg mb-10 max-w-2xl mx-auto">
          Jangan lewatkan kesempatan untuk menjadi bagian dari komunitas akademik terbaik dengan nilai-nilai Islam yang moderat.
        </p>
        <div class="reveal delay-3 flex flex-wrap justify-center gap-4">
          <a href="/register?program=ti" class="btn-gold inline-flex items-center gap-3 px-8 py-4 rounded-2xl font-bold shadow-2xl">
            Daftar Sekarang
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
          </a>
          <a href="#info" class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl border-2 border-white/40 text-white font-semibold hover:bg-white/10 transition-all duration-300">
            Pelajari Lebih Lanjut
          </a>
        </div>
      </div>
    </section>

  </main>

  <!-- FOOTER -->
  <footer class="bg-[#0a1628] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <!-- About -->
        <div class="lg:col-span-1">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-gradient-to-br from-[#00a651] via-[#4da8da] to-[#f4d03f] p-0.5">
              <div class="w-full h-full bg-[#0a1628] rounded-[10px] flex items-center justify-center">
                <span class="text-white font-bold text-lg">UM</span>
              </div>
            </div>
            <div>
              <h6 class="font-bold text-lg">UMPAR</h6>
              <p class="text-sm text-gray-400">Universitas Muhammadiyah Parepare</p>
            </div>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed mb-6">
            Kampus Muhammadiyah dengan nilai-nilai Islam moderat dan komitmen mencetak generasi unggul.
          </p>
          <div class="flex gap-3">
            <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-[#00a651] transition-colors border border-white/10">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-[#4da8da] transition-colors border border-white/10">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-[#f4d03f] hover:text-[#0a1628] transition-colors border border-white/10">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h6 class="font-bold text-lg mb-6 text-[#00a651]">Link Cepat</h6>
          <ul class="space-y-3">
            <li><a href="/register?program=ti" class="text-gray-400 hover:text-[#00a651] transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#00a651] rounded-full"></span>Pendaftaran</a></li>
            <li><a href="/programs" class="text-gray-400 hover:text-[#4da8da] transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#4da8da] rounded-full"></span>Program Studi</a></li>
            <li><a href="/news" class="text-gray-400 hover:text-[#f4d03f] transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-[#f4d03f] rounded-full"></span>Berita Kampus</a></li>
            <li><a href="#testimoni" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-white rounded-full"></span>Testimoni</a></li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h6 class="font-bold text-lg mb-6 text-[#4da8da]">Kontak</h6>
          <ul class="space-y-4 text-gray-400">
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 text-[#00a651]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>Jl. Jenderal Ahmad Yani KM 6, Parepare, Sulawesi Selatan</span>
            </li>
            <li class="flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4da8da]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              <span>(0421) 2912 2xxx</span>
            </li>
            <li class="flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f4d03f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <span>info@umpar.ac.id</span>
            </li>
          </ul>
        </div>

        <!-- Newsletter -->
        <div>
          <h6 class="font-bold text-lg mb-6 text-[#f4d03f]">Newsletter</h6>
          <p class="text-gray-400 text-sm mb-4">Dapatkan informasi terbaru seputar kampus dan pendaftaran.</p>
          <form class="flex gap-2">
            <input type="email" placeholder="Email Anda" class="flex-1 px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#00a651] transition-colors">
            <button type="submit" class="px-4 py-3 rounded-xl bg-gradient-to-r from-[#00a651] to-[#4da8da] text-white font-semibold hover:shadow-lg hover:shadow-[#00a651]/30 transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-gray-500 text-sm flex items-center gap-2">
          © <span x-data x-text="new Date().getFullYear()">2025</span> UMPAR
          <span class="text-[#f4d03f]">☀️</span>
          All rights reserved.
        </p>
        <div class="flex items-center gap-6 text-sm text-gray-500">
          <a href="#" class="hover:text-[#00a651] transition-colors">Privacy Policy</a>
          <a href="#" class="hover:text-[#4da8da] transition-colors">Terms of Service</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Create particles
      const particlesContainer = document.getElementById('particles');
      if (particlesContainer) {
        const colors = ['particle-green', 'particle-blue', 'particle-gold', 'particle-white'];
        for (let i = 0; i < 40; i++) {
          const particle = document.createElement('div');
          particle.className = `particle ${colors[Math.floor(Math.random() * colors.length)]}`;
          particle.style.left = Math.random() * 100 + '%';
          particle.style.animationDelay = Math.random() * 10 + 's';
          particle.style.animationDuration = (Math.random() * 5 + 8) + 's';
          particlesContainer.appendChild(particle);
        }
      }

      // Intersection Observer for reveal animations
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('active');
          }
        });
      }, observerOptions);

      // Observe all elements with reveal classes
      document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-rotate').forEach(el => {
        observer.observe(el);
      });

      // Smooth scroll for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });
    });
  </script>

</body>
</html>
