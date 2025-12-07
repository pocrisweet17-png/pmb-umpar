<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Login & Register - PMB UMPAR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Pendaftaran Mahasiswa Baru Universitas Muhammadiyah Parepare">
    <meta name="theme-color" content="#0ea5e9">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite('resources/css/app.css')

    <style>
        :root {
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-300: #93c5fd;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-800: #1e40af;
            --blue-900: #1e3a8a;
            --cyan-400: #22d3ee;
            --cyan-500: #06b6d4;
        }

        [x-cloak] { display: none !important; }

        * {
            font-family: 'Outfit', sans-serif;
        }

        .font-display {
            font-family: 'Syne', sans-serif;
        }

        /* =====================================================
           BACKGROUND - GANTI URL FOTO KAMPUS DI SINI
           ===================================================== */
        .campus-background {
            position: fixed;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .campus-background::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                rgba(30, 58, 138, 0.95) 0%,
                rgba(37, 99, 235, 0.9) 50%,
                rgba(6, 182, 212, 0.85) 100%);
        }

        /* =====================================================
           ANIMATED MESH GRADIENT BACKGROUND
           ===================================================== */
        .mesh-gradient {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(at 40% 20%, rgba(59, 130, 246, 0.4) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(6, 182, 212, 0.3) 0px, transparent 50%),
                radial-gradient(at 0% 50%, rgba(37, 99, 235, 0.4) 0px, transparent 50%),
                radial-gradient(at 80% 50%, rgba(34, 211, 238, 0.3) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(30, 64, 175, 0.4) 0px, transparent 50%),
                radial-gradient(at 80% 100%, rgba(59, 130, 246, 0.3) 0px, transparent 50%),
                radial-gradient(at 0% 0%, rgba(6, 182, 212, 0.3) 0px, transparent 50%);
            animation: meshMove 20s ease-in-out infinite;
        }

        @keyframes meshMove {
            0%, 100% { filter: hue-rotate(0deg); transform: scale(1); }
            50% { filter: hue-rotate(30deg); transform: scale(1.1); }
        }

        /* =====================================================
           FLOATING ORB ANIMATIONS
           ===================================================== */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.6;
            animation: orbFloat 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, var(--blue-500), var(--cyan-400));
            top: -10%;
            left: -5%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, var(--cyan-500), var(--blue-400));
            top: 60%;
            right: -10%;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, var(--blue-600), var(--blue-400));
            bottom: -10%;
            left: 30%;
            animation-delay: -10s;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(50px, -50px) rotate(90deg) scale(1.1); }
            50% { transform: translate(0, -100px) rotate(180deg) scale(1); }
            75% { transform: translate(-50px, -50px) rotate(270deg) scale(0.9); }
        }

        /* =====================================================
           ANIMATED GRID LINES
           ===================================================== */
        .grid-lines {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: perspective(500px) rotateX(60deg) translateY(0); }
            100% { transform: perspective(500px) rotateX(60deg) translateY(50px); }
        }

        /* =====================================================
           PARTICLE SYSTEM
           ===================================================== */
        .particles {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 10px;
            height: 20px;
            background: white;
            border-radius: 50%;
            opacity: 0;
            animation: particleRise 8s ease-in-out infinite;
        }

        @keyframes particleRise {
            0% {
                opacity: 0;
                transform: translateY(100vh) scale(0);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) scale(1);
            }
        }

        /* =====================================================
           GLOWING CARD EFFECT
           ===================================================== */
        .card-glow {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .card-glow::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg,
                transparent 30%,
                rgba(59, 130, 246, 0.5) 50%,
                transparent 70%);
            animation: borderGlow 3s linear infinite;
            z-index: -1;
        }

        @keyframes borderGlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .card-inner {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        /* =====================================================
           ANIMATED TEXT GRADIENT
           ===================================================== */
        .text-gradient-animate {
            background: linear-gradient(90deg,
                var(--blue-400),
                var(--cyan-400),
                var(--blue-500),
                var(--cyan-400),
                var(--blue-400));
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: textShine 3s linear infinite;
        }

        @keyframes textShine {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* =====================================================
           3D TILT CARD EFFECT
           ===================================================== */
        .tilt-card {
            transform-style: preserve-3d;
            transition: transform 0.5s ease;
        }

        .tilt-card:hover {
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg) scale(1.02);
        }

        /* =====================================================
           NEON BUTTON EFFECTS
           ===================================================== */
        .btn-neon {
            position: relative;
            background: linear-gradient(135deg, var(--blue-600), var(--blue-500));
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow:
                0 0 20px rgba(59, 130, 246, 0.3),
                0 0 40px rgba(59, 130, 246, 0.1);
        }

        .btn-neon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(255,255,255,0.4),
                transparent);
            transition: left 0.5s ease;
        }

        .btn-neon:hover::before {
            left: 100%;
        }

        .btn-neon:hover {
            transform: translateY(-3px);
            box-shadow:
                0 0 30px rgba(59, 130, 246, 0.5),
                0 0 60px rgba(59, 130, 246, 0.3),
                0 10px 40px rgba(59, 130, 246, 0.4);
        }

        .btn-neon-cyan {
            background: linear-gradient(135deg, var(--cyan-500), var(--blue-500));
            box-shadow:
                0 0 20px rgba(6, 182, 212, 0.3),
                0 0 40px rgba(6, 182, 212, 0.1);
        }

        .btn-neon-cyan:hover {
            box-shadow:
                0 0 30px rgba(6, 182, 212, 0.5),
                0 0 60px rgba(6, 182, 212, 0.3),
                0 10px 40px rgba(6, 182, 212, 0.4);
        }

        /* =====================================================
           INPUT CYBER STYLE
           ===================================================== */
        .input-cyber {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
            position: relative;
        }

        .input-cyber:focus {
            border-color: var(--blue-500);
            box-shadow:
                0 0 0 4px rgba(59, 130, 246, 0.1),
                0 0 20px rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
        }

        .input-group::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--blue-500), var(--cyan-400));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .input-group:focus-within::after {
            width: 100%;
        }

        /* =====================================================
           TAB ANIMATIONS
           ===================================================== */
        .tab-container {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .tab-indicator {
            position: absolute;
            height: calc(100% - 8px);
            top: 4px;
            background: white;
            border-radius: 12px;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .tab-btn {
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            color: var(--blue-600);
        }

        /* =====================================================
           STAGGER ANIMATIONS
           ===================================================== */
        .animate-in {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s ease forwards;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }
        .delay-6 { animation-delay: 0.6s; }
        .delay-7 { animation-delay: 0.7s; }

        /* =====================================================
           FLOATING LABEL ANIMATION
           ===================================================== */
        .floating-label {
            position: absolute;
            left: 48px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .input-cyber:focus ~ .floating-label,
        .input-cyber:not(:placeholder-shown) ~ .floating-label {
            top: -10px;
            left: 12px;
            font-size: 12px;
            color: var(--blue-600);
            background: white;
            padding: 0 8px;
            font-weight: 500;
        }

        /* =====================================================
           ICON ANIMATIONS
           ===================================================== */
        .icon-bounce {
            animation: iconBounce 2s ease-in-out infinite;
        }

        @keyframes iconBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .icon-pulse {
            animation: iconPulse 2s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
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
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 20px;
            animation: logoRing 3s ease-in-out infinite;
        }

        .logo-ring-2 {
            animation-delay: 1s;
        }

        .logo-ring-3 {
            animation-delay: 2s;
        }

        @keyframes logoRing {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0; }
        }

        /* =====================================================
           WAVE ANIMATION
           ===================================================== */
        .wave-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70vh;
            overflow: hidden;
            z-index: 0;
        }

        .wave {
            position: absolute;
            bottom: 0;
            width: 200%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='rgba(255,255,255,0.1)' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
            animation: wave 20s linear infinite;
        }

        .wave-2 {
            opacity: 0.5;
            animation-delay: -10s;
            animation-duration: 20s;
        }

        @keyframes wave {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* =====================================================
           TYPEWRITER EFFECT
           ===================================================== */
        .typewriter {
            overflow: hidden;
            white-space: nowrap;
            animation: typing 3s steps(30, end) infinite alternate;
        }

        @keyframes typing {
            0% { width: 0; }
            100% { width: 100%; }
        }

        /* =====================================================
           GLITCH TEXT EFFECT
           ===================================================== */
        .glitch {
            position: relative;
        }

        .glitch::before,
        .glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .glitch::before {
            animation: glitch-1 2s infinite linear alternate-reverse;
            clip-path: polygon(0 0, 100% 0, 100% 35%, 0 35%);
            -webkit-text-fill-color: var(--cyan-400);
        }

        .glitch::after {
            animation: glitch-2 3s infinite linear alternate-reverse;
            clip-path: polygon(0 65%, 100% 65%, 100% 100%, 0 100%);
            -webkit-text-fill-color: var(--blue-400);
        }

        @keyframes glitch-1 {
            0% { transform: translateX(0); }
            20% { transform: translateX(-2px); }
            40% { transform: translateX(2px); }
            60% { transform: translateX(-1px); }
            80% { transform: translateX(1px); }
            100% { transform: translateX(0); }
        }

        @keyframes glitch-2 {
            0% { transform: translateX(0); }
            20% { transform: translateX(2px); }
            40% { transform: translateX(-2px); }
            60% { transform: translateX(1px); }
            80% { transform: translateX(-1px); }
            100% { transform: translateX(0); }
        }

        /* =====================================================
           RESPONSIVE
           ===================================================== */
        @media (max-width: 1024px) {
            .orb { opacity: 0.4; }
        }

        @media (max-width: 640px) {
            .orb-1 { width: 250px; height: 250px; }
            .orb-2 { width: 200px; height: 200px; }
            .orb-3 { width: 180px; height: 180px; }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--blue-500), var(--cyan-500));
            border-radius: 4px;
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden">
    <!-- Background Layer -->
    <div class="campus-background"></div>

    <!-- Mesh Gradient -->
    <div class="mesh-gradient"></div>

    <!-- Grid Lines -->
    <div class="grid-lines opacity-30"></div>

    <!-- Floating Orbs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <!-- Particles -->
    <div class="particles">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const particlesContainer = document.querySelector('.particles');
                for (let i = 0; i < 50; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDelay = Math.random() * 8 + 's';
                    particle.style.animationDuration = (Math.random() * 4 + 6) + 's';
                    particlesContainer.appendChild(particle);
                }
            });
        </script>
    </div>

    <!-- Waves -->
    <div class="wave-container">
        <div class="wave"></div>
        <div class="wave wave-2"></div>
    </div>

    <!-- Main Content -->
    <div class="relative min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 z-10">
        <div class="w-full max-w-5xl mx-auto">

            <!-- Header -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="animate-in delay-1">
                    <div class="logo-container inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white/90 backdrop-blur-xl shadow-2xl mb-5 relative">
                        <div class="logo-ring"></div>
                        <div class="logo-ring logo-ring-2"></div>
                        <div class="logo-ring logo-ring-3"></div>
                        <!-- GANTI DENGAN LOGO KAMPUS -->
                        <span class="font-display text-2xl sm:text-3xl text-gradient-animate">UM</span>
                    </div>
                </div>

                <h1 class="animate-in delay-2 font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 drop-shadow-2xl">
                    <span class="glitch" data-text="PMB UMPAR">PMB UMPAR</span>
                </h1>

                <p class="animate-in delay-3 text-blue-100 text-base sm:text-lg max-w-md mx-auto font-light">
                    Portal Pendaftaran Mahasiswa Baru<br>
                    <span class="text-cyan-300 font-medium">Universitas Muhammadiyah Parepare</span>
                </p>

                <!-- Animated Badge -->
                <div class="animate-in delay-4 mt-4">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-sm text-white border border-white/20">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Pendaftaran Dibuka - TA 2025/2026
                    </span>
                </div>
            </div>

            <!-- Main Card -->
            <div class="animate-in delay-5 card-glow rounded-3xl p-1 tilt-card">
                <div class="card-inner rounded-[22px] overflow-hidden">
                    <div class="flex flex-col lg:flex-row">

                        <!-- Left Side - Info Panel -->
                        <div class="hidden lg:flex flex-col w-2/5 bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-600 p-10 text-white relative overflow-hidden">
                            <!-- Decorative Elements -->
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                            <div class="absolute top-1/2 left-1/2 w-32 h-32 bg-cyan-400/10 rounded-full -translate-x-1/2 -translate-y-1/2 animate-pulse"></div>

                            <div class="relative z-10 flex flex-col h-full">
                                <div class="mb-auto">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-full text-xs font-medium mb-6 backdrop-blur-sm border border-white/10">
                                        <svg class="w-4 h-4 icon-bounce" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Tahun Akademik 2025/2026
                                    </span>

                                    <h2 class="text-2xl xl:text-3xl font-bold mb-4 leading-tight">
                                        Wujudkan<br>
                                        <span class="text-cyan-300">Mimpimu</span><br>
                                        Bersama Kami
                                    </h2>

                                    <p class="text-blue-100/80 text-sm leading-relaxed mb-8">
                                        Bergabung dengan ribuan mahasiswa yang telah memilih UMPAR sebagai tempat meraih cita-cita dan masa depan yang gemilang.
                                    </p>
                                </div>

                                <!-- Features -->
                                <div class="space-y-4 mb-8">
                                    <div class="flex items-center gap-4 group cursor-pointer">
                                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 group-hover:scale-110 transition-all duration-300 border border-white/10">
                                            <svg class="w-6 h-6 icon-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold">Akreditasi Unggul</h3>
                                            <p class="text-blue-200/70 text-xs">Kualitas terjamin BAN-PT</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 group cursor-pointer">
                                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 group-hover:scale-110 transition-all duration-300 border border-white/10">
                                            <svg class="w-6 h-6 icon-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation-delay: 0.5s;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold">20+ Program Studi</h3>
                                            <p class="text-blue-200/70 text-xs">Pilihan sesuai passion</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 group cursor-pointer">
                                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 group-hover:scale-110 transition-all duration-300 border border-white/10">
                                            <svg class="w-6 h-6 icon-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation-delay: 1s;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold">100% Online</h3>
                                            <p class="text-blue-200/70 text-xs">Daftar dari mana saja</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-cyan-300">5K+</div>
                                        <div class="text-xs text-blue-200/70">Mahasiswa</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-cyan-300">150+</div>
                                        <div class="text-xs text-blue-200/70">Dosen</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-cyan-300">35+</div>
                                        <div class="text-xs text-blue-200/70">Tahun</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Forms -->
                        <div class="flex-1 p-6 sm:p-8 lg:p-10">
                            <!-- Tab Switcher -->
                            <div class="tab-container rounded-2xl p-1 mb-8">
                                <div id="tab-indicator" class="tab-indicator w-[calc(50%-4px)] left-1"></div>
                                <div class="flex relative">
                                    <button id="login-tab" class="tab-btn active flex-1 py-3 sm:py-4 px-6 rounded-xl font-semibold text-sm transition-all duration-300" onclick="showLogin()">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                            </svg>
                                            Masuk
                                        </span>
                                    </button>
                                    <button id="register-tab" class="tab-btn flex-1 py-3 sm:py-4 px-6 rounded-xl font-semibold text-sm text-gray-500 transition-all duration-300" onclick="showRegister()">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                            </svg>
                                            Daftar
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Login Form -->
                            <div id="loginForm" class="space-y-6">
                                <div class="text-center lg:text-left animate-in delay-1">
                                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                                        Selamat Datang! 👋
                                    </h2>
                                    <p class="text-gray-500">Masuk untuk melanjutkan pendaftaran</p>
                                </div>

                                <!-- Alerts -->
                                @if(session('success'))
                                    <div class="animate-in delay-2 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 text-sm flex items-center gap-3">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="animate-in delay-2 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-700 text-sm flex items-center gap-3">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="animate-in delay-2 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-700 text-sm">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('login.process') }}" method="POST" class="space-y-5" x-data="{ loading: false, showPassword: false }" @submit="loading = true">
                                    @csrf

                                    <div class="animate-in delay-2 input-group">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <input type="text" name="login" required placeholder=" "
                                                class="input-cyber block w-full pl-12 pr-4 py-4 rounded-xl text-gray-900 placeholder-transparent focus:outline-none">
                                            <label class="floating-label">Username atau Email</label>
                                        </div>
                                    </div>

                                    <div class="animate-in delay-3 input-group">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                            <input :type="showPassword ? 'text' : 'password'" name="password" required placeholder=" "
                                                class="input-cyber block w-full pl-12 pr-12 py-4 rounded-xl text-gray-900 placeholder-transparent focus:outline-none">
                                            <label class="floating-label">Password</label>
                                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-500 transition-colors">
                                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="animate-in delay-4 flex items-center justify-between">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="checkbox" name="remember" class="w-5 h-5 rounded border-2 border-blue-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                                            <span class="text-sm text-gray-600 group-hover:text-blue-600 transition-colors">Ingat saya</span>
                                        </label>
                                        <a href="#" class="text-sm text-blue-600 hover:text-cyan-500 font-medium transition-colors">Lupa password?</a>
                                    </div>

                                    <div class="animate-in delay-5 pt-2">
                                        <button type="submit"
                                            class="btn-neon w-full py-4 px-6 rounded-xl text-white font-semibold text-sm flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                                            :disabled="loading">
                                            <svg x-show="loading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span x-show="!loading">Masuk ke Akun</span>
                                            <span x-show="loading">Memproses...</span>
                                            <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>

                                <!-- Mobile Info -->
                                <div class="lg:hidden animate-in delay-6 pt-6 border-t border-gray-100 text-center">
                                    <p class="text-sm text-gray-500">Belum punya akun? <button onclick="showRegister()" class="text-blue-600 font-semibold hover:text-cyan-500 transition-colors">Daftar sekarang</button></p>
                                </div>
                            </div>

                            <!-- Register Form -->
                            <div id="registerForm" class="hidden space-y-6">
                                <div class="text-center lg:text-left animate-in delay-1">
                                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                                        Buat Akun Baru 🎓
                                    </h2>
                                    <p class="text-gray-500">Lengkapi data untuk memulai pendaftaran</p>
                                </div>

                                <form action="{{ route('register') }}" method="POST" class="space-y-4" x-data="{ loading: false, showPassword: false, showConfirm: false, password: '', confirm: '' }" @submit="loading = true">
                                    @csrf

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="sm:col-span-2 animate-in delay-1 input-group">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-cyan-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <input type="text" name="nama_lengkap" required placeholder=" "
                                                    class="input-cyber block w-full pl-12 pr-4 py-3.5 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:border-cyan-500">
                                                <label class="floating-label">Nama Lengkap (sesuai KTP)</label>
                                            </div>
                                        </div>

                                        <div class="animate-in delay-2 input-group">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-cyan-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                                    </svg>
                                                </div>
                                                <input type="text" name="nik" required maxlength="16" pattern="[0-9]{16}" placeholder=" "
                                                    class="input-cyber block w-full pl-12 pr-4 py-3.5 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:border-cyan-500">
                                                <label class="floating-label">NIK (16 digit)</label>
                                            </div>
                                        </div>

                                        <div class="animate-in delay-2 input-group">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-cyan-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <input type="text" name="username" required placeholder=" "
                                                    class="input-cyber block w-full pl-12 pr-4 py-3.5 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:border-cyan-500">
                                                <label class="floating-label">Username</label>
                                            </div>
                                        </div>

                                        <div class="animate-in delay-3 input-group">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-cyan-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <input type="email" name="email" required placeholder=" "
                                                    class="input-cyber block w-full pl-12 pr-4 py-3.5 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:border-cyan-500">
                                                <label class="floating-label">Email Aktif</label>
                                            </div>
                                        </div>

                                        <div class="animate-in delay-3 input-group">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-cyan-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                    </svg>
                                                </div>
                                                <input type="text" name="no_whatsapp" required placeholder=" "
                                                    class="input-cyber block w-full pl-12 pr-4 py-3.5 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:border-cyan-500">
                                                <label class="floating-label">No. WhatsApp</label>
                                            </div>
                                        </div>

                                        <div class="animate-in delay-4 input-group">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-cyan-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                </div>
                                                <input :type="showPassword ? 'text' : 'password'" name="password" required x-model="password" placeholder=" "
                                                    class="input-cyber block w-full pl-12 pr-12 py-3.5 rounded-xl text-gray-900 placeholder-transparent focus:outline-none focus:border-cyan-500">
                                                <label class="floating-label">Password</label>
                                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-cyan-500 transition-colors">
                                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="animate-in delay-4 input-group">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-cyan-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                </div>
                                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required x-model="confirm" placeholder=" "
                                                    class="input-cyber block w-full pl-12 pr-12 py-3.5 rounded-xl text-gray-900 placeholder-transparent focus:outline-none"
                                                    :class="confirm && password !== confirm ? 'border-red-400 focus:border-red-500' : 'focus:border-cyan-500'">
                                                <label class="floating-label">Konfirmasi Password</label>
                                                <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-cyan-500 transition-colors">
                                                    <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <svg x-show="showConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="mt-2 h-5">
                                                <p x-show="confirm && password !== confirm" x-cloak class="text-xs text-red-500 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Password tidak cocok
                                                </p>
                                                <p x-show="confirm && password === confirm" x-cloak class="text-xs text-green-500 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Password cocok!
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="animate-in delay-5 flex items-start gap-3 pt-2">
                                        <input id="terms" name="terms" type="checkbox" required
                                            class="mt-1 w-5 h-5 rounded border-2 border-cyan-300 text-cyan-600 focus:ring-cyan-500 cursor-pointer">
                                        <label for="terms" class="text-sm text-gray-600 cursor-pointer">
                                            Saya menyetujui <a href="#" class="text-blue-600 hover:text-cyan-500 font-medium underline underline-offset-2 transition-colors">syarat dan ketentuan</a> yang berlaku
                                        </label>
                                    </div>

                                    <div class="animate-in delay-6 pt-2">
                                        <button type="submit"
                                            class="btn-neon btn-neon-cyan w-full py-4 px-6 rounded-xl text-white font-semibold text-sm flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                                            :disabled="loading || (password !== confirm)">
                                            <svg x-show="loading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span x-show="!loading">Daftar Sekarang</span>
                                            <span x-show="loading">Mendaftarkan...</span>
                                            <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>

                                <!-- Mobile Info -->
                                <div class="lg:hidden animate-in delay-7 pt-6 border-t border-gray-100 text-center">
                                    <p class="text-sm text-gray-500">Sudah punya akun? <button onclick="showLogin()" class="text-cyan-600 font-semibold hover:text-blue-500 transition-colors">Masuk di sini</button></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 animate-in delay-6">
                <p class="text-blue-100/70 text-sm">&copy; {{ date('Y') }} Universitas Muhammadiyah Parepare. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function showLogin() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            const indicator = document.getElementById('tab-indicator');

            registerForm.classList.add('hidden');
            loginForm.classList.remove('hidden');

            loginTab.classList.add('active');
            loginTab.classList.remove('text-gray-500');
            registerTab.classList.remove('active');
            registerTab.classList.add('text-gray-500');

            indicator.style.left = '4px';

            triggerAnimations(loginForm);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showRegister() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            const indicator = document.getElementById('tab-indicator');

            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');

            registerTab.classList.add('active');
            registerTab.classList.remove('text-gray-500');
            loginTab.classList.remove('active');
            loginTab.classList.add('text-gray-500');

            indicator.style.left = 'calc(50% + 2px)';

            triggerAnimations(registerForm);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function triggerAnimations(container) {
            const elements = container.querySelectorAll('.animate-in');
            elements.forEach(el => {
                el.style.animation = 'none';
                el.offsetHeight;
                el.style.animation = null;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            showLogin();
        });
    </script>
</body>
</html>
