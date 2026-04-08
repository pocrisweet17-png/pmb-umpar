@extends('mahasiswa.layout.app')

@section('title', 'Selamat Datang, Mahasiswa Baru!')

@push('styles')
<style>
    /* ══ Konfeti Animasi ═════════════════════════════════════ */
    @keyframes confetti-fall {
        0%   { transform: translateY(-20px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
    }
    @keyframes float-up {
        0%   { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    @keyframes pulse-ring {
        0%   { transform: scale(0.9); opacity: 1; }
        100% { transform: scale(1.4); opacity: 0; }
    }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    .confetti-piece {
        position: fixed;
        top: -10px;
        width: 10px;
        height: 10px;
        opacity: 0;
        animation: confetti-fall linear forwards;
        border-radius: 2px;
        pointer-events: none;
        z-index: 9999;
    }

    .animate-float { animation: float-up 0.7s ease forwards; }
    .delay-100     { animation-delay: 0.1s; opacity: 0; }
    .delay-200     { animation-delay: 0.2s; opacity: 0; }
    .delay-300     { animation-delay: 0.3s; opacity: 0; }
    .delay-400     { animation-delay: 0.4s; opacity: 0; }
    .delay-500     { animation-delay: 0.5s; opacity: 0; }
    .delay-600     { animation-delay: 0.6s; opacity: 0; }

    .shimmer-text {
        background: linear-gradient(90deg, #fbbf24, #f59e0b, #fde68a, #fbbf24);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }

    .pulse-ring::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 3px solid #fbbf24;
        animation: pulse-ring 1.8s ease-out infinite;
    }

    .spin-slow { animation: spin-slow 20s linear infinite; }

    /* Card hover */
    .info-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    /* Halaman background */
    .page-bg {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #0f172a 100%);
        min-height: 100vh;
    }
</style>
@endpush

@section('content')
<div class="page-bg">

    {{-- ══ KONFETI (JavaScript inject) ══════════════════════════ --}}
    <div id="confetti-container" aria-hidden="true"></div>

    <div class="max-w-4xl mx-auto px-4 py-10 space-y-8">

        {{-- ══ HEADER UTAMA ════════════════════════════════════════ --}}
        <div class="text-center animate-float delay-100">

            {{-- Mahkota / Medali --}}
            <div class="relative inline-block mb-6">
                <div class="pulse-ring relative w-24 h-24 md:w-28 md:h-28 mx-auto rounded-full bg-gradient-to-br from-yellow-400 to-amber-600 flex items-center justify-center shadow-2xl shadow-amber-500/40">
                    <span class="text-5xl">🎓</span>
                </div>
                {{-- Dekorasi bintang berputar --}}
                <div class="absolute inset-0 spin-slow" style="pointer-events:none">
                    <span class="absolute -top-1 left-1/2 -translate-x-1/2 text-yellow-400 text-lg">✦</span>
                    <span class="absolute top-1/2 -right-1 -translate-y-1/2 text-yellow-400 text-sm">★</span>
                    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 text-yellow-300 text-xs">✦</span>
                    <span class="absolute top-1/2 -left-1 -translate-y-1/2 text-yellow-400 text-sm">★</span>
                </div>
            </div>

            <p class="text-yellow-400/80 text-sm font-semibold tracking-[0.3em] uppercase mb-3 animate-float delay-200">
                Universitas Muhammadiyah Parepare
            </p>

            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3 animate-float delay-200 leading-tight">
                Selamat Datang,<br>
                <span class="shimmer-text">{{ $user->nama_lengkap }}!</span>
            </h1>

            <p class="text-white/60 text-base md:text-lg max-w-xl mx-auto animate-float delay-300">
                Anda resmi diterima dan terdaftar sebagai mahasiswa baru. 
                Perjalanan akademik Anda dimulai hari ini.
            </p>
        </div>

        {{-- ══ KARTU INFO MAHASISWA ══════════════════════════════════ --}}
        <div class="animate-float delay-300">
            <div class="info-card bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">

                {{-- Header kartu --}}
                <div class="bg-gradient-to-r from-amber-500/20 to-yellow-500/10 border-b border-white/10 px-6 py-4 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    <span class="text-white/70 text-sm font-medium">Identitas Mahasiswa</span>
                </div>

                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- NIM --}}
                        <div class="space-y-1">
                            <p class="text-white/40 text-xs font-semibold tracking-widest uppercase">NIM</p>
                            <p class="text-white text-xl font-bold font-mono tracking-wider">
                                {{ $user->nim ?? $mahasiswa?->nim ?? '—' }}
                            </p>
                        </div>

                        {{-- Nama --}}
                        <div class="space-y-1">
                            <p class="text-white/40 text-xs font-semibold tracking-widest uppercase">Nama Lengkap</p>
                            <p class="text-white text-base font-semibold">{{ $user->nama_lengkap }}</p>
                        </div>

                        {{-- Program Studi --}}
                        <div class="space-y-1">
                            <p class="text-white/40 text-xs font-semibold tracking-widest uppercase">Program Studi</p>
                            <p class="text-amber-300 text-base font-semibold">
                                {{ $programStudi?->namaProdi ?? ($user->namaProdiPilihan1 ?? '—') }}
                            </p>
                        </div>

                        {{-- Angkatan --}}
                        <div class="space-y-1">
                            <p class="text-white/40 text-xs font-semibold tracking-widest uppercase">Angkatan</p>
                            <p class="text-white text-base font-semibold">
                                {{ $mahasiswa?->angkatan ?? date('Y') }}
                            </p>
                        </div>

                        {{-- Status --}}
                        <div class="space-y-1">
                            <p class="text-white/40 text-xs font-semibold tracking-widest uppercase">Status</p>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-500/20 border border-green-400/40 text-green-300 text-sm font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                                Mahasiswa Aktif
                            </span>
                        </div>

                        {{-- Semester --}}
                        <div class="space-y-1">
                            <p class="text-white/40 text-xs font-semibold tracking-widest uppercase">Semester / Tahun Akademik</p>
                            <p class="text-white text-base font-semibold">
                                Semester {{ $mahasiswa?->semester ?? '1' }} · {{ $mahasiswa?->tahun_akademik ?? date('Y') . '/' . (date('Y') + 1) }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ══ BANNER PROGRAM STUDI (Dynamic Component) ══════════════ --}}
        <div class="animate-float delay-400">
            <x-prodi-welcome :programStudi="$programStudi" :nim="$user->nim ?? $mahasiswa?->nim" />
        </div>

        {{-- ══ TAHAPAN SELANJUTNYA ═══════════════════════════════════ --}}
        <div class="animate-float delay-500">
            <div class="info-card bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <h3 class="text-white font-bold text-lg mb-5 flex items-center gap-2">
                    <span class="text-2xl">📋</span>
                    Langkah Selanjutnya
                </h3>
                <ol class="space-y-4">
                    @foreach([
                        ['🗓️', 'Orientasi Mahasiswa Baru', 'Ikuti kegiatan OSMB/PKKMB yang dijadwalkan kampus untuk mengenal lingkungan akademik.'],
                        ['📚', 'KRS Online', 'Lakukan pengisian Kartu Rencana Studi (KRS) sesuai jadwal yang ditentukan.'],
                        ['🏛️', 'Aktivasi Fasilitas Kampus', 'Aktifkan akun email kampus, perpustakaan, dan fasilitas akademik lainnya.'],
                        ['👥', 'Bergabung dengan Komunitas', 'Ikuti UKM dan organisasi kemahasiswaan sesuai minat Anda.'],
                    ] as $i => $step)
                    <li class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-500/20 border border-amber-400/40 flex items-center justify-center text-amber-300 text-sm font-bold">
                            {{ $i + 1 }}
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm flex items-center gap-2">
                                <span>{{ $step[0] }}</span> {{ $step[1] }}
                            </p>
                            <p class="text-white/50 text-xs mt-0.5 leading-relaxed">{{ $step[2] }}</p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>

        {{-- ══ KONTAK & INFO KAMPUS ══════════════════════════════════ --}}
        <div class="animate-float delay-600">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="info-card bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-5 text-center">
                    <div class="text-3xl mb-2">📞</div>
                    <p class="text-white/40 text-xs uppercase tracking-widest mb-1">Hotline Kampus</p>
                    <p class="text-white font-semibold text-sm">0421-21400</p>
                </div>
                <div class="info-card bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-5 text-center">
                    <div class="text-3xl mb-2">🌐</div>
                    <p class="text-white/40 text-xs uppercase tracking-widest mb-1">Website</p>
                    <p class="text-white font-semibold text-sm">umpar.ac.id</p>
                </div>
                <div class="info-card bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-5 text-center">
                    <div class="text-3xl mb-2">📍</div>
                    <p class="text-white/40 text-xs uppercase tracking-widest mb-1">Lokasi</p>
                    <p class="text-white font-semibold text-sm">Parepare, Sulawesi Selatan</p>
                </div>
            </div>
        </div>

        {{-- ══ FOOTER ACTION ═════════════════════════════════════════ --}}
        <div class="animate-float delay-600 text-center pb-10">
            <a href="{{ route('mahasiswa.dashboard') }}"
               class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-gradient-to-r from-amber-500 to-yellow-400 text-gray-900 font-bold hover:from-amber-400 hover:to-yellow-300 transition-all shadow-lg shadow-amber-500/30 hover:shadow-amber-400/50 hover:-translate-y-0.5 active:translate-y-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

    </div>{{-- /max-w-4xl --}}
</div>{{-- /page-bg --}}
@endsection

@push('scripts')
<script>
// ── Konfeti ──────────────────────────────────────────────────
(function launchConfetti() {
    const colors = ['#fbbf24','#f59e0b','#60a5fa','#34d399','#f472b6','#a78bfa','#fb923c'];
    const container = document.getElementById('confetti-container');
    const count = 80;

    for (let i = 0; i < count; i++) {
        const piece = document.createElement('div');
        piece.classList.add('confetti-piece');
        piece.style.left        = Math.random() * 100 + 'vw';
        piece.style.background  = colors[Math.floor(Math.random() * colors.length)];
        piece.style.width       = (Math.random() * 8 + 6) + 'px';
        piece.style.height      = (Math.random() * 8 + 6) + 'px';
        piece.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
        piece.style.animationDuration = (Math.random() * 3 + 2) + 's';
        piece.style.animationDelay    = (Math.random() * 2)     + 's';
        container.appendChild(piece);
    }

    // Bersihkan setelah animasi selesai
    setTimeout(() => container.innerHTML = '', 7000);
})();
</script>
@endpush