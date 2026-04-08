@props(['programStudi' => null, 'nim' => null])

@php
/**
 * Component: prodi-welcome
 * Menampilkan banner/info spesifik berdasarkan program studi
 * Identifikasi otomatis dari kodeProdi atau NIM
 *
 * Props:
 *   $programStudi - instance ProgramStudy model
 *   $nim          - NIM mahasiswa (opsional, untuk fallback deteksi)
 */

// Mapping kodeProdi → konfigurasi tampilan
$prodiConfig = [
    // ── Teknik ──────────────────────────────────────────
    '280' => [
        'icon'        => '💻',
        'warna'       => 'from-blue-900 via-blue-800 to-cyan-700',
        'aksen'       => 'text-cyan-300',
        'badge_bg'    => 'bg-cyan-500/20 border-cyan-400/40',
        'badge_text'  => 'text-cyan-200',
        'deskripsi'   => 'Selamat! Anda kini resmi menjadi mahasiswa Teknik Informatika. Perjalanan Anda dalam dunia teknologi, pemrograman, dan inovasi digital dimulai dari sini.',
        'peluang'     => ['Software Engineer', 'Data Scientist', 'Cybersecurity Analyst', 'AI/ML Engineer', 'Web Developer'],
        'kutipan'     => 'Kode yang baik adalah puisi yang dimengerti oleh komputer.',
    ],
    '210' => [
        'icon'        => '⚙️',
        'warna'       => 'from-gray-900 via-slate-800 to-gray-700',
        'aksen'       => 'text-orange-300',
        'badge_bg'    => 'bg-orange-500/20 border-orange-400/40',
        'badge_text'  => 'text-orange-200',
        'deskripsi'   => 'Selamat bergabung di Teknik Mesin! Anda akan mempelajari rekayasa, manufaktur, dan inovasi yang menggerakkan dunia.',
        'peluang'     => ['Mechanical Engineer', 'Manufacturing Engineer', 'Quality Control', 'R&D Engineer', 'Project Manager'],
        'kutipan'     => 'Rekayasa adalah seni membangun solusi dari keterbatasan.',
    ],
    '220' => [
        'icon'        => '⚡',
        'warna'       => 'from-yellow-900 via-amber-800 to-yellow-700',
        'aksen'       => 'text-yellow-300',
        'badge_bg'    => 'bg-yellow-500/20 border-yellow-400/40',
        'badge_text'  => 'text-yellow-200',
        'deskripsi'   => 'Selamat bergabung di Teknik Elektro! Anda akan menguasai dunia kelistrikan, elektronika, dan sistem tenaga.',
        'peluang'     => ['Electrical Engineer', 'Power Systems Engineer', 'Electronics Designer', 'Control Engineer', 'IoT Specialist'],
        'kutipan'     => 'Listrik adalah bahasa alam yang kami pelajari untuk berbicara dengannya.',
    ],
    '310' => [
        'icon'        => '⚕️',
        'warna'       => 'from-green-900 via-emerald-800 to-teal-700',
        'aksen'       => 'text-emerald-300',
        'badge_bg'    => 'bg-emerald-500/20 border-emerald-400/40',
        'badge_text'  => 'text-emerald-200',
        'deskripsi'   => 'Selamat bergabung di Kedokteran! Perjalanan mulia Anda dalam melayani kesehatan masyarakat dimulai hari ini.',
        'peluang'     => ['Dokter Umum', 'Dokter Spesialis', 'Peneliti Medis', 'Medical Consultant', 'Healthcare Manager'],
        'kutipan'     => 'Obat terbaik adalah pengetahuan dan kepedulian terhadap sesama.',
    ],
    '410' => [
        'icon'        => '⚖️',
        'warna'       => 'from-purple-900 via-violet-800 to-indigo-700',
        'aksen'       => 'text-violet-300',
        'badge_bg'    => 'bg-violet-500/20 border-violet-400/40',
        'badge_text'  => 'text-violet-200',
        'deskripsi'   => 'Selamat bergabung di Hukum! Anda akan menjadi penjaga keadilan dan pembela hak-hak masyarakat.',
        'peluang'     => ['Advokat', 'Hakim', 'Jaksa', 'Notaris', 'Corporate Legal Counsel'],
        'kutipan'     => 'Hukum bukan sekadar peraturan — ia adalah cerminan nilai keadaban bangsa.',
    ],
    '510' => [
        'icon'        => '📊',
        'warna'       => 'from-red-900 via-rose-800 to-pink-700',
        'aksen'       => 'text-rose-300',
        'badge_bg'    => 'bg-rose-500/20 border-rose-400/40',
        'badge_text'  => 'text-rose-200',
        'deskripsi'   => 'Selamat bergabung di Manajemen! Anda akan mempelajari strategi bisnis, kepemimpinan, dan pengelolaan organisasi.',
        'peluang'     => ['Business Manager', 'Marketing Strategist', 'Entrepreneur', 'Consultant', 'HR Manager'],
        'kutipan'     => 'Manajemen yang baik dimulai dari pemahaman yang mendalam terhadap manusia.',
    ],
    '520' => [
        'icon'        => '💰',
        'warna'       => 'from-teal-900 via-cyan-800 to-sky-700',
        'aksen'       => 'text-teal-300',
        'badge_bg'    => 'bg-teal-500/20 border-teal-400/40',
        'badge_text'  => 'text-teal-200',
        'deskripsi'   => 'Selamat bergabung di Akuntansi! Anda akan menguasai ilmu keuangan yang menjadi tulang punggung setiap organisasi.',
        'peluang'     => ['Akuntan Publik', 'Auditor', 'Financial Analyst', 'Tax Consultant', 'CFO'],
        'kutipan'     => 'Angka-angka adalah bahasa bisnis yang paling jujur.',
    ],
];

// Cari konfigurasi berdasarkan kodeProdi
$kode   = $programStudi?->kodeProdi;
$config = $prodiConfig[$kode] ?? null;

// Fallback: coba deteksi dari NIM jika ada
if (!$config && $nim) {
    foreach ($prodiConfig as $k => $cfg) {
        if (str_contains($nim, $k)) {
            $config = $cfg;
            $kode   = $k;
            break;
        }
    }
}

// Default jika prodi tidak ditemukan di mapping
$config ??= [
    'icon'       => '🎓',
    'warna'      => 'from-indigo-900 via-blue-800 to-indigo-700',
    'aksen'      => 'text-indigo-300',
    'badge_bg'   => 'bg-indigo-500/20 border-indigo-400/40',
    'badge_text' => 'text-indigo-200',
    'deskripsi'  => 'Selamat bergabung! Anda kini resmi menjadi bagian dari keluarga besar Universitas Muhammadiyah Parepare. Perjalanan akademik Anda penuh potensi dimulai hari ini.',
    'peluang'    => ['Profesional', 'Akademisi', 'Wirausahawan', 'Peneliti'],
    'kutipan'    => 'Pendidikan adalah senjata paling ampuh untuk mengubah dunia.',
];
@endphp

{{-- ══════════════════════════════════════════════════════════
     BANNER PROGRAM STUDI
     ══════════════════════════════════════════════════════════ --}}
<div class="prodi-banner relative overflow-hidden rounded-2xl bg-gradient-to-br {{ $config['warna'] }} p-8 shadow-2xl">
    
    {{-- Dekorasi latar --}}
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px),
                radial-gradient(circle at 80% 20%, white 1px, transparent 1px);
                background-size: 40px 40px;">
    </div>
    <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/5 blur-2xl"></div>
    <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full bg-white/5 blur-2xl"></div>

    <div class="relative z-10">
        {{-- Icon & Nama Prodi --}}
        <div class="flex items-center gap-4 mb-6">
            <div class="text-5xl">{{ $config['icon'] }}</div>
            <div>
                <p class="text-white/60 text-sm font-medium tracking-widest uppercase mb-1">Program Studi</p>
                <h2 class="text-2xl font-bold text-white">{{ $programStudi?->namaProdi ?? 'Program Studi' }}</h2>
                @if($programStudi?->fakultas)
                    <p class="{{ $config['aksen'] }} text-sm mt-1">{{ $programStudi->fakultas }}</p>
                @endif
            </div>
        </div>

        {{-- Deskripsi --}}
        <p class="text-white/80 leading-relaxed mb-6 text-sm md:text-base">
            {{ $config['deskripsi'] }}
        </p>

        {{-- Peluang Karir --}}
        <div class="mb-6">
            <p class="{{ $config['aksen'] }} text-xs font-semibold tracking-widest uppercase mb-3">Peluang Karir Anda</p>
            <div class="flex flex-wrap gap-2">
                @foreach($config['peluang'] as $karir)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $config['badge_bg'] }} {{ $config['badge_text'] }}">
                        {{ $karir }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Kutipan --}}
        <blockquote class="border-l-2 border-white/30 pl-4">
            <p class="text-white/60 text-sm italic">"{{ $config['kutipan'] }}"</p>
        </blockquote>
    </div>
</div>