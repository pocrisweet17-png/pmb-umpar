@extends('admin.layouts.app')

@section('title', 'Daftar Ulang Mahasiswa')
@section('page-title', $isDekan ? 'Daftar Ulang – ' . $namaFakultas : 'Daftar Ulang Mahasiswa')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
* { font-family: 'DM Sans', sans-serif; }
.mono { font-family: 'DM Mono', monospace; }
::-webkit-scrollbar { width:6px; height:6px; }
::-webkit-scrollbar-track { background:#f1f5f9; }
::-webkit-scrollbar-thumb { background:#c7d2fe; border-radius:999px; }

/* SORT HEADERS */
th[data-sort] { cursor:pointer; user-select:none; }
th[data-sort]:hover { background:#e0e7ff !important; }
th[data-sort]::after { content:' ↕'; opacity:.35; font-size:.65rem; }
th[data-sort].asc::after  { content:' ↑'; opacity:1; color:#4f46e5; }
th[data-sort].desc::after { content:' ↓'; opacity:1; color:#4f46e5; }

/* FILTER HIDE */
tr.row-hidden { display:none !important; }

/* EXPORT MENU */
#exportMenu { transform-origin:top right; transition:opacity .15s,transform .15s; }
#exportMenu.open { opacity:1; transform:scale(1); pointer-events:auto; }
#exportMenu:not(.open) { opacity:0; transform:scale(.95); pointer-events:none; }

/* MODAL FADE */
#dokumenModal.visible { display:flex !important; }
</style>
@endpush

@section('content')
<div class="max-w-full mx-auto">

{{-- ALERT --}}
@if(session('success'))
<div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-3 flex items-center justify-between text-sm font-medium shadow-sm"
     x-data="{s:true}" x-show="s" x-transition>
    <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    <button @click="s=false" class="text-emerald-400 hover:text-emerald-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
</div>
@endif

{{-- DEKAN BADGE --}}
@if($isDekan)
<div class="mb-4 flex items-center gap-2 bg-indigo-50 border border-indigo-200 rounded-xl px-5 py-3 text-sm font-semibold text-indigo-700">
    <svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
    Menampilkan data Fakultas <span class="underline decoration-dotted ml-1">{{ $namaFakultas }}</span>
</div>
@endif

{{-- STATS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
    @foreach([
        ['label'=>'Total Mahasiswa','key'=>'total',   'from'=>'from-blue-600',   'to'=>'to-indigo-600','icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['label'=>'Terverifikasi',  'key'=>'verified','from'=>'from-emerald-500','to'=>'to-teal-600',  'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Menunggu',       'key'=>'pending', 'from'=>'from-amber-500',  'to'=>'to-orange-500','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Ditolak',        'key'=>'rejected','from'=>'from-rose-500',   'to'=>'to-red-600',   'icon'=>'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ] as $s)
    <div class="bg-gradient-to-br {{ $s['from'] }} {{ $s['to'] }} rounded-2xl p-5 text-white shadow-lg flex items-center justify-between">
        <div>
            <p class="text-white/70 text-xs font-medium mb-1">{{ $s['label'] }}</p>
            <p class="text-3xl font-bold tracking-tight" id="stat-{{ $s['key'] }}">{{ $stats[$s['key']] }}</p>
        </div>
        <div class="bg-white/15 rounded-xl p-2.5">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/></svg>
        </div>
    </div>
    @endforeach
</div>


{{-- ══ TOOLBAR ══ --}}
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm mb-4 sticky top-0 z-30">
    <div class="px-5 py-3.5 flex flex-wrap gap-3 items-center">

        {{-- Search --}}
        <div class="relative flex-1 min-w-44 max-w-64">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input id="searchInput" type="text" placeholder="Cari NIM, nama, email…"
                class="w-full pl-9 pr-8 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-400 focus:border-transparent outline-none transition">
            <button id="clearSearch" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 hidden">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Filter Status --}}
        <select id="filterStatus" class="py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-400 outline-none cursor-pointer">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="verified">Verified</option>
            <option value="rejected">Rejected</option>
        </select>

        {{-- Filter Prodi (admin) --}}
        @if(!$isDekan)
        <select id="filterProdi" class="py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-400 outline-none cursor-pointer max-w-52">
            <option value="">Semua Prodi</option>
            @foreach($prodiList ?? [] as $p)
            <option value="{{ $p->kodeProdi }}">{{ $p->namaProdi }}</option>
            @endforeach
        </select>
        @endif

        {{-- Filter Angkatan --}}
        <select id="filterAngkatan" class="py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-400 outline-none cursor-pointer">
            <option value="">Semua Angkatan</option>
            @foreach($angkatanList ?? [] as $a)
            <option value="{{ $a }}">{{ $a }}</option>
            @endforeach
        </select>

        {{-- Result badge --}}
        <span id="resultCount" class="text-xs text-gray-400 mono hidden bg-gray-100 px-2.5 py-1 rounded-full"></span>

        {{-- Spacer --}}
        <div class="flex-1"></div>

        {{-- Reset --}}
        <button id="resetFilters" class="hidden text-xs text-indigo-600 hover:text-indigo-800 font-semibold underline underline-offset-2">Reset</button>

        {{-- Export --}}
        <div class="relative">
            <button id="exportBtn"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div id="exportMenu" class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden" style="display:none">
                <div class="px-4 py-2 bg-gray-50 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pilih Export</p>
                </div>
                <a href="{{ route('admin.mahasiswa.export-excel') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Semua Mahasiswa
                </a>
                @if($isDekan)
                <a href="{{ route('admin.mahasiswa.export-excel', ['fakultas' => $kodeDekan ?? '']) }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                    Ekspor per Fakultas
                </a>
                @else
                <button onclick="exportFiltered()" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h10a1 1 0 010 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 010 2H4a1 1 0 01-1-1z"/></svg>
                    Ekspor Filter Aktif
                </button>
                @endif
                <button onclick="exportByProdi()" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors border-t border-gray-100">
                    <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Ekspor per Prodi
                </button>
            </div>
        </div>

    </div>
</div>


{{-- ══════════ TABLES ══════════ --}}

@if($isDekan)

{{-- DEKAN MODE --}}
@forelse($mahasiswaPerProdi as $pd)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6 prodi-block" data-kode="{{ $pd['kodeProdi'] }}">
    <div class="bg-gradient-to-r from-indigo-700 via-indigo-600 to-violet-600 px-6 py-4 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h3 class="text-sm font-bold text-white">{{ $pd['namaProdi'] }}</h3>
            <p class="text-indigo-200 text-xs mono mt-0.5">{{ $pd['kodeProdi'] }}</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs font-semibold bg-white/20 text-white px-3 py-1 rounded-full">{{ $pd['stats']['total'] }} Total</span>
            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-emerald-400/25 text-white px-3 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ $pd['stats']['verified'] }}
            </span>
            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-amber-400/25 text-white px-3 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $pd['stats']['pending'] }}
            </span>
            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-rose-400/25 text-white px-3 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                {{ $pd['stats']['rejected'] }}
            </span>
            <a href="{{ route('admin.mahasiswa.export-excel', ['prodi' => $pd['kodeProdi']]) }}"
               class="text-xs font-semibold bg-white text-indigo-700 hover:bg-indigo-50 px-3 py-1 rounded-full transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export Prodi
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm" data-table>
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">No</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="nim">NIM</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="nama">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="angkatan">Angkatan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">JK</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Agama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Asal Sekolah</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="status">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pd['mahasiswas'] as $idx => $m)
                @php $hasDocs = $m->user && $m->user->dokumens && $m->user->dokumens->isNotEmpty(); @endphp
                <tr class="hover:bg-indigo-50/40 transition-colors data-row"
                    data-nim="{{ strtolower($m->nim) }}"
                    data-nama="{{ strtolower($m->namaLengkap) }}"
                    data-email="{{ strtolower($m->user->email ?? '') }}"
                    data-status="{{ $m->status_daftar_ulang }}"
                    data-angkatan="{{ $m->angkatan }}"
                    data-prodi="{{ $pd['kodeProdi'] }}">
                    <td class="px-4 py-3 text-gray-400 mono text-xs">{{ $idx+1 }}</td>
                    <td class="px-4 py-3 font-semibold mono text-gray-800 text-xs">{{ $m->nim }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ substr($m->namaLengkap,0,1) }}</div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm leading-tight">{{ $m->namaLengkap }}</p>
                                <p class="text-xs text-gray-400">{{ $m->user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-700 mono text-sm">{{ $m->angkatan }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $m->registrasi->jenisKelamin ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $m->registrasi->agama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm max-w-36 truncate" title="{{ $m->registrasi->asalSekolah ?? '-' }}">{{ $m->registrasi->asalSekolah ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm max-w-36 truncate" title="{{ $m->registrasi->alamat ?? '-' }}">{{ Str::limit($m->registrasi->alamat ?? '-',28) }}</td>
                    <td class="px-4 py-3">@include('admin.Mahasiswa.partials._status-badge',['status'=>$m->status_daftar_ulang])</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1.5">
                            @if($m->status_daftar_ulang === 'pending')
                            <form action="{{ route('admin.mahasiswa.verify-daftar-ulang',$m->id) }}" method="POST" class="inline">@csrf
                                <button onclick="return confirm('Verifikasi mahasiswa ini?')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Verify
                                </button>
                            </form>
                            <form action="{{ route('admin.mahasiswa.reject-daftar-ulang',$m->id) }}" method="POST" class="inline">@csrf
                                <button onclick="return confirm('Tolak mahasiswa ini?')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Reject
                                </button>
                            </form>
                            @endif
                            @if($hasDocs)
                            <button type="button" onclick="openDokumenModal({{ $m->id }},'{{ addslashes($m->namaLengkap) }}')"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Dokumen
                            </button>
                            @endif
                            @if($m->status_daftar_ulang === 'verified' && !$hasDocs)
                            <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Terverifikasi
                            </span>
                            @endif
                            @if($m->status_daftar_ulang === 'rejected')
                            <span class="inline-flex items-center gap-1 text-xs text-rose-600 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                Ditolak
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr class="hidden" id="dokumen-data-{{ $m->id }}"><td colspan="10"><span class="dokumen-json">{{ $hasDocs ? $m->user->dokumens->map(fn($d)=>['id'=>$d->idDokumen,'jenis'=>$d->jenisDokumen,'nama'=>$d->namaFile,'url'=>route('admin.mahasiswa.download-dokumen',[$m->id,$d->idDokumen]),'preview'=>route('admin.mahasiswa.preview-dokumen',[$m->id,$d->idDokumen])])->toJson() : '[]' }}</span></td></tr>
                @empty
                <tr><td colspan="10" class="px-6 py-10 text-center text-sm text-gray-400">Belum ada mahasiswa di prodi ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
    <p class="text-sm text-gray-400">Belum ada mahasiswa daftar ulang di {{ $namaFakultas }}</p>
</div>
@endforelse

@else

{{-- ADMIN MODE --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-4 flex items-center justify-between">
        <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Data Mahasiswa Baru
        </h3>
        <span id="tableRowCount" class="text-blue-200 text-xs mono"></span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm" data-table>
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">No</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="nim">NIM</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="nama">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="prodi">Prodi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="angkatan">Angkatan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">JK</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Agama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Asal Sekolah</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-sort="status">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($mahasiswas as $index => $m)
                @php $hasDocs = $m->user && $m->user->dokumens && $m->user->dokumens->isNotEmpty(); @endphp
                <tr class="hover:bg-indigo-50/40 transition-colors data-row"
                    data-nim="{{ strtolower($m->nim) }}"
                    data-nama="{{ strtolower($m->namaLengkap) }}"
                    data-email="{{ strtolower($m->user->email ?? '') }}"
                    data-status="{{ $m->status_daftar_ulang }}"
                    data-angkatan="{{ $m->angkatan }}"
                    data-prodi="{{ $m->kodeProdi }}">
                    <td class="px-4 py-3 text-gray-400 mono text-xs">{{ $mahasiswas->firstItem()+$index }}</td>
                    <td class="px-4 py-3 font-semibold mono text-gray-800 text-xs">{{ $m->nim }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ substr($m->namaLengkap,0,1) }}</div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm leading-tight">{{ $m->namaLengkap }}</p>
                                <p class="text-xs text-gray-400">{{ $m->user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-700 text-xs">{{ $m->programStudi->namaProdi ?? $m->kodeProdi }}</td>
                    <td class="px-4 py-3 text-gray-700 mono text-sm">{{ $m->angkatan }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $m->registrasi->jenisKelamin ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $m->registrasi->agama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm max-w-36 truncate" title="{{ $m->registrasi->asalSekolah ?? '-' }}">{{ $m->registrasi->asalSekolah ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm max-w-36 truncate" title="{{ $m->registrasi->alamat ?? '-' }}">{{ Str::limit($m->registrasi->alamat ?? '-',28) }}</td>
                    <td class="px-4 py-3">@include('admin.Mahasiswa.partials._status-badge',['status'=>$m->status_daftar_ulang])</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1.5">
                            @if($m->status_daftar_ulang === 'pending')
                            <form action="{{ route('admin.mahasiswa.verify-daftar-ulang',$m->id) }}" method="POST" class="inline">@csrf
                                <button onclick="return confirm('Verifikasi mahasiswa ini?')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Verify
                                </button>
                            </form>
                            <form action="{{ route('admin.mahasiswa.reject-daftar-ulang',$m->id) }}" method="POST" class="inline">@csrf
                                <button onclick="return confirm('Tolak mahasiswa ini?')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Reject
                                </button>
                            </form>
                            @endif
                            @if($hasDocs)
                            <button type="button" onclick="openDokumenModal({{ $m->id }},'{{ addslashes($m->namaLengkap) }}')"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Dokumen
                            </button>
                            @endif
                            @if($m->status_daftar_ulang === 'verified' && !$hasDocs)
                            <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Terverifikasi
                            </span>
                            @endif
                            @if($m->status_daftar_ulang === 'rejected')
                            <span class="inline-flex items-center gap-1 text-xs text-rose-600 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                Ditolak
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr class="hidden" id="dokumen-data-{{ $m->id }}"><td colspan="11"><span class="dokumen-json">{{ $hasDocs ? $m->user->dokumens->map(fn($d)=>['id'=>$d->idDokumen,'jenis'=>$d->jenisDokumen,'nama'=>$d->namaFile,'url'=>route('admin.mahasiswa.download-dokumen',[$m->id,$d->idDokumen]),'preview'=>route('admin.mahasiswa.preview-dokumen',[$m->id,$d->idDokumen])])->toJson() : '[]' }}</span></td></tr>
                @empty
                <tr><td colspan="11" class="px-6 py-14 text-center text-sm text-gray-400">Belum ada mahasiswa yang daftar ulang</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($mahasiswas->hasPages())
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">{{ $mahasiswas->links() }}</div>
    @endif
</div>

@endif {{-- end isDekan --}}

{{-- No results --}}
<div id="noResultsNotice" class="hidden bg-white rounded-2xl p-14 text-center shadow-sm border border-gray-100 mt-4">
    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    <p class="mt-3 text-sm text-gray-400 font-medium">Tidak ada hasil yang cocok</p>
    <button onclick="resetAllFilters()" class="mt-2 text-xs text-indigo-600 hover:text-indigo-800 font-semibold underline underline-offset-2">Reset filter</button>
</div>

</div>{{-- /max-w --}}


{{-- ══════════ MODAL DOKUMEN ══════════ --}}
<div id="dokumenModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-950/70 backdrop-blur-sm" onclick="closeDokumenModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl z-10 overflow-hidden flex flex-col" style="max-height:90vh">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-indigo-700 to-violet-700 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/></svg>
                    Dokumen Pendaftaran
                </h3>
                <p id="modal-subtitle" class="text-indigo-200 text-xs mt-0.5 mono">—</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="downloadAllDocs()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Semua (ZIP)
                </button>
                <button onclick="closeDokumenModal()" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="border-b border-gray-100 flex-shrink-0 flex">
            <button onclick="switchTab('list')" id="tab-list"
                class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-indigo-600 text-indigo-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                Daftar Dokumen
            </button>
            <button onclick="switchTab('preview')" id="tab-preview"
                class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Preview
            </button>
        </div>

        {{-- Panel List --}}
        <div id="panel-list" class="overflow-y-auto flex-1">
            <div id="modal-dokumen-list"></div>
        </div>

        {{-- Panel Preview --}}
        <div id="panel-preview" class="hidden overflow-y-auto flex-1 p-5">
            <div id="previewContainer" class="flex flex-col items-center justify-center min-h-48 text-center text-gray-400">
                <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <p class="text-sm">Klik <b>Preview</b> pada dokumen untuk menampilkan di sini</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-100 flex-shrink-0">
            <span id="docCountLabel" class="text-xs text-gray-400 mono"></span>
            <button onclick="closeDokumenModal()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Tutup</button>
        </div>
    </div>
</div>


<script>
// ── STATE ──
let currentDocs  = [];
let currentMhsId = null;
const exportBase = '{{ route("admin.mahasiswa.export-excel") }}';

// ── FILTER / SEARCH ──
const $search    = document.getElementById('searchInput');
const $status    = document.getElementById('filterStatus');
const $prodi     = document.getElementById('filterProdi');
const $angkatan  = document.getElementById('filterAngkatan');
const $clear     = document.getElementById('clearSearch');
const $reset     = document.getElementById('resetFilters');
const $noResults = document.getElementById('noResultsNotice');

function applyFilters() {
    const q  = $search?.value.toLowerCase().trim() || '';
    const st = $status?.value  || '';
    const pr = $prodi?.value   || '';
    const an = $angkatan?.value || '';
    const hasAny = q||st||pr||an;

    $clear?.classList.toggle('hidden', !q);
    $reset?.classList.toggle('hidden', !hasAny);

    let visible = 0;
    document.querySelectorAll('tr.data-row').forEach(row => {
        const show =
            (!q  || row.dataset.nim.includes(q) || row.dataset.nama.includes(q) || row.dataset.email.includes(q)) &&
            (!st || row.dataset.status   === st) &&
            (!pr || row.dataset.prodi    === pr) &&
            (!an || row.dataset.angkatan === an);
        row.classList.toggle('row-hidden', !show);
        if (show) visible++;
    });

    // hide empty prodi blocks (dekan mode)
    document.querySelectorAll('.prodi-block').forEach(blk => {
        const vis = blk.querySelectorAll('tr.data-row:not(.row-hidden)').length;
        blk.classList.toggle('hidden', vis === 0 && hasAny);
    });

    // counters
    const $cnt = document.getElementById('resultCount');
    if ($cnt) { $cnt.textContent = hasAny ? visible + ' hasil' : ''; $cnt.classList.toggle('hidden', !hasAny); }
    const $rc = document.getElementById('tableRowCount');
    if ($rc) $rc.textContent = visible + ' baris';

    $noResults?.classList.toggle('hidden', visible > 0 || !hasAny);
    liveStats();
}

function liveStats() {
    let t=0,v=0,p=0,r=0;
    document.querySelectorAll('tr.data-row:not(.row-hidden)').forEach(row => {
        t++; const s=row.dataset.status;
        if(s==='verified')v++; else if(s==='pending')p++; else if(s==='rejected')r++;
    });
    ['total','verified','pending','rejected'].forEach((k,i) => {
        const el = document.getElementById('stat-'+k);
        if(el) el.textContent = [t,v,p,r][i];
    });
}

$search?.addEventListener('input', applyFilters);
$status?.addEventListener('change', applyFilters);
$prodi?.addEventListener('change', applyFilters);
$angkatan?.addEventListener('change', applyFilters);
$clear?.addEventListener('click', () => { $search.value=''; applyFilters(); $search.focus(); });
$reset?.addEventListener('click', resetAllFilters);

function resetAllFilters() {
    if($search)   $search.value   = '';
    if($status)   $status.value   = '';
    if($prodi)    $prodi.value    = '';
    if($angkatan) $angkatan.value = '';
    applyFilters();
}


// ── SORT ──
let sortCol=null, sortDir='asc';
document.querySelectorAll('th[data-sort]').forEach(th => {
    th.addEventListener('click', () => {
        const col   = th.dataset.sort;
        const tbody = th.closest('table').querySelector('tbody');
        sortDir = (sortCol===col && sortDir==='asc') ? 'desc' : 'asc';
        sortCol = col;

        document.querySelectorAll('th[data-sort]').forEach(h => h.classList.remove('asc','desc'));
        document.querySelectorAll(`th[data-sort="${col}"]`).forEach(h => h.classList.add(sortDir));

        const rows = Array.from(tbody.querySelectorAll('tr.data-row'));
        rows.sort((a,b) => {
            const va = (a.dataset[col]||'').toLowerCase();
            const vb = (b.dataset[col]||'').toLowerCase();
            return sortDir==='asc' ? va.localeCompare(vb,'id',{numeric:true}) : vb.localeCompare(va,'id',{numeric:true});
        });
        rows.forEach(r => tbody.appendChild(r));
    });
});


// ── EXPORT MENU ──
document.getElementById('exportBtn')?.addEventListener('click', e => {
    e.stopPropagation();
    const menu = document.getElementById('exportMenu');
    const isOpen = menu.classList.contains('open');
    menu.style.display = 'block';
    setTimeout(() => menu.classList.toggle('open', !isOpen), 10);
});
document.addEventListener('click', () => {
    const menu = document.getElementById('exportMenu');
    if(menu) { menu.classList.remove('open'); setTimeout(()=>{ if(!menu.classList.contains('open')) menu.style.display='none'; },160); }
});

function exportFiltered() {
    const p = new URLSearchParams();
    if($search?.value.trim())  p.set('q',       $search.value.trim());
    if($status?.value)         p.set('status',  $status.value);
    if($prodi?.value)          p.set('prodi',   $prodi.value);
    if($angkatan?.value)       p.set('angkatan',$angkatan.value);
    window.location.href = exportBase + '?' + p.toString();
}
function exportByProdi() {
    const kode = $prodi?.value || prompt('Masukkan kode prodi:');
    if(kode) window.location.href = exportBase + '?prodi=' + kode;
    return false;
}


// ── MODAL DOKUMEN ──
const ICON_DOC  = `<svg class="w-9 h-9 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>`;
const ICON_IMG  = `<svg class="w-9 h-9 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;
const ICON_PDF  = `<svg class="w-9 h-9 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>`;

const isImage = n => /\.(jpg|jpeg|png|gif|webp|bmp)$/i.test(n);
const isPdf   = n => /\.pdf$/i.test(n);
const getIcon = (j,n) => {
    const s=(j+n).toLowerCase();
    if(s.match(/\.(jpg|jpeg|png|gif|webp)$/) || s.includes('foto') || s.includes('pas')) return ICON_IMG;
    if(s.match(/\.pdf$/) || s.includes('pdf')) return ICON_PDF;
    return ICON_DOC;
};

function openDokumenModal(mhsId, nama) {
    currentMhsId = mhsId;
    const row  = document.getElementById('dokumen-data-' + mhsId);
    const json = row?.querySelector('.dokumen-json')?.textContent?.trim() || '[]';
    try { currentDocs = JSON.parse(json); } catch(e) { currentDocs = []; }

    document.getElementById('modal-subtitle').textContent  = nama;
    document.getElementById('docCountLabel').textContent   = currentDocs.length + ' dokumen';
    renderDocList();
    switchTab('list');

    const modal = document.getElementById('dokumenModal');
    modal.classList.remove('hidden');
    modal.classList.add('visible');
    document.body.style.overflow = 'hidden';
}

function closeDokumenModal() {
    const modal = document.getElementById('dokumenModal');
    modal.classList.add('hidden');
    modal.classList.remove('visible');
    document.body.style.overflow = '';
    currentDocs = []; currentMhsId = null;
}

function renderDocList() {
    const list = document.getElementById('modal-dokumen-list');
    if(!currentDocs.length) {
        list.innerHTML = `<div class="px-6 py-10 text-center text-sm text-gray-400">Tidak ada dokumen ditemukan.</div>`;
        return;
    }
    list.innerHTML = currentDocs.map((doc,i) => {
        const ext = doc.nama.split('.').pop().toUpperCase();
        const canPrev = isImage(doc.nama) || isPdf(doc.nama);
        return `
        <div class="flex items-center gap-4 px-5 py-4 hover:bg-indigo-50/60 transition-colors group border-b border-gray-50 last:border-0">
            <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 group-hover:border-indigo-200 transition-colors">
                ${getIcon(doc.jenis,doc.nama)}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 leading-tight">${doc.jenis}</p>
                <p class="text-xs text-gray-400 truncate mt-0.5 mono">${doc.nama}</p>
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="text-xs font-semibold mono bg-gray-100 text-gray-500 px-2 py-0.5 rounded">${ext}</span>
                    ${canPrev ? `<span class="text-xs text-indigo-400">• Preview tersedia</span>` : ''}
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                ${canPrev ? `
                <button onclick="previewDoc(${i})"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-lg transition-colors border border-indigo-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Preview
                </button>` : ''}
                <a href="${doc.url}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download
                </a>
            </div>
        </div>`;
    }).join('');
}

function previewDoc(idx) {
    const doc = currentDocs[idx];
    if(!doc) return;
    const c = document.getElementById('previewContainer');
    c.innerHTML = `
        <div class="w-full">
            <div class="flex items-center justify-between mb-3 px-1">
                <div>
                    <p class="text-sm font-semibold text-gray-800">${doc.jenis}</p>
                    <p class="text-xs text-gray-400 mono">${doc.nama}</p>
                </div>
                <a href="${doc.url}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download
                </a>
            </div>
            ${isImage(doc.nama)
                ? `<img src="${doc.preview}" alt="${doc.jenis}" class="w-full rounded-xl border border-gray-100 shadow-sm" style="max-height:62vh;object-fit:contain" onerror="this.outerHTML='<p class=\\'text-sm text-red-400 text-center py-8\\'>Gagal memuat gambar</p>'">`
                : `<iframe src="${doc.preview}" class="w-full rounded-xl border border-gray-100 shadow-sm bg-gray-50" style="height:62vh" title="${doc.jenis}"></iframe>`
            }
        </div>`;
    switchTab('preview');
}

function switchTab(tab) {
    const lp = document.getElementById('panel-list');
    const pp = document.getElementById('panel-preview');
    const tl = document.getElementById('tab-list');
    const tp = document.getElementById('tab-preview');
    if(tab === 'list') {
        lp.classList.remove('hidden'); pp.classList.add('hidden');
        tl.className = 'inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-indigo-600 text-indigo-700 transition-colors';
        tp.className = 'inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition-colors';
    } else {
        pp.classList.remove('hidden'); lp.classList.add('hidden');
        tp.className = 'inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-indigo-600 text-indigo-700 transition-colors';
        tl.className = 'inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition-colors';
    }
}

// Download semua (ZIP dulu, fallback sequential)
function downloadAllDocs() {
    if(!currentDocs.length) return;
    const zipUrl = `/admin/mahasiswa/${currentMhsId}/download-zip`;
    fetch(zipUrl, {method:'HEAD'})
        .then(r => { if(r.ok) window.location.href = zipUrl; else fallbackDownload(); })
        .catch(() => fallbackDownload());
}
function fallbackDownload() {
    currentDocs.forEach((doc, i) => setTimeout(() => {
        const a = document.createElement('a');
        a.href = doc.url; a.download = doc.nama;
        document.body.appendChild(a); a.click(); document.body.removeChild(a);
    }, i * 700));
}

// Keyboard
document.addEventListener('keydown', e => {
    if(e.key === 'Escape') { closeDokumenModal(); document.getElementById('exportMenu')?.classList.remove('open'); }
});

// Init row count
document.addEventListener('DOMContentLoaded', () => {
    const n = document.querySelectorAll('tr.data-row').length;
    const el = document.getElementById('tableRowCount');
    if(el) el.textContent = n + ' baris';
});
</script>
@endsection