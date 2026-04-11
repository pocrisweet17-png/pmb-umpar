@extends('admin.layouts.app')

@section('title', 'Daftar Ulang Mahasiswa')
@section('page-title', $isDekan ? 'Daftar Ulang – ' . $namaFakultas : 'Daftar Ulang Mahasiswa')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Badge info khusus Dekan -->
    @if($isDekan)
    <div class="mb-6 flex items-center justify-between gap-3 bg-indigo-50 border border-indigo-200 rounded-xl px-5 py-3">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="text-sm font-semibold text-indigo-700">
                Menampilkan data mahasiswa <span class="underline">{{ $namaFakultas }}</span> saja
            </span>
        </div>
        
        <!-- Tombol Export untuk Dekan -->
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.mahasiswa.export-excel') }}" method="GET" class="inline">
                <input type="hidden" name="fakultas_id" value="{{ $kodeDekan }}">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel (Semua Prodi)
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Daftar Ulang</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Terverifikasi</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['verified'] }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">Menunggu</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Ditolak</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['rejected'] }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         MODE DEKAN → satu tabel per Program Studi
         ══════════════════════════════════════════════════════════════ --}}
    @if($isDekan)

        @forelse($mahasiswaPerProdi as $prodiData)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">

            <!-- Header per Prodi dengan Tombol Export -->
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-4">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <h3 class="text-base font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            {{ $prodiData['namaProdi'] }}
                        </h3>
                        <p class="text-indigo-200 text-xs mt-0.5">Kode Prodi: {{ $prodiData['kodeProdi'] }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">{{ $prodiData['stats']['total'] }} Total</span>
                        <span class="bg-green-400/30 text-white text-xs font-semibold px-3 py-1 rounded-full">✓ {{ $prodiData['stats']['verified'] }} Verified</span>
                        <span class="bg-amber-400/30 text-white text-xs font-semibold px-3 py-1 rounded-full">⏳ {{ $prodiData['stats']['pending'] }} Pending</span>
                        <span class="bg-red-400/30 text-white text-xs font-semibold px-3 py-1 rounded-full">✗ {{ $prodiData['stats']['rejected'] }} Rejected</span>
                        
                        <!-- Tombol Export per Prodi -->
                        <form action="{{ route('admin.mahasiswa.export-excel') }}" method="GET" class="inline">
                            <input type="hidden" name="prodi" value="{{ $prodiData['kodeProdi'] }}">
                            @if($kodeDekan)
                            <input type="hidden" name="fakultas_id" value="{{ $kodeDekan }}">
                            @endif
                            <button type="submit" 
                                    class="ml-2 inline-flex items-center px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Export Prodi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel mahasiswa prodi ini -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. HP</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Angkatan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Agama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Asal Sekolah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($prodiData['mahasiswas'] as $index => $mahasiswa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">{{ $mahasiswa->nim }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ substr($mahasiswa->namaLengkap, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $mahasiswa->namaLengkap }}</p>
                                        <p class="text-xs text-gray-500">{{ $mahasiswa->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                             </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->no_hp ?? '-' }}</span>
                             </td>
                            <td class="px-6 py-4"><span class="text-sm font-medium text-gray-900">{{ $mahasiswa->angkatan }}</span></td>
                            <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->jenisKelamin ?? '-' }}</span></td>
                            <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->agama ?? '-' }}</span></td>
                            <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->asalSekolah ?? '-' }}</span></td>
                            <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ Str::limit($mahasiswa->registrasi->alamat ?? '-', 30) }}</span></td>
                            <td class="px-6 py-4">
                                @include('admin.Mahasiswa.partials._status-badge', ['status' => $mahasiswa->status_daftar_ulang])
                             </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Dokumen (selalu tampil jika sudah verified) --}}
                                    @if($mahasiswa->status_daftar_ulang === 'verified' && $mahasiswa->user->dokumens->isNotEmpty())
                                        <button type="button"
                                                onclick="openDokumenModal({{ $mahasiswa->id }}, '{{ addslashes($mahasiswa->namaLengkap) }}')"
                                                class="inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Dokumen
                                        </button>
                                    @endif

                                    @if($mahasiswa->status_daftar_ulang === 'pending')
                                        <form action="{{ route('admin.mahasiswa.verify-daftar-ulang', $mahasiswa->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Verifikasi daftar ulang mahasiswa ini?')"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Verify
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.mahasiswa.reject-daftar-ulang', $mahasiswa->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Tolak daftar ulang mahasiswa ini?')"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Reject
                                            </button>
                                        </form>
                                    @elseif($mahasiswa->status_daftar_ulang === 'verified')
                                        <span class="text-xs text-green-600 font-medium">✓ Terverifikasi</span>
                                    @elseif($mahasiswa->status_daftar_ulang === 'rejected')
                                        <span class="text-xs text-red-600 font-medium">✗ Ditolak</span>
                                    @endif
                                </div>
                             </td>
                         </tr>

                        {{-- Data dokumen tersembunyi untuk modal (di-render sekali per baris) --}}
                        <tr class="hidden" id="dokumen-data-{{ $mahasiswa->id }}">
                            <td colspan="11">
                                <div class="dokumen-json">{{ $mahasiswa->user->dokumens->map(fn($d) => [
                                    'id'    => $d->idDokumen,
                                    'jenis' => $d->jenisDokumen,
                                    'nama'  => $d->namaFile,
                                    'url'   => route('admin.mahasiswa.download-dokumen', [$mahasiswa->id, $d->idDokumen]),
                                ])->toJson() }}</div>
                             </td>
                         </tr>

                        @empty
                        <tr>
                            <td colspan="11" class="px-6 py-10 text-center">
                                <p class="text-sm text-gray-500">Belum ada mahasiswa terdaftar di prodi ini.</p>
                             </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow p-12 text-center border border-gray-100">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="mt-4 text-sm text-gray-500 font-medium">Belum ada mahasiswa yang daftar ulang di {{ $namaFakultas }}</p>
        </div>
        @endforelse

    {{-- ══════════════════════════════════════════════════════════════
         MODE ADMIN / ROLE LAIN → tabel flat
         ══════════════════════════════════════════════════════════════ --}}
    @else

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Data Mahasiswa Baru 2026
                </h3>
                <div class="flex items-center gap-2">
                    <!-- Filter Form untuk Admin -->
                    <form action="{{ route('admin.user.daftar-ulang') }}" method="GET" class="flex items-center gap-2">
                        <select name="prodi" class="text-sm rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Prodi</option>
                            @foreach($prodiList as $prodi)
                                <option value="{{ $prodi->kodeProdi }}" {{ request('prodi') == $prodi->kodeProdi ? 'selected' : '' }}>
                                    {{ $prodi->namaProdi }}
                                </option>
                            @endforeach
                        </select>
                        <select name="status" class="text-sm rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <select name="angkatan" class="text-sm rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Angkatan</option>
                            @foreach($angkatanList as $angkatan)
                                <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>{{ $angkatan }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/NIM..." 
                               class="text-sm rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="submit" class="px-3 py-2 bg-white/20 text-white text-sm rounded-lg hover:bg-white/30">
                            Filter
                        </button>
                        <a href="{{ route('admin.user.daftar-ulang') }}" class="px-3 py-2 bg-white/20 text-white text-sm rounded-lg hover:bg-white/30">
                            Reset
                        </a>
                    </form>
                    
                    <a href="{{ route('admin.mahasiswa.export-excel', request()->all()) }}"
                       class="inline-flex items-center px-4 py-2 bg-white text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-50 transition-colors shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. HP</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prodi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Angkatan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Agama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Asal Sekolah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mahasiswas as $index => $mahasiswa)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $mahasiswas->firstItem() + $index }}</td>
                        <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900">{{ $mahasiswa->nim }}</span></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($mahasiswa->namaLengkap, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $mahasiswa->namaLengkap }}</p>
                                    <p class="text-xs text-gray-500">{{ $mahasiswa->user->email ?? '-' }}</p>
                                </div>
                            </div>
                         </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->no_hp ?? '-' }}</span>
                         </td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ $mahasiswa->programStudi->namaProdi ?? $mahasiswa->kodeProdi }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm font-medium text-gray-900">{{ $mahasiswa->angkatan }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->jenisKelamin ?? '-' }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->agama ?? '-' }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ $mahasiswa->registrasi->asalSekolah ?? '-' }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-900">{{ Str::limit($mahasiswa->registrasi->alamat ?? '-', 30) }}</span></td>
                        <td class="px-6 py-4">
                            @include('admin.Mahasiswa.partials._status-badge', ['status' => $mahasiswa->status_daftar_ulang])
                         </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Tombol Dokumen --}}
                                @if($mahasiswa->status_daftar_ulang === 'verified' && $mahasiswa->user->dokumens->isNotEmpty())
                                    <button type="button"
                                            onclick="openDokumenModal({{ $mahasiswa->id }}, '{{ addslashes($mahasiswa->namaLengkap) }}')"
                                            class="inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Dokumen
                                    </button>
                                @endif

                                @if($mahasiswa->status_daftar_ulang === 'pending')
                                    <form action="{{ route('admin.mahasiswa.verify-daftar-ulang', $mahasiswa->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Verifikasi daftar ulang mahasiswa ini?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Verify
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.mahasiswa.reject-daftar-ulang', $mahasiswa->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tolak daftar ulang mahasiswa ini?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Reject
                                        </button>
                                    </form>
                                @elseif($mahasiswa->status_daftar_ulang === 'verified')
                                    <span class="text-xs text-green-600 font-medium">✓ Terverifikasi</span>
                                @elseif($mahasiswa->status_daftar_ulang === 'rejected')
                                    <span class="text-xs text-red-600 font-medium">✗ Ditolak</span>
                                @endif
                            </div>
                         </td>
                    </tr>

                    {{-- Data dokumen tersembunyi untuk modal --}}
                    <tr class="hidden" id="dokumen-data-{{ $mahasiswa->id }}">
                        <td colspan="12">
                            <div class="dokumen-json">{{ $mahasiswa->user->dokumens->map(fn($d) => [
                                'id'    => $d->idDokumen,
                                'jenis' => $d->jenisDokumen,
                                'nama'  => $d->namaFile,
                                'url'   => route('admin.mahasiswa.download-dokumen', [$mahasiswa->id, $d->idDokumen]),
                            ])->toJson() }}</div>
                         </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="12" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="mt-4 text-sm text-gray-500 font-medium">Belum ada mahasiswa yang daftar ulang</p>
                         </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mahasiswas->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $mahasiswas->links() }}
        </div>
        @endif
    </div>

    @endif {{-- end isDekan --}}

</div>

{{-- ══════════════════════════════════════════════════════════════
     MODAL DOKUMEN
     ══════════════════════════════════════════════════════════════ --}}
<div id="dokumenModal"
     class="fixed inset-0 z-50 hidden overflow-y-auto"
     aria-labelledby="modal-title"
     role="dialog"
     aria-modal="true">

    {{-- Backdrop --}}
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeDokumenModal()"></div>

        {{-- Panel --}}
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden">

            <!-- Header modal -->
            <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-4 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-white" id="modal-title">Dokumen Pendaftaran</h3>
                    <p class="text-indigo-200 text-xs mt-0.5" id="modal-subtitle">—</p>
                </div>
                <button onclick="closeDokumenModal()" class="text-white/70 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Isi dokumen -->
            <div id="modal-dokumen-list" class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                {{-- diisi via JS --}}
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-3 flex justify-end border-t border-gray-100">
                <button onclick="closeDokumenModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Icon per jenis dokumen
const dokumenIcons = {
    default: `<svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>`,
    foto   : `<svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`,
};

function getIcon(jenis) {
    const j = jenis.toLowerCase();
    if (j.includes('foto') || j.includes('pas')) return dokumenIcons.foto;
    return dokumenIcons.default;
}

function openDokumenModal(mahasiswaId, nama) {
    const row    = document.getElementById('dokumen-data-' + mahasiswaId);
    const json   = row ? row.querySelector('.dokumen-json').textContent.trim() : '[]';
    const docs   = JSON.parse(json);

    document.getElementById('modal-subtitle').textContent = nama;

    const list = document.getElementById('modal-dokumen-list');
    list.innerHTML = '';

    if (docs.length === 0) {
        list.innerHTML = '<p class="px-6 py-8 text-center text-sm text-gray-400">Tidak ada dokumen yang ditemukan.</p>';
    } else {
        docs.forEach((doc, i) => {
            const ext = doc.nama.split('.').pop().toUpperCase();
            list.innerHTML += `
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-indigo-50/50 transition-colors">
                    <div class="flex-shrink-0">${getIcon(doc.jenis)}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">${doc.jenis}</p>
                        <p class="text-xs text-gray-400 truncate mt-0.5">${doc.nama}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded">${ext}</span>
                        <a href="${doc.url}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm"
                           title="Download ${doc.jenis}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>`;
        });
    }

    document.getElementById('dokumenModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeDokumenModal() {
    document.getElementById('dokumenModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Tutup modal dengan Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDokumenModal();
});
</script>
@endpush

@endsection