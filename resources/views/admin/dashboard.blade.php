@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .scrollbar-thin::-webkit-scrollbar { width: 6px; }
    .scrollbar-thin::-webkit-scrollbar-track { background: #f3f4f6; border-radius: 10px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    .tab-btn.active { 
        background: white; 
        color: #4f46e5 !important; 
        box-shadow: 0 1px 3px rgba(0,0,0,.12);
        border: 1px solid #e0e7ff;
    }
    .disabled-card {
        opacity: 0.5;
        pointer-events: none;
        filter: grayscale(0.1);
    }
    .wawancara-btn.active {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }
    .wawancara-btn {
        transition: all 0.2s ease;
    }
    .wawancara-btn:hover {
        background: #e0e7ff;
        color: #4f46e5;
    }
    .bar-chart-bar {
        transition: width 0.5s ease-out;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-lg p-6 sm:p-8 text-white border border-blue-500/20">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}!</h2>
            <p class="text-blue-100 text-sm sm:text-base">
                @if($isPimpinan)
                    Pantau statistik PMB dengan mudah
                @else
                    Kelola PMB dan pantau sistem dengan mudah
                @endif
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Active</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Total Soal</h3>
            <p class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">{{ $totalSoal ?? 0 }}</p>
            <p class="text-xs text-gray-500">Soal tersedia di bank soal</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">Active</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Total Pendaftar</h3>
            <p class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">{{ $totalUser ?? 0 }}</p>
            <p class="text-xs text-gray-500">Pengguna terdaftar di sistem</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-all duration-200 group {{ $isPimpinan ? 'disabled-card' : 'hover:shadow-xl' }}">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                    {{ $isPimpinan ? 'Disabled' : 'Actions' }}
                </span>
            </div>
            <div class="space-y-2">
            @if(in_array(auth()->user()->role, ['admin', 'super-admin']))
            <h3 class="text-gray-600 text-sm font-medium mb-3">Quick Actions</h3>
                    <a href="{{ route('admin.soal.create') }}" class="flex items-center text-sm {{ $isPimpinan ? 'text-gray-400 cursor-not-allowed' : 'text-blue-600 hover:text-blue-800' }} font-medium group/link">
                        <svg class="w-4 h-4 mr-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Soal Baru
                    </a>
                    <a href="{{ route('admin.soal.index') }}" class="flex items-center text-sm {{ $isPimpinan ? 'text-gray-400 cursor-not-allowed' : 'text-blue-600 hover:text-blue-800' }} font-medium group/link">
                        <svg class="w-4 h-4 mr-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Lihat Semua Soal
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- System Info & Quick Stats - Sembunyikan untuk pimpinan -->
    @if(!$isPimpinan)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Sistem
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600 font-medium">Status Server</span>
                    <span class="inline-flex items-center text-xs font-semibold text-green-800 bg-green-100 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>Online
                    </span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600 font-medium">Database</span>
                    <span class="inline-flex items-center text-xs font-semibold text-green-800 bg-green-100 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>Connected
                    </span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-600 font-medium">Last Update</span>
                    <span class="text-xs font-medium text-gray-700">{{ now()->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Statistik Cepat
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600 font-medium">Admin Login</span>
                    <span class="text-lg font-bold text-gray-900">{{ $totalAdmin }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600 font-medium">Pimpinan Login</span>
                    <span class="text-lg font-bold text-gray-900">{{ $totalPimpinan ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-600 font-medium">Pendaftar</span>
                    <span class="text-lg font-bold text-gray-400">{{ $totalUser ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Manajemen Konten -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Manajemen Konten
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.soal.index') }}" class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition-all duration-200 border border-gray-200 hover:border-blue-300 group">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                        <svg class="w-5 h-5 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Kelola Soal</span>
                </div>
                <p class="text-xs text-gray-600">Lihat, edit, dan hapus soal ujian</p>
            </a>
            <a href="{{ route('admin.soal.create') }}" class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition-all duration-200 border border-gray-200 hover:border-green-300 group">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition-colors">
                        <svg class="w-5 h-5 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Tambah Soal</span>
                </div>
                <p class="text-xs text-gray-600">Buat soal ujian baru</p>
            </a>
            <a href="{{ route('admin.user.index') }}" class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition-all duration-200 border border-gray-200 hover:border-green-300 group">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition-colors">
                        <svg class="w-5 h-5 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Kelola User</span>
                </div>
                <p class="text-xs text-gray-600">Kelola User</p>
            </a>
        </div>
    </div>
    @endif

    <!-- ─── Statistik Asal Daerah & Jenis Kelamin (Semua Pendaftar) ─────────── -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-blue-500 px-8 py-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Statistik Asal Daerah (Semua Pendaftar)</h3>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="regionChart" class="max-h-72"></canvas></div>
                    </div>
                    <div id="regionLegend" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-blue-500 px-8 py-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Statistik Jenis Kelamin (Semua Pendaftar)</h3>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="genderChart" class="max-h-72"></canvas></div>
                    </div>
                    <div id="genderLegend" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── Statistik Asal Daerah & Jenis Kelamin (Mahasiswa Sudah Punya NIM) ── -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-emerald-500 px-8 py-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Statistik Asal Daerah (Mahasiswa Terdaftar)</h3>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="mahasiswaRegionChart" class="max-h-72"></canvas></div>
                    </div>
                    <div id="mahasiswaRegionLegend" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-emerald-500 px-8 py-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Statistik Jenis Kelamin (Mahasiswa Terdaftar)</h3>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="mahasiswaGenderChart" class="max-h-72"></canvas></div>
                    </div>
                    <div id="mahasiswaGenderLegend" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── Statistik Program Studi (Pilihan 1 & 2) ───────────────────────── -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-blue-500 px-8 py-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white">Statistik Program Studi (Pendaftar)</h3>
        </div>
        <div class="px-8 pt-6">
            <div class="inline-flex bg-gray-100 rounded-xl p-1 gap-1">
                <button onclick="switchTab('prodi','1')" id="tab-prodi-1"
                    class="tab-btn active px-5 py-2 rounded-lg text-sm font-semibold text-gray-500 transition-all duration-200">
                    Pilihan 1
                </button>
                <button onclick="switchTab('prodi','2')" id="tab-prodi-2"
                    class="tab-btn px-5 py-2 rounded-lg text-sm font-semibold text-gray-500 transition-all duration-200">
                    Pilihan 2
                </button>
            </div>
        </div>
        <div class="p-8">
            <div id="panel-prodi-1">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="prodiChart1" class="max-h-72"></canvas></div>
                    </div>
                    <div id="prodiLegend1" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
            <div id="panel-prodi-2" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="prodiChart2" class="max-h-72"></canvas></div>
                    </div>
                    <div id="prodiLegend2" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── Statistik Fakultas (Pilihan 1 & 2) ────────────────────────────── -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-blue-500 px-8 py-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white">Statistik Fakultas (Pendaftar)</h3>
        </div>
        <div class="px-8 pt-6">
            <div class="inline-flex bg-gray-100 rounded-xl p-1 gap-1">
                <button onclick="switchTab('fakultas','1')" id="tab-fakultas-1"
                    class="tab-btn active px-5 py-2 rounded-lg text-sm font-semibold text-gray-500 transition-all duration-200">
                    Pilihan 1
                </button>
                <button onclick="switchTab('fakultas','2')" id="tab-fakultas-2"
                    class="tab-btn px-5 py-2 rounded-lg text-sm font-semibold text-gray-500 transition-all duration-200">
                    Pilihan 2
                </button>
            </div>
        </div>
        <div class="p-8">
            <div id="panel-fakultas-1">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="fakultasChart1" class="max-h-72"></canvas></div>
                    </div>
                    <div id="fakultasLegend1" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
            <div id="panel-fakultas-2" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="fakultasChart2" class="max-h-72"></canvas></div>
                    </div>
                    <div id="fakultasLegend2" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── Statistik Mahasiswa (sudah punya NIM) ─────────────────────────── -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-emerald-500 px-8 py-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white">Statistik Mahasiswa Terdaftar (Memiliki NIM)</h3>
        </div>
        <div class="px-8 pt-6">
            <div class="inline-flex bg-gray-100 rounded-xl p-1 gap-1">
                <button onclick="switchTab('mahasiswa','fakultas')" id="tab-mahasiswa-fakultas"
                    class="tab-btn active px-5 py-2 rounded-lg text-sm font-semibold text-gray-500 transition-all duration-200">
                    Per Fakultas
                </button>
                <button onclick="switchTab('mahasiswa','prodi')" id="tab-mahasiswa-prodi"
                    class="tab-btn px-5 py-2 rounded-lg text-sm font-semibold text-gray-500 transition-all duration-200">
                    Per Program Studi
                </button>
            </div>
        </div>
        <div class="p-8">
            <div id="panel-mahasiswa-fakultas">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="mahasiswaFakultasChart" class="max-h-72"></canvas></div>
                    </div>
                    <div id="mahasiswaFakultasLegend" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
            <div id="panel-mahasiswa-prodi" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <div class="flex justify-center">
                        <div class="w-full max-w-xs"><canvas id="mahasiswaProdiChart" class="max-h-72"></canvas></div>
                    </div>
                    <div id="mahasiswaProdiLegend" class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin pr-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── Statistik Jawaban Wawancara ────────────────────────────────────── -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-purple-500 px-8 py-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white">Statistik Jawaban Wawancara</h3>
        </div>
        <div class="px-8 pt-6">
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($pertanyaans as $index => $pertanyaan)
                    <button onclick="showWawancaraStat({{ $pertanyaan->id }}, this)"
                            class="wawancara-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-purple-100 hover:text-purple-600 transition-all {{ $loop->first ? 'active bg-purple-600 text-white' : '' }}"
                            data-id="{{ $pertanyaan->id }}">
                        {{ $index + 1 }}. {{ Str::limit($pertanyaan->pertanyaan, 30) }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="p-8 pt-0">
            @foreach($pertanyaans as $pertanyaan)
                @php
                    $stats = $wawancaraStats[$pertanyaan->id] ?? null;
                @endphp
                <div id="wawancara-panel-{{ $pertanyaan->id }}" 
                     class="wawancara-panel {{ $loop->first ? '' : 'hidden' }}">
                    @if($stats && $stats['total'] > 0)
                        <div class="mb-6">
                            <p class="text-gray-700 font-medium mb-2">{{ $stats['pertanyaan'] }}</p>
                            <p class="text-sm text-gray-500 mb-4">Total responden: {{ $stats['total'] }} orang</p>
                            
                            <div class="space-y-4">
                                @foreach(['a', 'b', 'c', 'd'] as $opsi)
                                    @php
                                        $count = $stats['jawaban'][$opsi];
                                        $percentage = $stats['total'] > 0 ? round(($count / $stats['total']) * 100, 1) : 0;
                                        $optionText = $stats["opsi_$opsi"];
                                        $colors = [
                                            'a' => 'bg-blue-500',
                                            'b' => 'bg-green-500',
                                            'c' => 'bg-yellow-500',
                                            'd' => 'bg-purple-500'
                                        ];
                                    @endphp
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-medium text-gray-700">
                                                <span class="inline-block w-6 h-6 rounded-full {{ $colors[$opsi] }} text-white text-xs text-center leading-6 mr-2">{{ strtoupper($opsi) }}</span>
                                                {{ $optionText }}
                                            </span>
                                            <span class="text-sm text-gray-600">{{ $count }} orang ({{ $percentage }}%)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                            {{-- FIX: Simpan target width di data-width, mulai dari 0% untuk animasi --}}
                                            <div class="bar-chart-bar {{ $colors[$opsi] }} h-3 rounded-full"
                                                 style="width: 0%"
                                                 data-width="{{ $percentage }}%">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500">Belum ada data jawaban untuk pertanyaan ini</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
// Data dari controller
const regionData            = @json($regionStats ?? []);
const genderData            = @json($genderStats ?? []);
const mahasiswaRegionData   = @json($mahasiswaRegionStats ?? []);
const mahasiswaGenderData   = @json($mahasiswaGenderStats ?? []);
const prodiData1            = @json($prodiStats ?? []);
const prodiData2            = @json($prodiStats2 ?? []);
const fakultasData1         = @json($fakultasStats ?? []);
const fakultasData2         = @json($fakultasStats2 ?? []);
const mahasiswaFakultasData = @json($mahasiswaPerFakultas ?? []);
const mahasiswaProdiData    = @json($mahasiswaPerProdi ?? []);

const colors = [
    '#6366f1','#8b5cf6','#ec4899','#f43f5e','#f97316',
    '#f59e0b','#84cc16','#22c55e','#14b8a6','#06b6d4',
    '#3b82f6','#a855f7','#d946ef','#0ea5e9','#10b981'
];
const genderColors   = ['#6366f1','#ec4899','#cbd5e0'];
const emeraldColors  = ['#10b981','#34d399','#6ee7b7','#a7f3d0','#059669','#047857','#065f46','#064e3b'];

// ─── Pelacak instance Chart agar tidak double-render ───────────────────────
const chartInstances = {};

const baseOptions = {
    responsive: true,
    maintainAspectRatio: true,
    cutout: '72%',
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: 'rgba(17,24,39,0.95)',
            padding: 16,
            titleFont: { size: 14, weight: '600' },
            bodyFont:  { size: 13 },
            cornerRadius: 12,
            displayColors: false,
            callbacks: {
                label(ctx) {
                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                    const pct   = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                    return `${ctx.label}: ${ctx.parsed} (${pct}%)`;
                }
            }
        }
    }
};

const mahasiswaOptions = {
    responsive: true,
    maintainAspectRatio: true,
    cutout: '72%',
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: 'rgba(17,24,39,0.95)',
            padding: 16,
            titleFont: { size: 14, weight: '600' },
            bodyFont:  { size: 13 },
            cornerRadius: 12,
            displayColors: false,
            callbacks: {
                label(ctx) {
                    return `${ctx.label}: ${ctx.parsed} Mahasiswa`;
                }
            }
        }
    }
};

// ─── Builder Chart ─────────────────────────────────────────────────────────
function buildChart(canvasId, legendId, data, palette, useMahasiswaOptions = false) {
    // Cegah render ulang jika chart sudah pernah dibuat
    if (chartInstances[canvasId]) return;

    const labels  = Object.keys(data);
    const values  = Object.values(data);
    const legend  = document.getElementById(legendId);
    const options = useMahasiswaOptions ? mahasiswaOptions : baseOptions;

    if (!labels.length) {
        if (legend) legend.innerHTML = '<p class="text-sm text-gray-400 text-center py-8 col-span-2">Tidak ada data</p>';
        return;
    }

    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    chartInstances[canvasId] = new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: values,
                backgroundColor: palette.slice(0, labels.length),
                borderWidth: 0,
                hoverOffset: 12
            }]
        },
        options: options
    });

    const total = values.reduce((a, b) => a + b, 0);
    labels.forEach((label, i) => {
        if (useMahasiswaOptions) {
            legend.innerHTML += `
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-md flex-shrink-0" style="background:${palette[i % palette.length]}"></span>
                        <span class="text-sm text-gray-700">${label}</span>
                    </div>
                    <div class="flex items-baseline gap-2 ml-2">
                        <strong class="text-gray-900">${values[i]}</strong>
                        <span class="text-xs text-gray-400">Mahasiswa</span>
                    </div>
                </div>`;
        } else {
            const pct = total > 0 ? ((values[i] / total) * 100).toFixed(1) : 0;
            legend.innerHTML += `
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-md flex-shrink-0" style="background:${palette[i % palette.length]}"></span>
                        <span class="text-sm text-gray-700">${label}</span>
                    </div>
                    <div class="flex items-baseline gap-2 ml-2">
                        <strong class="text-gray-900">${values[i]}</strong>
                        <span class="text-xs text-gray-400">${pct}%</span>
                    </div>
                </div>`;
        }
    });
}

// ─── Animasi bar chart (baca dari data-width) ──────────────────────────────
function animateBars(container) {
    const bars = (container || document).querySelectorAll('.bar-chart-bar');
    bars.forEach(bar => {
        const target = bar.dataset.width || '0%';
        bar.style.width = '0%';
        // Pastikan reset selesai sebelum animasi mulai
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                bar.style.width = target;
            });
        });
    });
}

// ─── Inisialisasi saat DOM ready ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    // Chart yang langsung terlihat saat halaman pertama dibuka
    buildChart('regionChart',           'regionLegend',           regionData,           colors,        false);
    buildChart('genderChart',           'genderLegend',           genderData,           genderColors,  false);
    buildChart('mahasiswaRegionChart',  'mahasiswaRegionLegend',  mahasiswaRegionData,  colors,        true);
    buildChart('mahasiswaGenderChart',  'mahasiswaGenderLegend',  mahasiswaGenderData,  genderColors,  true);

    // Tab aktif awal (Pilihan 1 & Per Fakultas)
    buildChart('prodiChart1',           'prodiLegend1',           prodiData1,           colors,        false);
    buildChart('fakultasChart1',        'fakultasLegend1',        fakultasData1,        colors,        false);
    buildChart('mahasiswaFakultasChart','mahasiswaFakultasLegend',mahasiswaFakultasData,emeraldColors, true);

    setActiveTab('prodi',      '1',       ['1','2']);
    setActiveTab('fakultas',   '1',       ['1','2']);
    setActiveTab('mahasiswa',  'fakultas',['fakultas','prodi']);

    // Animasi bar wawancara panel pertama
    setTimeout(() => animateBars(), 300);
});

function setActiveTab(group, activeNum, options) {
    options.forEach(num => {
        const panel = document.getElementById(`panel-${group}-${num}`);
        const tab   = document.getElementById(`tab-${group}-${num}`);
        const isActive = num === activeNum;

        panel.classList.toggle('hidden', !isActive);

        // Hapus semua state dulu
        tab.classList.remove('active', 'bg-white', 'text-indigo-600', 'shadow', 'border', 'border-indigo-100', 'text-gray-500');

        if (isActive) {
            tab.classList.add('bg-white', 'text-indigo-600', 'shadow', 'border', 'border-indigo-100');
        } else {
            tab.classList.add('text-gray-500');
        }
    });
}

// ─── Switch Tab ────────────────────────────────────────────────────────────
function switchTab(group, num) {
    if (group === 'prodi') {
        setActiveTab('prodi', num, ['1', '2']);
        if (num === '2') buildChart('prodiChart2', 'prodiLegend2', prodiData2, colors, false);

    } else if (group === 'fakultas') {
        setActiveTab('fakultas', num, ['1', '2']);
        if (num === '2') buildChart('fakultasChart2', 'fakultasLegend2', fakultasData2, colors, false);

    } else if (group === 'mahasiswa') {
        setActiveTab('mahasiswa', num, ['fakultas', 'prodi']);
        if (num === 'prodi') buildChart('mahasiswaProdiChart', 'mahasiswaProdiLegend', mahasiswaProdiData, colors, true);
    }
}

// ─── Wawancara ─────────────────────────────────────────────────────────────
function showWawancaraStat(pertanyaanId, button) {
    // Sembunyikan semua panel
    document.querySelectorAll('.wawancara-panel').forEach(panel => {
        panel.classList.add('hidden');
    });

    // Tampilkan panel yang dipilih
    const targetPanel = document.getElementById(`wawancara-panel-${pertanyaanId}`);
    if (targetPanel) {
        targetPanel.classList.remove('hidden');
        // FIX: Animasi bar menggunakan data-width
        setTimeout(() => animateBars(targetPanel), 100);
    }

    // Update active state tombol
    document.querySelectorAll('.wawancara-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-purple-600', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    button.classList.remove('bg-gray-100', 'text-gray-700');
    button.classList.add('active', 'bg-purple-600', 'text-white');
}
</script>

@endsection

