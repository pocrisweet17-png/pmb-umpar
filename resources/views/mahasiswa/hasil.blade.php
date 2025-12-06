<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Ujian - {{ $ujian->user->nama_lengkap }}</title>

    <!-- Tailwind CSS 4 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ============================================
           PRINT STYLES - OPTIMIZED, SECURE & COMPACT
           ============================================ */
        @media print {
            @page {
                size: A4;
                margin: 8mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                font-size: 10pt !important;
            }

            @page {
                margin-top: 8mm;
                margin-bottom: 8mm;
            }

            .no-print {
                display: none !important;
            }

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
                transform: none !important;
            }

            .max-w-4xl {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .print-area {
                box-shadow: none !important;
                border: 2px solid #000 !important;
                border-radius: 0 !important;
                overflow: visible !important;
                page-break-inside: avoid !important;
            }

            .print-header {
                padding: 12px !important;
                page-break-after: avoid !important;
                background: #10b981 !important;
            }

            .print-header.red-header {
                background: #ef4444 !important;
            }

            .print-content {
                padding: 12px !important;
                background: white !important;
            }

            .shadow-2xl,
            .shadow-xl,
            .shadow-lg,
            .shadow-md,
            .shadow-sm,
            .shadow {
                box-shadow: none !important;
            }

            .rounded-3xl,
            .rounded-2xl,
            .rounded-xl,
            .rounded-lg,
            .rounded-full {
                border-radius: 4px !important;
            }

            .grid {
                page-break-inside: avoid !important;
            }

            h1 {
                font-size: 20pt !important;
                margin-bottom: 8px !important;
            }

            h3 {
                font-size: 11pt !important;
            }

            .mb-8 { margin-bottom: 12px !important; }
            .mb-6 { margin-bottom: 10px !important; }
            .mb-4 { margin-bottom: 8px !important; }
            .p-8 { padding: 12px !important; }
            .p-6 { padding: 10px !important; }
            .p-4 { padding: 8px !important; }
            .p-3 { padding: 6px !important; }

            .w-20, .h-20 { width: 40px !important; height: 40px !important; }
            .w-16, .h-16 { width: 32px !important; height: 32px !important; }
            .w-12, .h-12 { width: 24px !important; height: 24px !important; }
            .w-10, .h-10 { width: 20px !important; height: 20px !important; }
            .w-40, .h-40 { width: 80px !important; height: 80px !important; }
            .w-32, .h-32 { width: 64px !important; height: 64px !important; }

            .text-6xl { font-size: 2rem !important; }
            .text-5xl { font-size: 1.5rem !important; }
            .text-3xl { font-size: 1.2rem !important; }
            .text-2xl { font-size: 1rem !important; }
            .text-xl { font-size: 0.9rem !important; }

            .gap-4 { gap: 8px !important; }
            .gap-3 { gap: 6px !important; }
        }

        /* ============================================
           SCREEN ANIMATIONS & EFFECTS
           ============================================ */
        @media screen {
            /* Animated gradient background */
            .bg-gradient-animated {
                background: linear-gradient(-45deg, #0f172a, #1e3a5f, #312e81, #4c1d95, #1e3a5f);
                background-size: 400% 400%;
                animation: gradientShift 20s ease infinite;
            }

            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Floating particles */
            .particles {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                overflow: hidden;
                z-index: 0;
            }

            .particle {
                position: absolute;
                width: 10px;
                height: 10px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                animation: float 15s infinite;
            }

            .particle:nth-child(1) { left: 10%; animation-delay: 0s; animation-duration: 20s; }
            .particle:nth-child(2) { left: 20%; animation-delay: 2s; animation-duration: 25s; }
            .particle:nth-child(3) { left: 30%; animation-delay: 4s; animation-duration: 18s; }
            .particle:nth-child(4) { left: 40%; animation-delay: 1s; animation-duration: 22s; }
            .particle:nth-child(5) { left: 50%; animation-delay: 3s; animation-duration: 19s; }
            .particle:nth-child(6) { left: 60%; animation-delay: 5s; animation-duration: 21s; }
            .particle:nth-child(7) { left: 70%; animation-delay: 0.5s; animation-duration: 24s; }
            .particle:nth-child(8) { left: 80%; animation-delay: 2.5s; animation-duration: 17s; }
            .particle:nth-child(9) { left: 90%; animation-delay: 4.5s; animation-duration: 23s; }

            @keyframes float {
                0% {
                    transform: translateY(100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                90% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100vh) rotate(720deg);
                    opacity: 0;
                }
            }

            /* Slide animations */
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-50px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-slideDown {
                animation: slideDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.5);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .animate-scaleIn {
                animation: scaleIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fadeInUp {
                animation: fadeInUp 0.6s ease-out forwards;
                opacity: 0;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.8; transform: scale(1.05); }
            }

            .animate-pulse-slow {
                animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes bounce {
                0%, 100% {
                    transform: translateY(-10%);
                    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
                }
                50% {
                    transform: translateY(0);
                    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
                }
            }

            .animate-bounce-slow {
                animation: bounce 2s infinite;
            }

            /* Shimmer effect */
            @keyframes shimmer {
                0% { background-position: -200% center; }
                100% { background-position: 200% center; }
            }

            .shimmer {
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                background-size: 200% 100%;
                animation: shimmer 3s infinite;
            }

            /* Glow effect */
            @keyframes glow {
                0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.5); }
                50% { box-shadow: 0 0 40px rgba(16, 185, 129, 0.8), 0 0 60px rgba(16, 185, 129, 0.4); }
            }

            .glow-green {
                animation: glow 2s ease-in-out infinite;
            }

            @keyframes glowRed {
                0%, 100% { box-shadow: 0 0 20px rgba(239, 68, 68, 0.5); }
                50% { box-shadow: 0 0 40px rgba(239, 68, 68, 0.8), 0 0 60px rgba(239, 68, 68, 0.4); }
            }

            .glow-red {
                animation: glowRed 2s ease-in-out infinite;
            }

            /* Number counter animation */
            @keyframes countUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .count-up {
                animation: countUp 1s ease-out forwards;
            }

            /* Confetti animation for LULUS */
            @keyframes confetti-fall {
                0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
                100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
            }

            .confetti {
                position: fixed;
                width: 10px;
                height: 10px;
                top: -10px;
                z-index: 1000;
                animation: confetti-fall 4s linear forwards;
            }

            /* Animation delays */
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
            .delay-400 { animation-delay: 0.4s; }
            .delay-500 { animation-delay: 0.5s; }
            .delay-600 { animation-delay: 0.6s; }

            /* Glassmorphism */
            .glass {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }

            .glass-dark {
                background: rgba(15, 23, 42, 0.8);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }

            /* Card hover effects */
            .stat-card {
                transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .stat-card:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            /* Score circle effects */
            .score-circle {
                position: relative;
            }

            .score-circle::before {
                content: '';
                position: absolute;
                inset: -15px;
                border-radius: 50%;
                opacity: 0.4;
                filter: blur(25px);
                z-index: -1;
            }

            .score-circle.green::before {
                background: linear-gradient(135deg, #10b981, #34d399);
                animation: pulse 2.5s ease-in-out infinite;
            }

            .score-circle.red::before {
                background: linear-gradient(135deg, #ef4444, #f87171);
                animation: pulse 2.5s ease-in-out infinite;
            }

            /* Rotating border */
            @keyframes rotate-border {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .rotating-border {
                position: relative;
            }

            .rotating-border::before {
                content: '';
                position: absolute;
                inset: -3px;
                border-radius: inherit;
                padding: 3px;
                background: conic-gradient(from 0deg, #10b981, #3b82f6, #8b5cf6, #ec4899, #10b981);
                -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                -webkit-mask-composite: xor;
                mask-composite: exclude;
                animation: rotate-border 4s linear infinite;
            }

            /* Button ripple effect */
            .btn-ripple {
                position: relative;
                overflow: hidden;
            }

            .btn-ripple::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: width 0.6s, height 0.6s;
            }

            .btn-ripple:hover::after {
                width: 300px;
                height: 300px;
            }

            /* Text gradient animation */
            @keyframes text-gradient {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }

            .text-gradient-animated {
                background: linear-gradient(90deg, #ffffff, #a5f3fc, #ffffff);
                background-size: 200% auto;
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: text-gradient 3s ease infinite;
            }

            /* Progress bar animation */
            @keyframes progress-fill {
                from { width: 0%; }
            }

            .progress-animated {
                animation: progress-fill 1.5s ease-out forwards;
            }

            /* Icon spin on hover */
            .icon-hover-spin:hover svg {
                animation: spin 0.5s ease-in-out;
            }

            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /* Typing effect for congratulations */
            @keyframes typing {
                from { width: 0; }
                to { width: 100%; }
            }

            @keyframes blink-caret {
                from, to { border-color: transparent; }
                50% { border-color: white; }
            }
        }

        /* Print overlay */
        .print-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .print-overlay.active {
            display: flex;
        }

        @keyframes spin-loader {
            to { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin-loader 1s linear infinite;
        }

        @media print {
            .print-overlay {
                display: none !important;
            }

            .bg-gradient-animated {
                background: white !important;
            }

            .particles {
                display: none !important;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #10b981, #3b82f6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #059669, #2563eb);
        }
    </style>
</head>
<body class="bg-gradient-animated min-h-screen">

    <!-- Floating Particles Background -->
    <div class="particles no-print">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Confetti Container (for LULUS) -->
    @if($lulus)
    <div id="confettiContainer" class="no-print"></div>
    @endif

    <!-- Print Overlay -->
    <div class="print-overlay" id="printOverlay">
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-emerald-400 mb-6"></div>
            <p class="text-white text-3xl font-bold mb-2">Mempersiapkan PDF...</p>
            <p class="text-gray-400 text-lg">Mohon tunggu sebentar</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-6 md:py-12 relative z-10">

        <!-- University Logo/Header -->
        <div class="text-center mb-6 md:mb-8 animate-fadeInUp no-print">
            <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/10 backdrop-blur-xl mb-4 rotating-border">
                <img src="/img/umpar.png" alt="">
            </div>
            <h2 class="text-white/90 text-lg md:text-xl font-semibold tracking-wide">UNIVERSITAS MUHAMMADIYAH PAREPARE</h2>
            <p class="text-white/60 text-sm mt-1">Sistem Ujian Online</p>
        </div>

        <!-- Result Card -->
        <div class="print-area glass rounded-3xl shadow-2xl overflow-hidden border-4 {{ $lulus ? 'border-emerald-400 glow-green' : 'border-red-400 glow-red' }} animate-slideDown">

            <!-- Header -->
            <div class="print-header {{ $lulus ? '' : 'red-header' }} relative bg-gradient-to-r {{ $lulus ? 'from-emerald-500 via-green-500 to-teal-500' : 'from-red-500 via-rose-500 to-pink-500' }} p-6 md:p-10 text-white text-center overflow-hidden">

                <!-- Animated background shapes -->
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2 animate-pulse-slow"></div>
                    <div class="absolute bottom-0 right-0 w-72 h-72 bg-white/10 rounded-full translate-x-1/2 translate-y-1/2 animate-pulse-slow" style="animation-delay: 1s;"></div>
                    <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2 animate-pulse-slow" style="animation-delay: 0.5s;"></div>
                </div>

                <div class="relative">
                    <!-- Icon with animation -->
                    <div class="relative inline-flex items-center justify-center w-20 h-20 md:w-28 md:h-28 rounded-full bg-white/20 mb-4 md:mb-6 animate-bounce-slow shadow-2xl backdrop-blur-sm">
                        <div class="absolute inset-0 rounded-full bg-white/10 animate-ping"></div>
                        @if($lulus)
                            <svg class="w-10 h-10 md:w-16 md:h-16 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-10 h-10 md:w-16 md:h-16 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl md:text-5xl font-black mb-4 md:mb-6 drop-shadow-lg text-gradient-animated">
                        HASIL UJIAN ANDA
                    </h1>

                    <!-- Status Badge with shimmer -->
                    @if($lulus)
                        <div class="relative inline-block">
                            <div class="absolute inset-0 bg-white rounded-full blur-xl opacity-50 animate-pulse"></div>
                            <div class="relative bg-white text-emerald-600 px-8 md:px-12 py-3 md:py-4 rounded-full font-black text-xl md:text-2xl shadow-2xl transform hover:scale-110 transition-all duration-300 cursor-default">
                                <span class="shimmer absolute inset-0 rounded-full"></span>
                                <span class="relative">✓ LULUS</span>
                            </div>
                        </div>
                    @else
                        <div class="relative inline-block">
                            <div class="absolute inset-0 bg-white rounded-full blur-xl opacity-50 animate-pulse"></div>
                            <div class="relative bg-white text-red-600 px-8 md:px-12 py-3 md:py-4 rounded-full font-black text-xl md:text-2xl shadow-2xl transform hover:scale-110 transition-all duration-300 cursor-default">
                                <span class="relative">✗ TIDAK LULUS</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="print-content p-6 md:p-10 bg-gradient-to-b from-slate-50 to-white">

                <!-- Nilai Utama -->
                <div class="text-center mb-10 md:mb-14 animate-scaleIn">
                    <p class="text-slate-500 mb-4 text-sm md:text-base font-bold uppercase tracking-widest">Nilai Akhir Anda</p>

                    <div class="score-circle {{ $lulus ? 'green' : 'red' }} inline-flex items-center justify-center w-36 h-36 md:w-48 md:h-48 rounded-full {{ $lulus ? 'bg-gradient-to-br from-emerald-400 via-green-500 to-teal-500' : 'bg-gradient-to-br from-red-400 via-rose-500 to-pink-500' }} mb-4 shadow-2xl">
                        <div class="w-28 h-28 md:w-40 md:h-40 rounded-full bg-white flex items-center justify-center shadow-inner relative overflow-hidden">
                            <!-- Shimmer effect on score -->
                            <div class="absolute inset-0 shimmer opacity-30"></div>
                            <span class="text-5xl md:text-7xl font-black {{ $lulus ? 'text-emerald-600' : 'text-red-600' }} count-up relative z-10" id="scoreValue">
                                {{ number_format($ujian->nilaiAkhir, 0) }}
                            </span>
                        </div>
                    </div>

                    <p class="text-xl md:text-2xl text-slate-500 font-semibold">dari 100</p>

                    <!-- Passing score indicator -->
                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full {{ $lulus ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Nilai minimum kelulusan: 70
                    </div>
                </div>

                <!-- Statistik Detail -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-10">

                    <!-- Jawaban Benar -->
                    <div class="stat-card glass rounded-2xl p-5 md:p-6 border-2 border-emerald-200 animate-fadeInUp delay-100 icon-hover-spin">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-400 to-green-500 rounded-2xl flex items-center justify-center shadow-lg transform -rotate-6 hover:rotate-0 transition-transform">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-4xl md:text-5xl font-black text-emerald-600">{{ $ujian->jumlahBenar }}</span>
                        </div>
                        <p class="text-slate-700 font-bold text-sm md:text-base mb-3">Jawaban Benar</p>
                        <div class="bg-emerald-100 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-green-400 h-3 rounded-full progress-animated" style="width: {{ ($ujian->jumlahBenar / ($ujian->jumlahBenar + $ujian->jumlahSalah)) * 100 }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">{{ number_format(($ujian->jumlahBenar / ($ujian->jumlahBenar + $ujian->jumlahSalah)) * 100, 1) }}% dari total</p>
                    </div>

                    <!-- Jawaban Salah -->
                    <div class="stat-card glass rounded-2xl p-5 md:p-6 border-2 border-red-200 animate-fadeInUp delay-200 icon-hover-spin">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-red-400 to-rose-500 rounded-2xl flex items-center justify-center shadow-lg transform rotate-6 hover:rotate-0 transition-transform">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <span class="text-4xl md:text-5xl font-black text-red-600">{{ $ujian->jumlahSalah }}</span>
                        </div>
                        <p class="text-slate-700 font-bold text-sm md:text-base mb-3">Jawaban Salah</p>
                        <div class="bg-red-100 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-500 to-rose-400 h-3 rounded-full progress-animated" style="width: {{ ($ujian->jumlahSalah / ($ujian->jumlahBenar + $ujian->jumlahSalah)) * 100 }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">{{ number_format(($ujian->jumlahSalah / ($ujian->jumlahBenar + $ujian->jumlahSalah)) * 100, 1) }}% dari total</p>
                    </div>

                    <!-- Total Soal -->
                    <div class="stat-card glass rounded-2xl p-5 md:p-6 border-2 border-blue-200 animate-fadeInUp delay-300 icon-hover-spin">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-4xl md:text-5xl font-black text-blue-600">{{ $ujian->jumlahBenar + $ujian->jumlahSalah }}</span>
                        </div>
                        <p class="text-slate-700 font-bold text-sm md:text-base mb-3">Total Soal</p>
                        <div class="bg-blue-100 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-400 h-3 rounded-full progress-animated" style="width: 100%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Semua soal terjawab</p>
                    </div>

                </div>

                <!-- Info Peserta -->
                <div class="{{ $lulus ? 'bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 border-emerald-200' : 'bg-gradient-to-br from-red-50 via-rose-50 to-pink-50 border-red-200' }} border-2 rounded-3xl p-6 md:p-8 mb-8 md:mb-10 shadow-lg animate-fadeInUp delay-400">
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br {{ $lulus ? 'from-emerald-500 to-teal-600' : 'from-red-500 to-rose-600' }} rounded-xl flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        Informasi Peserta
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="glass rounded-xl p-4 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/50">
                            <p class="text-xs text-slate-500 mb-1.5 font-semibold uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nama Lengkap
                            </p>
                            <p class="font-bold text-slate-900 text-base md:text-lg">{{ $ujian->user->nama_lengkap }}</p>
                        </div>
                        <div class="glass rounded-xl p-4 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/50">
                            <p class="text-xs text-slate-500 mb-1.5 font-semibold uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                                NIK
                            </p>
                            <p class="font-bold text-slate-900 text-base md:text-lg font-mono">{{ $ujian->user->nik }}</p>
                        </div>
                        <div class="glass rounded-xl p-4 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/50">
                            <p class="text-xs text-slate-500 mb-1.5 font-semibold uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Waktu Mulai
                            </p>
                            <p class="font-bold text-slate-900 text-sm md:text-base">{{ $ujian->waktuMulai->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <div class="glass rounded-xl p-4 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/50">
                            <p class="text-xs text-slate-500 mb-1.5 font-semibold uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Waktu Selesai
                            </p>
                            <p class="font-bold text-slate-900 text-sm md:text-base">{{ $ujian->waktuSelesai->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <div class="glass rounded-xl p-4 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/50">
                            <p class="text-xs text-slate-500 mb-1.5 font-semibold uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Durasi Pengerjaan
                            </p>
                            <p class="font-bold text-slate-900 text-base md:text-lg">{{ $ujian->waktuMulai->diffInMinutes($ujian->waktuSelesai) }} menit</p>
                        </div>
                        <div class="glass rounded-xl p-4 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/50">
                            <p class="text-xs text-slate-500 mb-1.5 font-semibold uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Peringkat
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="font-black text-transparent bg-clip-text bg-gradient-to-r {{ $lulus ? 'from-emerald-600 to-teal-600' : 'from-red-600 to-rose-600' }} text-2xl md:text-3xl">#{{ $ranking }}</span>
                                @if($ranking <= 3)
                                    <span class="text-2xl">🏆</span>
                                @elseif($ranking <= 10)
                                    <span class="text-2xl">⭐</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Kelulusan Banner -->
                @if($lulus)
                    <div class="relative bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500 rounded-3xl p-8 md:p-10 text-white text-center mb-8 shadow-2xl animate-scaleIn overflow-hidden">
                        <!-- Animated background -->
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-white/10 rounded-full animate-pulse-slow"></div>
                            <div class="absolute -bottom-1/2 -right-1/2 w-full h-full bg-white/10 rounded-full animate-pulse-slow" style="animation-delay: 1s;"></div>
                        </div>

                        <div class="relative">
                            <div class="inline-block mb-6">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-white rounded-full blur-2xl opacity-40 animate-pulse scale-150"></div>
                                    <svg class="w-20 h-20 md:w-24 md:h-24 relative mx-auto drop-shadow-2xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-3xl md:text-4xl font-black mb-3 drop-shadow-lg">🎉 SELAMAT! 🎉</h3>
                            <p class="text-xl md:text-2xl mb-3 font-bold">Anda Dinyatakan LULUS Ujian Seleksi</p>
                            <p class="text-base md:text-lg text-emerald-100 max-w-lg mx-auto">Anda telah memenuhi syarat untuk melanjutkan ke tahap selanjutnya dalam proses seleksi</p>

                            <!-- Decorative badges -->
                            <div class="flex justify-center gap-3 mt-6">
                                <span class="px-4 py-2 bg-white/20 rounded-full text-sm font-semibold backdrop-blur-sm">✓ Nilai Tercapai</span>
                                <span class="px-4 py-2 bg-white/20 rounded-full text-sm font-semibold backdrop-blur-sm">✓ Syarat Terpenuhi</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="relative bg-gradient-to-r from-red-500 via-rose-500 to-pink-500 rounded-3xl p-8 md:p-10 text-white text-center mb-8 shadow-2xl animate-scaleIn overflow-hidden">
                        <!-- Animated background -->
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-white/10 rounded-full animate-pulse-slow"></div>
                        </div>

                        <div class="relative">
                            <div class="inline-block mb-6">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-white rounded-full blur-2xl opacity-40 animate-pulse scale-150"></div>
                                    <svg class="w-20 h-20 md:w-24 md:h-24 relative mx-auto drop-shadow-2xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-3xl md:text-4xl font-black mb-3 drop-shadow-lg">BELUM LULUS</h3>
                            <p class="text-xl md:text-2xl mb-3 font-bold">Nilai Minimum Kelulusan Adalah 70</p>
                            <p class="text-base md:text-lg text-red-100 max-w-lg mx-auto">Jangan berkecil hati, terus tingkatkan kemampuan Anda. Silakan hubungi panitia untuk informasi lebih lanjut</p>

                            <!-- Encouragement message -->
                            <div class="mt-6 px-6 py-3 bg-white/10 rounded-2xl inline-block backdrop-blur-sm">
                                <p class="text-sm font-medium">💪 "Kegagalan adalah kesempatan untuk memulai lagi dengan lebih cerdas"</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="no-print flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('mahasiswa.dashboard') }}"
                       class="btn-ripple group flex-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white px-8 py-5 rounded-2xl font-bold text-center hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-xl hover:shadow-2xl flex items-center justify-center gap-3 text-base md:text-lg transform hover:scale-105 hover:-translate-y-1">
                        <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    <button onclick="printResult()"
                            class="btn-ripple group flex-1 bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 text-white px-8 py-5 rounded-2xl font-bold text-center hover:from-emerald-700 hover:via-green-700 hover:to-teal-700 transition-all duration-300 shadow-xl hover:shadow-2xl flex items-center justify-center gap-3 text-base md:text-lg transform hover:scale-105 hover:-translate-y-1">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak / Simpan PDF
                    </button>
                </div>

                <!-- Footer Note -->
                <div class="mt-8 text-center text-slate-500 text-sm animate-fadeInUp delay-600">
                    <p>Dokumen ini digenerate secara otomatis oleh sistem.</p>
                    <p class="mt-1">© {{ date('Y') }} Universitas Muhammadiyah Parepare - Sistem Ujian Online</p>
                </div>

            </div>
        </div>

        <!-- Watermark for print -->
        <div class="hidden print:block fixed bottom-4 right-4 text-gray-300 text-xs">
            Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB
        </div>

    </div>

    <script>
        // Print function with overlay
        function printResult() {
            const overlay = document.getElementById('printOverlay');
            overlay.classList.add('active');

            setTimeout(() => {
                overlay.classList.remove('active');
                window.print();
            }, 1500);
        }

        // Confetti animation for LULUS
        @if($lulus)
        document.addEventListener('DOMContentLoaded', function() {
            createConfetti();
        });

        function createConfetti() {
            const container = document.getElementById('confettiContainer');
            const colors = ['#10b981', '#34d399', '#6ee7b7', '#fbbf24', '#f59e0b', '#3b82f6', '#8b5cf6', '#ec4899'];

            for (let i = 0; i < 100; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                    confetti.style.animationDelay = Math.random() * 2 + 's';

                    // Random shapes
                    if (Math.random() > 0.5) {
                        confetti.style.borderRadius = '50%';
                    } else {
                        confetti.style.transform = 'rotate(45deg)';
                    }

                    container.appendChild(confetti);

                    // Remove confetti after animation
                    setTimeout(() => {
                        confetti.remove();
                    }, 6000);
                }, i * 50);
            }
        }
        @endif

        // Animate score counter
        document.addEventListener('DOMContentLoaded', function() {
            const scoreElement = document.getElementById('scoreValue');
            const targetScore = parseInt(scoreElement.textContent);
            let currentScore = 0;
            const duration = 1500;
            const increment = targetScore / (duration / 16);

            function updateScore() {
                currentScore += increment;
                if (currentScore < targetScore) {
                    scoreElement.textContent = Math.floor(currentScore);
                    requestAnimationFrame(updateScore);
                } else {
                    scoreElement.textContent = targetScore;
                }
            }

            // Start animation after a short delay
            setTimeout(updateScore, 500);
        });

        // Add intersection observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    </script>

</body>
</html>
