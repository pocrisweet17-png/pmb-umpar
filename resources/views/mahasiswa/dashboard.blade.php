@extends('layouts.app')

@section('content')
{{-- ================================================================ --}}
{{-- ENHANCED STYLES - Animations & Micro-interactions               --}}
{{-- ================================================================ --}}
<style>
    /* Page Load Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes progressFill {
        from { width: 0; }
    }
    
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(59, 130, 246, 0); }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .animate-scale-in {
        animation: scaleIn 0.4s ease-out forwards;
        opacity: 0;
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-600 { animation-delay: 0.6s; }
    .delay-700 { animation-delay: 0.7s; }
    .delay-800 { animation-delay: 0.8s; }
    
    .progress-bar-animated {
        animation: progressFill 1s ease-out 0.5s forwards;
    }
    
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
    }
    
    .hover-glow:hover {
        box-shadow: 0 0 30px rgba(59, 130, 246, 0.15);
    }
    
    .card-shine {
        position: relative;
        overflow: hidden;
    }
    
    .card-shine::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.6s ease;
    }
    
    .card-shine:hover::before {
        left: 100%;
    }
    
    .step-circle {
        transition: all 0.3s ease;
    }
    
    .step-circle:hover {
        transform: scale(1.1);
    }
    
    .btn-primary {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .btn-primary::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }
    
    .btn-primary:hover::after {
        width: 300px;
        height: 300px;
    }
    
    .btn-primary:active {
        transform: scale(0.97);
    }
    
    .gradient-border {
        position: relative;
        background: white;
        border-radius: 1rem;
    }
    
    .gradient-border::before {
        content: '';
        position: absolute;
        inset: 0;
        padding: 2px;
        border-radius: 1rem;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6, #3b82f6);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gradient-border:hover::before {
        opacity: 1;
    }
    
    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Tooltip */
    .tooltip {
        position: relative;
    }
    
    .tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-4px);
        padding: 6px 12px;
        background: #1e293b;
        color: white;
        font-size: 12px;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        z-index: 50;
    }
    
    .tooltip:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(-8px);
    }
    
    /* Glass Effect */
    .glass {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Skeleton Loading */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
</style>

{{-- ================================================================ --}}
{{-- WRAPPER UTAMA: SIDEBAR + MAIN CONTENT                           --}}
{{-- ================================================================ --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100">

    {{-- Include Sidebar --}}
    @include('partials.sidebar-user')

    {{-- Mobile Header dengan Toggle Sidebar --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-20 glass border-b border-gray-200/50 animate-fade-in">
        <div class="flex items-center justify-between px-4 h-16">
            <button onclick="toggleSidebar()" class="p-2.5 rounded-xl hover:bg-gray-100 text-gray-600 active:scale-95 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-14 h-12 p-2 bg-blue-600 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('img/1. c. logo PMB white.png') }}" alt="umpar-dashboard" class="w-10 h-10 m-2">
                </div>
                <span class="font-bold text-gray-900">PMB Online</span>
            </div>
            <button onclick="openModalLihatDataPribadi()" class="p-2.5 rounded-xl hover:bg-gray-100 text-gray-600 active:scale-95 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </button>
        </div>
    </header>

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT AREA                                            --}}
    {{-- ============================================================ --}}
    <main class="lg:ml-[272px] min-h-screen transition-all duration-500">
        
        {{-- Spacer untuk mobile header --}}
        <div class="lg:hidden h-16"></div>

        {{-- Content Container --}}
        <div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto custom-scroll">
            
            {{-- Welcome Header --}}
            <div class="mb-8 animate-fade-in-up">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-2xl">👋</span>
                            <p class="text-gray-500 text-sm font-medium">Selamat datang kembali!</p>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                            Halo, <span class="text-blue-600">{{ $user->name }}</span>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">NIM: {{ $user->nim ?? '-' }} • Kelola pendaftaran Anda di sini</p>
                    </div>
                    <div class="flex items-center gap-3 animate-slide-in-right delay-200">
                        <button onclick="openModalLihatDataPribadi()" class="hidden sm:flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 hover:border-gray-300 hover:shadow-md active:scale-[0.98] transition-all duration-200">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Lihat Profil
                        </button>
                    </div>
                </div>
            </div>

            {{-- Progress Overview Card --}}
            <div class="mb-8 animate-fade-in-up delay-100">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover-lift hover-glow overflow-hidden">
                    {{-- Card Header with Gradient --}}
                    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-6 py-5 sm:px-8 sm:py-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">Progress Pendaftaran</h2>
                                    <p class="text-blue-100 text-sm mt-0.5">Lengkapi semua tahap untuk menyelesaikan pendaftaran</p>
                                </div>
                            </div>
                            @php
                                $completedSteps = collect($steps)->where('completed', true)->count();
                                $totalSteps = count($steps);
                                $progressPercent = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-white">{{ $progressPercent }}%</div>
                                    <p class="text-blue-200 text-xs">{{ $completedSteps }}/{{ $totalSteps }} selesai</p>
                                </div>
                                <div class="hidden sm:block w-16 h-16">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <path class="text-white/20" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                        <path class="text-white" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-dasharray="{{ $progressPercent }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Progress Bar --}}
                    <div class="px-6 sm:px-8 py-5">
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 rounded-full transition-all duration-1000 ease-out progress-bar-animated" 
                                 style="width: {{ $progressPercent }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Wizard Steps - Desktop --}}
                    <div class="px-6 sm:px-8 pb-6 hidden lg:block">
                        <div class="relative">
                            {{-- Connecting Line --}}
                            <div class="absolute top-6 left-0 right-0 h-0.5 bg-gray-200" style="margin: 0 60px;"></div>
                            <div class="absolute top-6 left-0 h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-1000" style="margin-left: 60px; width: calc({{ $progressPercent }}% - 60px);"></div>
                            
                            <div class="flex items-start justify-between relative">
                                @foreach($steps as $index => $step)
                                <div class="flex flex-col items-center group" style="flex: 1;">
                                    {{-- Step Circle --}}
                                    <div class="relative z-10 mb-3 step-circle tooltip" data-tooltip="{{ $step['name'] }}">
                                        @if($step['completed'])
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 ring-4 ring-blue-100">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        @elseif($step['enabled'])
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 ring-4 ring-blue-100 animate-pulse">
                                                <span class="text-white font-bold">{{ $index + 1 }}</span>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gray-100 border-2 border-gray-200 flex items-center justify-center group-hover:border-gray-300 transition-colors">
                                                <span class="text-gray-400 font-semibold">{{ $index + 1 }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Step Label --}}
                                    <div class="text-center max-w-[100px]">
                                        <p class="text-xs font-medium {{ $step['completed'] ? 'text-blue-600' : ($step['enabled'] ? 'text-blue-600' : 'text-gray-400') }} leading-tight transition-colors">
                                            {{ $step['name'] }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Next Step Action --}}
                    @if($nextStep)
                    <div class="px-6 sm:px-8 pb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-600/30">
                                    <svg class="w-5 h-5 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Langkah selanjutnya</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $nextStep['name'] }}</p>
                                </div>
                            </div>
                            @php
                                $nextModalFunctions = [
                                    'is_prodi_selected' => 'openModalProdi()',
                                    'is_bayar_pendaftaran' => 'openModalBayarPendaftaran()',
                                    'is_data_completed' => 'openModalIsiDataPribadi()',
                                    'is_dokumen_uploaded' => 'openModalUploadDokumen()',
                                    'is_tes_selesai' => 'openModalTes()',
                                    'is_wawancara_selesai' => 'openModalWawancara()',
                                    'is_daftar_ulang' => 'openModalDaftarUlang()',
                                    'is_ukt_paid' => 'openModalBayarUkt()'
                                ];
                                $nextModalFunction = $nextModalFunctions[$nextStep['key']] ?? null;
                            @endphp
                            @if($nextModalFunction)
                            <button onclick="{{ $nextModalFunction }}" class="btn-primary w-full sm:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-600/25 transition-all duration-300">
                                Lanjutkan Sekarang
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Section Title --}}
            <div class="mb-6 animate-fade-in-up delay-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Detail Tahapan</h3>
                        <p class="text-gray-500 text-sm">Klik untuk memulai atau melihat detail</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            {{ $completedSteps }} Selesai
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                            {{ $totalSteps - $completedSteps }} Tersisa
                        </span>
                    </div>
                </div>
            </div>

            {{-- Steps Detail Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                @foreach($steps as $index => $step)
                <div class="animate-fade-in-up delay-{{ ($index + 3) * 100 }}">
                    <div class="card-shine gradient-border bg-white rounded-2xl border {{ $step['completed'] ? 'border-blue-200' : ($step['enabled'] ? 'border-blue-100' : 'border-gray-100') }} hover-lift transition-all duration-300 overflow-hidden group">
                        
                        {{-- Card Status Bar --}}
                        <div class="h-1 {{ $step['completed'] ? 'bg-gradient-to-r from-green-400 to-emerald-500' : ($step['enabled'] ? 'bg-gradient-to-r from-blue-400 to-blue-600' : 'bg-gray-200') }}"></div>
                        
                        <div class="p-5 sm:p-6">
                            <div class="flex items-start gap-4">
                                {{-- Step Indicator --}}
                                <div class="flex-shrink-0">
                                    @if($step['completed'])
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-lg shadow-green-500/25 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @elseif($step['enabled'])
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300" style="animation: pulse-glow 2s infinite;">
                                            <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors duration-300">
                                            <span class="text-gray-400 font-bold text-lg">{{ $index + 1 }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    {{-- Step Title & Badge --}}
                                    <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                        <h4 class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $step['name'] }}</h4>
                                        @if($step['completed'])
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Selesai
                                            </span>
                                        @elseif($step['enabled'])
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 animate-pulse">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Terkunci
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Description --}}
                                    <p class="text-sm text-gray-500 mb-4 leading-relaxed">
                                        @if($step['completed'])
                                            Data telah tersimpan dan terverifikasi oleh sistem.
                                        @elseif($step['enabled'])
                                            Silakan lengkapi tahap ini untuk melanjutkan proses.
                                        @else
                                            Selesaikan tahap sebelumnya untuk membuka langkah ini.
                                        @endif
                                    </p>

                                    {{-- Action Button --}}
                                    @php
                                        $modalFunctions = [
                                            'is_prodi_selected' => 'openModalProdi()',
                                            'is_bayar_pendaftaran' => 'openModalBayarPendaftaran()',
                                            'is_data_completed' => 'openModalIsiDataPribadi()',
                                            'is_dokumen_uploaded' => 'openModalUploadDokumen()',
                                            'is_tes_selesai' => 'openModalTes()',
                                            'is_wawancara_selesai' => 'openModalWawancara()',
                                            'is_daftar_ulang' => 'openModalDaftarUlang()',
                                            'is_ukt_paid' => 'openModalBayarUkt()'
                                        ];
                                        $modalFunction = $modalFunctions[$step['key']] ?? null;
                                    @endphp

                                    @if($step['completed'])
                                        <div class="flex items-center gap-2 text-green-600">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Terverifikasi</span>
                                        </div>
                                    @elseif($step['enabled'] && $modalFunction)
                                        <button onclick="{{ $modalFunction }}" 
                                                class="btn-primary inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-blue-600/25 transition-all duration-300">
                                            <span>Mulai Sekarang</span>
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    @else
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Menunggu tahap sebelumnya</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Completion Message --}}
            @if($percent == 100)
            <div class="mt-8 animate-scale-in">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 sm:p-8 shadow-xl shadow-green-500/25 overflow-hidden relative">
                    {{-- Decorative Elements --}}
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                    
                    <div class="relative flex flex-col sm:flex-row items-center gap-6">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-center sm:text-left">
                            <h3 class="text-2xl font-bold text-white mb-2">🎉 Selamat! Pendaftaran Selesai</h3>
                            <p class="text-green-100">Anda telah menyelesaikan semua tahap pendaftaran mahasiswa baru. Silakan tunggu informasi selanjutnya.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Footer Spacing --}}
            <div class="h-8"></div>

        </div>
    </main>

</div>

{{-- ================================================================ --}}
{{-- SCRIPTS - TIDAK ADA PERUBAHAN LOGIC                             --}}
{{-- ================================================================ --}}
@push('scripts')
<script>
// DEBUG LOGGING 
console.group('📍 Route Debug Info');
@foreach($steps as $index => $step)
console.log('Step {{ $index + 1 }}: {{ $step["name"] }}', {
    route: '{{ route($step["route"]) }}',
    enabled: {{ $step['enabled'] ? 'true' : 'false' }},
    completed: {{ $step['completed'] ? 'true' : 'false' }}
});
@endforeach
console.groupEnd();

console.log('👤 User Status:', {
    id: {{ $user->id }},
    prodi_selected: {{ $user->is_prodi_selected ? 'true' : 'false' }},
    bayar_pendaftaran: {{ $user->is_bayar_pendaftaran ? 'true' : 'false' }},
    data_completed: {{ $user->is_data_completed ? 'true' : 'false' }},
    dokumen_uploaded: {{ $user->is_dokumen_uploaded ? 'true' : 'false' }}
});


// SIMPLE MODAL CONTROLLER

function openModal(modalId) {
    console.log(`🔓 Opening: ${modalId}`);
    const modal = document.getElementById(modalId);
    
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        console.log(`✅ Success`);
    } else {
        console.error(`❌ Not found!`);
    }
}

function closeModal(modalId, shouldReload = false) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        if (shouldReload) {
            setTimeout(() => window.location.reload(), 300);
        }
    }
}

// Modal Functions
function openModalProdi() { openModal('modalProdi'); }
function closeModalProdi(reload = true) { closeModal('modalProdi', reload); }

function openModalBayarPendaftaran() { openModal('modalBayarPendaftaran'); }
function closeModalBayarPendaftaran(reload = true) { closeModal('modalBayarPendaftaran', reload); }

function openModalIsiDataPribadi() { openModal('modalIsiDataPribadi'); }
function closeModalIsiDataPribadi(reload = true) { closeModal('modalIsiDataPribadi', reload); }

function openModalDataPribadi() { openModalIsiDataPribadi(); }

function openModalLihatDataPribadi() { openModal('modalLihatDataPribadi'); }
function closeModalLihatDataPribadi() { closeModal('modalLihatDataPribadi', false); }

function openModalUploadDokumen() { openModal('modalUploadDokumen'); }
function closeModalUploadDokumen(reload = true) { closeModal('modalUploadDokumen', reload); }

function openModalTes() { openModal('modalTes'); }
function closeModalTes(reload = true) { closeModal('modalTes', reload); }

function openModalWawancara() { openModal('modalWawancara'); }
function closeModalWawancara(reload = true) { closeModal('modalWawancara', reload); }

function openModalDaftarUlang() { openModal('modalDaftarUlang'); }
function closeModalDaftarUlang(reload = true) { closeModal('modalDaftarUlang', reload); }

function openModalBayarUkt() { openModal('modalBayarUkt'); }
function closeModalBayarUkt(reload = true) { closeModal('modalBayarUkt', reload); }

function checkAndOpenNextModal() {
    fetch('/api/check-registration-status', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.prodi_selected) openModalProdi();
        else if (!data.pembayaran_completed) openModalBayarPendaftaran();
        else if (!data.data_pribadi_completed) openModalIsiDataPribadi();
        else if (!data.dokumen_uploaded) openModalUploadDokumen();
        else if (!data.tes_selesai) openModalTes();
        else if (!data.wawancara_selesai) openModalWawancara();
        else if (!data.ukt_paid) openModalBayarUkt();
        else if (!data.daftar_ulang) openModalDaftarUlang();
        else window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        openModalProdi();
    });
}

// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    console.group('🔍 Modal Check');
    ['modalProdi', 'modalBayarPendaftaran', 'modalIsiDataPribadi', 'modalLihatDataPribadi', 
     'modalUploadDokumen', 'modalTes', 'modalWawancara', 'modalDaftarUlang', 'modalBayarPendaftaranUlang'].forEach(id => {
        console.log(document.getElementById(id) ? `✅ ${id}` : `❌ ${id}`);
    });
    console.groupEnd();
});
</script>
@endpush
@endsection

{{-- Include Modal Components - TETAP SAMA --}}
@include('partials.modals.modal-prodi')
@include('partials.modals.isi-data-pribadi')
@include('partials.modals.lihat-data-pribadi')
@include('partials.modals.modal-bayar-pendaftaran')
@include('partials.modals.modal-upload-dokumen')
@include('partials.modals.modal-tes')
@include('partials.modals.modal-wawancara')
@include('partials.modals.modal-daftar-ulang')
@include('partials.modals.modal-bayar-ukt')