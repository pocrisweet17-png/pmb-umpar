@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 10px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>
@endpush

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
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">Active</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Total Member</h3>
            <p class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">{{ $totalUser ?? 0 }}</p>
            <p class="text-xs text-gray-500">Pengguna terdaftar di sistem</p>
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

    <!-- Statistik Pendaftar -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Statistik Asal Daerah -->
    <div class="group bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-100/50 hover:shadow-3xl transition-all duration-500 hover:-translate-y-1">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-500 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLW9wYWNpdHk9IjAuMSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-20"></div>
            <div class="relative px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-tight">Statistik Asal Daerah</h3>
                </div>
            </div>
        </div>
        <div class="p-8">
            <div class="flex justify-center mb-8">
                <div class="w-full max-w-sm">
                    <canvas id="regionChart" class="max-h-72"></canvas>
                </div>
            </div>
            <div id="regionLegend" class="space-y-2 max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 pr-2"></div>
        </div>
    </div>

    <!-- Statistik Jenis Kelamin -->
    <div class="group bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-100/50 hover:shadow-3xl transition-all duration-500 hover:-translate-y-1">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-500 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLW9wYWNpdHk9IjAuMSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-20"></div>
            <div class="relative px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-tight">Statistik Jenis Kelamin</h3>
                </div>
            </div>
        </div>
        <div class="p-8">
            <div class="flex justify-center mb-8">
                <div class="w-full max-w-sm">
                    <canvas id="genderChart" class="max-h-72"></canvas>
                </div>
            </div>
            <div id="genderLegend" class="space-y-2"></div>
        </div>
    </div>
</div>

</div>

<!-- Chart.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const regionData = @json($regionStats ?? []);
    const genderData = @json($genderStats ?? []);

    // Premium color palette
    const colors = [
        '#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f97316',
        '#f59e0b', '#84cc16', '#22c55e', '#14b8a6', '#06b6d4',
        '#3b82f6', '#a855f7', '#d946ef', '#0ea5e9', '#10b981'
    ];

    const genderColors = ['#6366f1', '#ec4899', '#cbd5e0'];

    // Chart configuration
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '72%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                padding: 16,
                titleFont: { size: 14, weight: '600', family: 'Inter, sans-serif' },
                bodyFont: { size: 13, family: 'Inter, sans-serif' },
                cornerRadius: 12,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        }
    };

    // Chart Asal Daerah
    if (regionData && Object.keys(regionData).length > 0) {
        const regionLabels = Object.keys(regionData);
        const regionValues = Object.values(regionData);
        
        const regionCtx = document.getElementById('regionChart').getContext('2d');
        new Chart(regionCtx, {
            type: 'doughnut',
            data: {
                labels: regionLabels,
                datasets: [{
                    data: regionValues,
                    backgroundColor: colors.slice(0, regionLabels.length),
                    borderWidth: 0,
                    hoverOffset: 12,
                    hoverBorderWidth: 0
                }]
            },
            options: chartOptions
        });

        // Custom Legend Asal Daerah
        const regionLegendContainer = document.getElementById('regionLegend');
        const total = regionValues.reduce((a, b) => a + b, 0);
        
        regionLabels.forEach((label, index) => {
            const value = regionValues[index];
            const percentage = ((value / total) * 100).toFixed(1);
            const legendItem = document.createElement('div');
            legendItem.className = 'flex items-center justify-between p-4 rounded-xl hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100/50 transition-all duration-300 cursor-pointer group/item';
            legendItem.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-md shadow-sm transition-transform duration-300 group-hover/item:scale-110" style="background-color: ${colors[index]}"></span>
                    <span class="text-sm font-medium text-gray-700 group-hover/item:text-gray-900 transition-colors">${label}</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-base font-bold text-gray-900">${value}</span>
                    <span class="text-xs font-medium text-gray-400">${percentage}%</span>
                </div>
            `;
            regionLegendContainer.appendChild(legendItem);
        });
    } else {
        document.getElementById('regionChart').parentElement.innerHTML = `
            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                <svg class="w-16 h-16 mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-medium">No registration data available</p>
            </div>
        `;
    }

    // Chart Jenis Kelamin
    if (genderData && Object.keys(genderData).length > 0) {
        const genderLabels = Object.keys(genderData);
        const genderValues = Object.values(genderData);
        
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderLabels,
                datasets: [{
                    data: genderValues,
                    backgroundColor: genderColors.slice(0, genderLabels.length),
                    borderWidth: 0,
                    hoverOffset: 12,
                    hoverBorderWidth: 0
                }]
            },
            options: chartOptions
        });

        // Custom Legend Jenis Kelamin
        const genderLegendContainer = document.getElementById('genderLegend');
        const totalGender = genderValues.reduce((a, b) => a + b, 0);
        
        genderLabels.forEach((label, index) => {
            const value = genderValues[index];
            const percentage = ((value / totalGender) * 100).toFixed(1);
            const legendItem = document.createElement('div');
            legendItem.className = 'flex items-center justify-between p-5 rounded-xl hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100/50 transition-all duration-300 cursor-pointer group/item';
            legendItem.innerHTML = `
                <div class="flex items-center gap-4">
                    <span class="w-4 h-4 rounded-lg shadow-sm transition-transform duration-300 group-hover/item:scale-110" style="background-color: ${genderColors[index]}"></span>
                    <span class="text-base font-medium text-gray-700 group-hover/item:text-gray-900 transition-colors">${label}</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-xl font-bold text-gray-900">${value}</span>
                    <span class="text-sm font-medium text-gray-400">${percentage}%</span>
                </div>
            `;
            genderLegendContainer.appendChild(legendItem);
        });
    } else {
        document.getElementById('genderChart').parentElement.innerHTML = `
            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                <svg class="w-16 h-16 mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-medium">No registration data available</p>
            </div>
        `;
    }
});
</script>

@endsection