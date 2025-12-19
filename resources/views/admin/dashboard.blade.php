@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-lg p-6 sm:p-8 text-white border border-blue-500/20">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-blue-100 text-sm sm:text-base">Kelola soal ujian dan pantau sistem dengan mudah</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-1xl sm:text-2xl font-bold shadow-lg">
                    {{ strtoupper(substr(Auth::user()->username, 0, 10)) }}


                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Total Soal Card -->
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

        <!-- Total Member Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-3 py-1 rounded-full">Soon</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Total Member</h3>
            <p class="text-3xl sm:text-4xl font-bold text-gray-400 mb-2">{{ $totalUser }}</p>
            <p class="text-xs text-gray-400">anda bisa kelola di panel kelola user</p>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-200 group md:col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">Actions</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-3">Quick Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.soal.create') }}"
                   class="flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium group/link">
                    <svg class="w-4 h-4 mr-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Soal Baru
                </a>
                <a href="{{ route('admin.soal.index') }}"
                   class="flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium group/link">
                    <svg class="w-4 h-4 mr-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Lihat Semua Soal
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity / Info Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- System Info Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h3 class="text-lg sm:text-xl font-bold text-white flex items-center">
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
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        Online
                    </span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600 font-medium">Database</span>
                    <span class="inline-flex items-center text-xs font-semibold text-green-800 bg-green-100 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        Connected
                    </span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-600 font-medium">Last Update</span>
                    <span class="text-xs font-medium text-gray-700">{{ now()->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <h3 class="text-lg sm:text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Statistik Cepat
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600 font-medium">Soal Aktif</span>
                    <span class="text-lg font-bold text-gray-900">{{ $totalSoal ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600 font-medium">Admin Login</span>
                    <span class="text-lg font-bold text-gray-900">{{ $totalAdmin }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-600 font-medium">User Login</span>
                    <span class="text-lg font-bold text-gray-400">{{ $totalUser ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Manajemen Konten
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.soal.index') }}"
               class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition-all duration-200 border border-gray-200 hover:border-blue-300 group">
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

            <a href="{{ route('admin.soal.create') }}"
               class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition-all duration-200 border border-gray-200 hover:border-green-300 group">
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

            <a href="{{ route('admin.user.index') }}"
               class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition-all duration-200 border border-gray-200 hover:border-green-300 group">
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

</div>
@endsection
