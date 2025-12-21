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

    <!-- Statistik Pendaftar -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Statistik Asal Daerah -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h3 class="text-lg sm:text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Statistik Asal Daerah
                </h3>
            </div>
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <canvas id="regionChart" class="max-h-80"></canvas>
                </div>
                <div id="regionLegend" class="mt-4 space-y-2 max-h-60 overflow-y-auto"></div>
            </div>
        </div>

        <!-- Statistik Jenis Kelamin -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
                <h3 class="text-lg sm:text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Statistik Jenis Kelamin
                </h3>
            </div>
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <canvas id="genderChart" class="max-h-80"></canvas>
                </div>
                <div id="genderLegend" class="mt-4 space-y-2"></div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data dari Controller (dummy data, ganti dengan data real dari controller)
    const regionData = @json($regionStats ?? []);
    const genderData = @json($genderStats ?? []);

    // Warna untuk chart
    const colors = [
        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
        '#EC4899', '#14B8A6', '#F97316', '#06B6D4', '#84CC16',
        '#6366F1', '#A855F7', '#D946EF', '#0EA5E9', '#22C55E'
    ];

    // Chart Asal Daerah
    if (regionData && Object.keys(regionData).length > 0) {
        const regionLabels = Object.keys(regionData);
        const regionValues = Object.values(regionData);
        
        const regionCtx = document.getElementById('regionChart').getContext('2d');
        const regionChart = new Chart(regionCtx, {
            type: 'doughnut',
            data: {
                labels: regionLabels,
                datasets: [{
                    data: regionValues,
                    backgroundColor: colors.slice(0, regionLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
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
            }
        });

        // Custom Legend untuk Asal Daerah
        const regionLegendContainer = document.getElementById('regionLegend');
        const total = regionValues.reduce((a, b) => a + b, 0);
        
        regionLabels.forEach((label, index) => {
            const value = regionValues[index];
            const percentage = ((value / total) * 100).toFixed(1);
            const legendItem = document.createElement('div');
            legendItem.className = 'flex items-center justify-between p-2 rounded hover:bg-gray-50';
            legendItem.innerHTML = `
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded mr-2" style="background-color: ${colors[index]}"></span>
                    <span class="text-sm font-medium text-gray-700">${label}</span>
                </div>
                <span class="text-sm font-bold text-gray-900">${value} <span class="text-xs text-gray-500">(${percentage}%)</span></span>
            `;
            regionLegendContainer.appendChild(legendItem);
        });
    } else {
        document.getElementById('regionChart').parentElement.innerHTML = '<p class="text-center text-gray-500 py-8">Belum ada data pendaftar</p>';
    }

    // Chart Jenis Kelamin
    if (genderData && Object.keys(genderData).length > 0) {
        const genderLabels = Object.keys(genderData);
        const genderValues = Object.values(genderData);
        const genderColors = ['#3B82F6', '#EC4899', '#9CA3AF']; // Biru, Pink, Abu-abu
        
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderLabels,
                datasets: [{
                    data: genderValues,
                    backgroundColor: genderColors.slice(0, genderLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
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
            }
        });

        // Custom Legend untuk Jenis Kelamin
        const genderLegendContainer = document.getElementById('genderLegend');
        const totalGender = genderValues.reduce((a, b) => a + b, 0);
        
        genderLabels.forEach((label, index) => {
            const value = genderValues[index];
            const percentage = ((value / totalGender) * 100).toFixed(1);
            const legendItem = document.createElement('div');
            legendItem.className = 'flex items-center justify-between p-3 rounded hover:bg-gray-50';
            legendItem.innerHTML = `
                <div class="flex items-center">
                    <span class="w-6 h-6 rounded-full mr-3" style="background-color: ${genderColors[index]}"></span>
                    <span class="text-sm font-medium text-gray-700">${label}</span>
                </div>
                <span class="text-lg font-bold text-gray-900">${value} <span class="text-xs text-gray-500">(${percentage}%)</span></span>
            `;
            genderLegendContainer.appendChild(legendItem);
        });
    } else {
        document.getElementById('genderChart').parentElement.innerHTML = '<p class="text-center text-gray-500 py-8">Belum ada data pendaftar</p>';
    }
});
</script>

@endsection