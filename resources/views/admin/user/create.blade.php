@extends('admin.layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')

@section('content')
<style>
    /* Role card selection styling */
    .role-option {
        position: relative;
        transition: all 0.2s ease;
    }
    .role-option:has(input:checked) {
        border-color: #7c3aed;
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
        box-shadow: 0 0 0 1px #7c3aed, 0 4px 12px rgba(124, 58, 237, 0.15);
    }
    .role-option:has(input:checked) .role-icon {
        color: #7c3aed;
        transform: scale(1.1);
    }
    .role-option:has(input:checked) .role-label {
        color: #5b21b6;
        font-weight: 600;
    }
    .role-option:has(input:checked)::after {
        content: '';
        position: absolute;
        top: 6px;
        right: 6px;
        width: 18px;
        height: 18px;
        background: #7c3aed;
        border-radius: 50%;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white' stroke-width='3'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M5 13l4 4L19 7'/%3E%3C/svg%3E");
        background-size: 12px;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Section card entrance */
    .form-section {
        animation: fadeSlideUp 0.35s ease-out both;
    }
    .form-section:nth-child(1) { animation-delay: 0.05s; }
    .form-section:nth-child(2) { animation-delay: 0.1s; }
    .form-section:nth-child(3) { animation-delay: 0.15s; }
    .form-section:nth-child(4) { animation-delay: 0.2s; }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Input focus glow */
    .form-input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    /* Progress checkbox styling */
    .progress-chip {
        transition: all 0.2s ease;
    }
    .progress-chip:has(input:checked) {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-color: #22c55e;
    }
    .progress-chip:has(input:checked) span {
        color: #15803d;
        font-weight: 600;
    }

    /* Smooth show/hide for conditional sections */
    #camabaFields, #fakultasField {
        transition: opacity 0.3s ease, max-height 0.3s ease;
    }
</style>

<div class="max-w-4xl mx-auto pb-8">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

        {{-- ===== Header ===== --}}
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 sm:px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-white">Formulir Tambah User</h3>
                    <p class="text-green-100 text-sm mt-0.5">Pilih role terlebih dahulu untuk menyesuaikan form</p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8">

            {{-- ===== Error Alert ===== --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 sm:p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-red-800 text-sm">Terdapat kesalahan:</p>
                            <ul class="mt-2 space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-1.5">
                                        <span class="text-red-400 mt-1 flex-shrink-0">&bull;</span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-6" id="userForm">
                @csrf

                {{-- ===== SECTION 1: Role Selection ===== --}}
                <div class="form-section bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-1 flex items-center text-sm sm:text-base">
                        <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center mr-2.5">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        Pilih Role User
                    </h4>
                    <p class="text-xs text-gray-500 mb-4 ml-10">Pilihan role menentukan field yang ditampilkan</p>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        {{-- Camaba --}}
                        <label class="role-option relative flex flex-col items-center gap-2 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-300 hover:shadow-sm" data-role="user">
                            <input type="radio" name="role" value="user" {{ old('role', 'user') == 'user' ? 'checked' : '' }} class="sr-only" required>
                            <svg class="role-icon w-6 h-6 text-gray-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="role-label text-sm font-medium text-gray-600 text-center">Camaba</span>
                        </label>

                        {{-- Admin (super-admin only) --}}
                        @if(auth()->user()->role === 'super-admin')
                            <label class="role-option relative flex flex-col items-center gap-2 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-300 hover:shadow-sm" data-role="admin">
                                <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} class="sr-only">
                                <svg class="role-icon w-6 h-6 text-gray-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="role-label text-sm font-medium text-gray-600 text-center">Admin</span>
                            </label>
                        

                            {{-- Keuangan --}}
                            <label class="role-option relative flex flex-col items-center gap-2 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-300 hover:shadow-sm" data-role="keuangan">
                                <input type="radio" name="role" value="keuangan" {{ old('role') == 'keuangan' ? 'checked' : '' }} class="sr-only">
                                <svg class="role-icon w-6 h-6 text-gray-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="role-label text-sm font-medium text-gray-600 text-center">Keuangan</span>
                            </label>
                        @endif

                        {{-- Admisi --}}
                        <label class="role-option relative flex flex-col items-center gap-2 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-300 hover:shadow-sm" data-role="admisi">
                            <input type="radio" name="role" value="admisi" {{ old('role') == 'admisi' ? 'checked' : '' }} class="sr-only">
                            <svg class="role-icon w-6 h-6 text-gray-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="role-label text-sm font-medium text-gray-600 text-center">Admisi</span>
                        </label>

                        {{-- WR-3 --}}
                        <label class="role-option relative flex flex-col items-center gap-2 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-300 hover:shadow-sm" data-role="wr-3">
                            <input type="radio" name="role" value="wr-3" {{ old('role') == 'wr-3' ? 'checked' : '' }} class="sr-only">
                            <svg class="role-icon w-6 h-6 text-gray-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="role-label text-sm font-medium text-gray-600 text-center">WR-3</span>
                        </label>

                        {{-- Dekan --}}
                        <label class="role-option relative flex flex-col items-center gap-2 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-300 hover:shadow-sm" data-role="dekan">
                            <input type="radio" name="role" value="dekan" {{ old('role') == 'dekan' ? 'checked' : '' }} class="sr-only">
                            <svg class="role-icon w-6 h-6 text-gray-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="role-label text-sm font-medium text-gray-600 text-center">Dekan</span>
                        </label>

                        {{-- Pimpinan --}}
                        <label class="role-option relative flex flex-col items-center gap-2 p-4 bg-white rounded-xl border-2 border-gray-200 cursor-pointer hover:border-purple-300 hover:shadow-sm" data-role="pimpinan">
                            <input type="radio" name="role" value="pimpinan" {{ old('role') == 'pimpinan' ? 'checked' : '' }} class="sr-only">
                            <svg class="role-icon w-6 h-6 text-gray-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="role-label text-sm font-medium text-gray-600 text-center">Pimpinan</span>
                        </label>
                    </div>
                </div>

                {{-- ===== SECTION 2: Account Info ===== --}}
                <div class="form-section bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center mr-2.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        Informasi Akun Dasar
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">
                        <div class="sm:col-span-2">
                            <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap') }}"
                                   placeholder="Masukkan nama lengkap"
                                   class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow bg-white">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" required value="{{ old('username') }}"
                                   placeholder="username"
                                   class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow bg-white">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   placeholder="email@example.com"
                                   class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow bg-white">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" required
                                   placeholder="Minimal 8 karakter"
                                   class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow bg-white">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" required
                                   placeholder="Ulangi password"
                                   class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow bg-white">
                        </div>
                    </div>
                </div>


                {{-- ===== SECTION 3: Camaba-Only Fields ===== --}}
                <div id="camabaFields" class="space-y-6" style="{{ old('role', 'user') == 'user' ? 'display: block' : 'display: none' }}">
                {{-- supaya nik dan lain lain cuma muncul di user --}}
                <div class="form-section bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center mr-2.5">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                        </div>
                        Informasi Identitas
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik_global" id="nik_global"
                                placeholder="16 digit NIK" maxlength="16"
                                value="{{ old('nik') }}"
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm transition-shadow bg-white">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_whatsapp_global" id="no_whatsapp_global"
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('no_whatsapp') }}"
                                class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm transition-shadow bg-white">
                        </div>
                    </div>
                </div>

                   {{-- Program Studi --}}
                    <div class="form-section bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                            <div class="w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center mr-2.5">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            Pilihan Program Studi
                        </h4>

                        @php
                            $namaProdi1 = old('pilihan_1')
                                ? (\App\Models\ProgramStudy::find(old('pilihan_1'))?->namaProdi ?? old('pilihan_1'))
                                : '';
                            $namaProdi2 = old('pilihan_2')
                                ? (\App\Models\ProgramStudy::find(old('pilihan_2'))?->namaProdi ?? old('pilihan_2'))
                                : '';
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">

                            {{-- Pilihan 1 --}}
                            <div>
                                <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                    Pilihan 1 <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="display_pilihan_1" readonly
                                        value="{{ $namaProdi1 }}"
                                        placeholder="Klik untuk memilih prodi"
                                        onclick="openModalProdiAdmin(1)"
                                        class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 cursor-pointer bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow" required>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Pilihan 2 --}}
                            <div>
                                <label class="block text-gray-700 font-medium mb-1.5 text-sm">
                                    Pilihan 2  <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="display_pilihan_2" readonly
                                        value="{{ $namaProdi2 }}"
                                        placeholder="Klik untuk memilih prodi (opsional)"
                                        onclick="openModalProdiAdmin(2)"
                                        class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 cursor-pointer bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow" required>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                  {{-- Progress PMB --}}
                    <div class="form-section bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-200">
                        <h4 class="font-semibold text-gray-800 mb-1 flex items-center text-sm sm:text-base">
                            <div class="w-7 h-7 bg-teal-100 rounded-lg flex items-center justify-center mr-2.5">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            Progress PMB
                        </h4>
                        <p class="text-xs text-gray-500 mb-4 ml-10">Centang tahapan yang sudah diselesaikan</p>

                        <div class="grid gap-2.5">
                            <label class="progress-chip flex items-center gap-2 cursor-pointer bg-white border border-gray-200 rounded-lg px-3 py-2.5 w-auto">
                                <input type="checkbox" name="is_prodi_selected" value="1" {{ old('is_prodi_selected') ? 'checked' : '' }} class="w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-teal-500">
                                <span class="text-xs text-gray-600">Pilih Prodi</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- ===== Hidden fields (synced via JS) ===== --}}
                <input type="hidden" name="nomor_registrasi" id="nomor_registrasi" value="{{ old('nomor_registrasi') }}">
                <input type="hidden" name="nik" id="nik_hidden" value="{{ old('nik') }}">
                <input type="hidden" name="no_whatsapp" id="no_whatsapp_hidden" value="{{ old('no_whatsapp') }}">
                <input type="hidden" name="pilihan_1" id="pilihan_1_hidden" value="{{ old('pilihan_1') }}">
                <input type="hidden" name="pilihan_2" id="pilihan_2_hidden" value="{{ old('pilihan_2') }}">
                <input type="hidden" name="is_prodi_selected" id="is_prodi_selected_hidden" value="{{ old('is_prodi_selected', 0) }}">
                <input type="hidden" name="is_bayar_pendaftaran" id="is_bayar_pendaftaran_hidden" value="{{ old('is_bayar_pendaftaran', 0) }}">
                <input type="hidden" name="is_data_completed" id="is_data_completed_hidden" value="{{ old('is_data_completed', 0) }}">
                <input type="hidden" name="is_dokumen_uploaded" id="is_dokumen_uploaded_hidden" value="{{ old('is_dokumen_uploaded', 0) }}">
                <input type="hidden" name="is_tes_selesai" id="is_tes_selesai_hidden" value="{{ old('is_tes_selesai', 0) }}">
                <input type="hidden" name="is_wawancara_selesai" id="is_wawancara_selesai_hidden" value="{{ old('is_wawancara_selesai', 0) }}">
                <input type="hidden" name="is_ukt_paid" id="is_ukt_paid_hidden" value="{{ old('is_ukt_paid', 0) }}">
                <input type="hidden" name="is_daftar_ulang" id="is_daftar_ulang_hidden" value="{{ old('is_daftar_ulang', 0) }}">

                {{-- ===== Fakultas (dekan only) ===== --}}
                <div id="fakultasField" style="display: {{ old('role') == 'dekan' ? 'block' : 'none' }}" class="form-section bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center mr-2.5">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        Pilih Fakultas
                    </h4>
                    <select name="fakultas_id" class="form-input w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm bg-white">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach(\App\Models\Fakultas::where('is_active', true)->get() as $fak)
                            <option value="{{ $fak->id }}" {{ old('fakultas_id') == $fak->id ? 'selected' : '' }}>
                                {{ $fak->nama_fakultas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ===== Verifikasi Email ===== --}}
                <div class="form-section bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-200">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="is_verified" value="1" {{ old('is_verified') ? 'checked' : '' }}
                               class="w-5 h-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                        <div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Verifikasi Email</span>
                            <p class="text-xs text-gray-500 mt-0.5">Centang jika ingin memverifikasi akun secara manual</p>
                        </div>
                    </label>
                </div>

                {{-- ===== Action Buttons ===== --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl hover:from-green-600 hover:to-emerald-700 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan User
                    </button>
                    <a href="{{ route('admin.user.index') }}"
                       class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 rounded-xl border border-gray-300 hover:bg-gray-200 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleRadios = document.querySelectorAll('input[name="role"]');
    const camabaFields = document.getElementById('camabaFields');
    const fakultasField = document.getElementById('fakultasField');

    const hiddenMappings = [
        { camaba: 'input[name="nik"]', hidden: '#nik_hidden' },
        { camaba: 'input[name="no_whatsapp"]', hidden: '#no_whatsapp_hidden' },
    ];

    const progressMappings = [
        'is_prodi_selected', 'is_bayar_pendaftaran', 'is_data_completed',
        'is_dokumen_uploaded', 'is_tes_selesai', 'is_wawancara_selesai',
        'is_ukt_paid', 'is_daftar_ulang'
    ];

    function syncCamabaToHidden() {
        hiddenMappings.forEach(map => {
            const camabaInput = document.querySelector(map.camaba);
            const hiddenInput = document.querySelector(map.hidden);
            const nikGlobal = document.getElementById('nik_global');
            const waGlobal = document.getElementById('no_whatsapp_global');
            const nikHidden = document.getElementById('nik_hidden');
            const waHidden = document.getElementById('no_whatsapp_hidden');
            if (camabaInput && hiddenInput) {
                hiddenInput.value = camabaInput.value;
            }
            if (nikGlobal && nikHidden) nikHidden.value = nikGlobal.value;
            if (waGlobal && waHidden) waHidden.value = waGlobal.value;
        });

        progressMappings.forEach(progress => {
            const camabaCheckbox = document.querySelector(`input[name="${progress}"]`);
            const hiddenCheckbox = document.querySelector(`#${progress}_hidden`);
            if (camabaCheckbox && hiddenCheckbox) {
                hiddenCheckbox.value = camabaCheckbox.checked ? '1' : '0';
            }
        });
    }

    function toggleFieldsBasedOnRole() {
        const selectedRole = document.querySelector('input[name="role"]:checked');
        if (!selectedRole) return;

        const role = selectedRole.value;
        const isCamaba = role === 'user';

        camabaFields.style.display = isCamaba ? 'block' : 'none';
        fakultasField.style.display = role === 'dekan' ? 'block' : 'none';

        const camabaInputs = camabaFields.querySelectorAll('input, select');
        if (!isCamaba) {
            camabaInputs.forEach(input => { input.disabled = true; });
            generateDummyValues();
            syncCamabaToHidden();
        } else {
            camabaInputs.forEach(input => { input.disabled = false; });
        }
    }

    function generateDummyValues() {
        const timestamp = Date.now();
        const randomStr = Math.random().toString(36).substring(2, 10);

        const nikInput = document.querySelector('input[name="nik"]');

        const waInput = document.querySelector('input[name="no_whatsapp"]');
   

        const dummyReg = 'REG-' + timestamp + '-' + randomStr.toUpperCase();
        const regInput = document.getElementById('nomor_registrasi');
        if (regInput && regInput.value === '') {
            regInput.value = dummyReg;
        }

        const pilihan1Input = document.querySelector('input[name="pilihan_1"]');
        if (pilihan1Input && pilihan1Input.value === '') {
            pilihan1Input.value = '';
        }

        const pilihan2Input = document.querySelector('input[name="pilihan_2"]');
        if (pilihan2Input && pilihan2Input.value === '') {
            pilihan2Input.value = '';
        }

        progressMappings.forEach(progress => {
            const checkbox = document.querySelector(`input[name="${progress}"]`);
            if (checkbox && !checkbox.checked) {
                checkbox.checked = false;
            }
        });
    }

    // Role change listeners
    roleRadios.forEach(radio => {
        radio.addEventListener('change', toggleFieldsBasedOnRole);
    });

    // Form submit sync
    const form = document.getElementById('userForm');
    form.addEventListener('submit', function(e) {
        const selectedRole = document.querySelector('input[name="role"]:checked');
        if (selectedRole && selectedRole.value !== 'user') {
            syncCamabaToHidden();
            const regInput = document.getElementById('nomor_registrasi');
            if (!regInput.value) {
                regInput.value = 'REG-' + Date.now() + '-' + Math.random().toString(36).substring(2, 10).toUpperCase();
            }
        }
        syncCamabaToHidden();
    });

    // Real-time sync for camaba fields
    if (camabaFields) {
        camabaFields.addEventListener('input', function() {
            const selectedRole = document.querySelector('input[name="role"]:checked');
            if (selectedRole && selectedRole.value === 'user') {
                syncCamabaToHidden();
            }
        });

        camabaFields.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                const selectedRole = document.querySelector('input[name="role"]:checked');
                if (selectedRole && selectedRole.value === 'user') {
                    syncCamabaToHidden();
                }
            }
        });
    }
    // Real-time sync NIK & WA global
    const nikGlobalInput = document.getElementById('nik_global');
    const waGlobalInput = document.getElementById('no_whatsapp_global');
    if (nikGlobalInput) nikGlobalInput.addEventListener('input', syncCamabaToHidden);
    if (waGlobalInput) waGlobalInput.addEventListener('input', syncCamabaToHidden);

    // Initial setup
    toggleFieldsBasedOnRole();

    const selectedRole = document.querySelector('input[name="role"]:checked');
    if (selectedRole && selectedRole.value !== 'user') {
        generateDummyValues();
        syncCamabaToHidden();
    }
    let _adminModalTarget = 1;

    window.openModalProdiAdmin = function(target) {
        _adminModalTarget = target;
        document.getElementById('modalProdiAdminTitle').textContent =
            target === 1 ? 'Pilih Program Studi – Pilihan 1' : 'Pilih Program Studi – Pilihan 2';

        const jenjangEl  = document.getElementById('adminModalJenjang');
        const fakultasEl = document.getElementById('adminModalFakultas');
        const prodiEl    = document.getElementById('adminModalProdi');
        const errorEl    = document.getElementById('adminModalError');

        jenjangEl.value     = '';
        fakultasEl.value    = '';
        fakultasEl.disabled = true;
        prodiEl.innerHTML   = '<option value="">-- Pilih Fakultas Dulu --</option>';
        prodiEl.disabled    = true;
        errorEl.classList.add('hidden');

        document.getElementById('modalProdiAdmin').classList.remove('hidden');
    };

    window.closeModalProdiAdmin = function() {
        document.getElementById('modalProdiAdmin').classList.add('hidden');
    };

    document.getElementById('adminModalJenjang').addEventListener('change', function() {
        const fakultasEl = document.getElementById('adminModalFakultas');
        const prodiEl    = document.getElementById('adminModalProdi');

        prodiEl.innerHTML  = '<option value="">-- Pilih Fakultas Dulu --</option>';
        prodiEl.disabled   = true;

        if (this.value) {
            fakultasEl.disabled = false;
            fakultasEl.value    = '';
        } else {
            fakultasEl.disabled = true;
            fakultasEl.value    = '';
        }
    });

    document.getElementById('adminModalFakultas').addEventListener('change', function() {
        const jenjang = document.getElementById('adminModalJenjang').value;
        const prodiEl = document.getElementById('adminModalProdi');

        if (!this.value || !jenjang) return;

        prodiEl.innerHTML = '<option value="">Memuat...</option>';
        prodiEl.disabled  = true;

        fetch(`/api/prodi-by-fakultas?fakultas=${encodeURIComponent(this.value)}&jenjang=${encodeURIComponent(jenjang)}`)
            .then(r => r.json())
            .then(data => {
                const otherHiddenId = _adminModalTarget === 1 ? 'pilihan_2_hidden' : 'pilihan_1_hidden';
                const otherKode     = document.getElementById(otherHiddenId)?.value ?? '';

                prodiEl.innerHTML = '<option value="">-- Pilih Prodi --</option>' +
                    data.map(p =>
                        `<option value="${p.kodeProdi}" ${p.kodeProdi === otherKode ? 'disabled' : ''}>
                            ${p.namaProdi}
                        </option>`
                    ).join('');
                prodiEl.disabled = false;
            })
            .catch(() => {
                prodiEl.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    });

    window.confirmProdiAdmin = function() {
        const prodiEl = document.getElementById('adminModalProdi');
        const errorEl = document.getElementById('adminModalError');

        if (!prodiEl.value) {
            errorEl.textContent = 'Pilih program studi terlebih dahulu.';
            errorEl.classList.remove('hidden');
            return;
        }

        const kode = prodiEl.value;
        const nama = prodiEl.options[prodiEl.selectedIndex].text.trim();

        if (_adminModalTarget === 1) {
            document.getElementById('pilihan_1_hidden').value  = kode;
            document.getElementById('display_pilihan_1').value = nama;
        } else {
            document.getElementById('pilihan_2_hidden').value  = kode;
            document.getElementById('display_pilihan_2').value = nama;
        }

        closeModalProdiAdmin();
    };
});
</script>
{{-- ===== Modal Pilih Prodi Admin ===== --}}
<div id="modalProdiAdmin"
     class="hidden fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
     onclick="closeModalProdiAdmin()">

    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl relative"
         onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg" id="modalProdiAdminTitle">Pilih Program Studi</h3>
            <button type="button" onclick="closeModalProdiAdmin()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors text-xl leading-none">
                &times;
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 space-y-4">

            {{-- Jenjang --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenjang</label>
                <select id="adminModalJenjang"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                    <option value="">-- Pilih Jenjang --</option>
                    <option value="S1">S1 (Sarjana)</option>
                    <option value="S2">S2 (Magister)</option>
                    <option value="S3">S3 (Doktor)</option>
                </select>
            </div>

            {{-- Fakultas --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Fakultas</label>
                <select id="adminModalFakultas"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white"
                        disabled>
                    <option value="">-- Pilih Jenjang Dulu --</option>
                    @foreach(\App\Models\ProgramStudy::select('fakultas')->distinct()->orderBy('fakultas')->pluck('fakultas') as $fak)
                        <option value="{{ $fak }}">{{ $fak }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Program Studi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Program Studi</label>
                <select id="adminModalProdi"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white"
                        disabled>
                    <option value="">-- Pilih Fakultas Dulu --</option>
                </select>
            </div>

            {{-- Error --}}
            <p id="adminModalError" class="text-red-600 text-sm hidden"></p>
        </div>

        {{-- Footer --}}
        <div class="flex gap-3 px-6 pb-6">
            <button type="button" onclick="closeModalProdiAdmin()"
                    class="flex-1 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors">
                Batal
            </button>
            <button type="button" id="adminModalConfirmBtn" onclick="confirmProdiAdmin()"
                    class="flex-1 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                Pilih
            </button>
        </div>
    </div>
</div>
@endsection
