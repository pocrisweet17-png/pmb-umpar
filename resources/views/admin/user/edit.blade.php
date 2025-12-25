@extends('admin.layouts.app')

@section('title', 'User')
@section('page-title', 'User')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

        <!-- Header -->
        <div class="bg-blue-500 px-6 sm:px-8 py-6">
            <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Data Calon Mahasiswa
            </h3>
            <p class="text-orange-100 mt-1 text-sm">ID User: <span class="font-semibold">{{ $user->id }}</span> | Username: <span class="font-semibold">{{ $user->username }}</span> | No. Registrasi: <span class="font-semibold">{{ $user->nomor_registrasi ?? 'Belum ada' }}</span></p>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Error Notification -->
            @if ($errors->any())
                <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 sm:p-5 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold text-red-800 mb-2">Terdapat kesalahan:</p>
                            <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-600 ml-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Account Information -->
                <div class="bg-blue-50 rounded-xl p-4 sm:p-6 border-2 border-blue-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Akun
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" required value="{{ old('username', $user->username) }}"
                                   placeholder="username_user"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                                   placeholder="user@example.com"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Nomor Registrasi
                            </label>
                            <input type="text" name="nomor_registrasi" value="{{ old('nomor_registrasi', $user->nomor_registrasi) }}"
                                   placeholder="Auto-generated atau manual"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk auto-generate</p>
                        </div>

                        <div class="sm:col-span-2 bg-amber-50 border-2 border-amber-200 rounded-lg p-4">
                            <p class="text-sm text-amber-800 font-medium mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Ubah Password (Opsional)
                            </p>
                            <p class="text-xs text-amber-700 mb-3">Biarkan kosong jika tidak ingin mengubah password</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2 text-sm">
                                        Password Baru
                                    </label>
                                    <input type="password" name="password"
                                           placeholder="Minimal 8 karakter"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-medium mb-2 text-sm">
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" name="password_confirmation"
                                           placeholder="Ulangi password"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6 border-2 border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        Informasi Pribadi
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                   placeholder="Nama lengkap sesuai KTP"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik" required value="{{ old('nik', $user->nik) }}"
                                   placeholder="16 digit NIK"
                                   maxlength="16"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_whatsapp" required value="{{ old('no_whatsapp', $user->no_whatsapp) }}"
                                   placeholder="08xxxxxxxxxx"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                        </div>
                    </div>
                </div>

                <!-- Program Studi Selection -->
                <div class="bg-indigo-50 rounded-xl p-4 sm:p-6 border-2 border-indigo-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Pilihan Program Studi
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Pilihan 1
                            </label>
                            <input type="text" name="pilihan_1" value="{{ $user->programStudiPilihan1?->namaProdi ?? '-' }}"
                                   placeholder="Kode Prodi Pilihan 1"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Pilihan 2
                            </label>
                            <input type="text" name="pilihan_2" value="{{ $user->programStudiPilihan2?->namaProdi ?? '-' }}"
                                   placeholder="Kode Prodi Pilihan 2"
                                   class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                        </div>
                    </div>
                </div>

                <!-- Dokumen Upload -->
                <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-xl p-4 sm:p-6 border-2 border-rose-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Dokumen yang Diupload
                    </h4>

                    @if($user->dokumens && $user->dokumens->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($user->dokumens as $dokumen)
                                <div class="bg-white border-2 {{ $dokumen->statusVerifikasi ? 'border-green-300 bg-green-50' : 'border-rose-300' }} rounded-xl p-4 hover:shadow-md transition-all">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center">
                                            @if(in_array(strtolower($dokumen->formatFile), ['jpg', 'jpeg', 'png', 'gif']))
                                                <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            @if($dokumen->statusVerifikasi)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Verified
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <h5 class="font-bold text-gray-900 text-sm">{{ $dokumen->jenisDokumen }}</h5>
                                        <p class="text-xs text-gray-600 truncate" title="{{ $dokumen->namaFile }}">{{ $dokumen->namaFile }}</p>
                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span class="uppercase font-semibold text-rose-600">{{ $dokumen->formatFile }}</span>
                                            <span>{{ \Carbon\Carbon::parse($dokumen->tanggalUpload)->format('d M Y') }}</span>
                                        </div>

                                        @if($dokumen->catatanVerifikasi)
                                            <div class="mt-2 p-2 bg-amber-50 border border-amber-200 rounded-lg">
                                                <p class="text-xs text-amber-800">
                                                    <span class="font-semibold">Catatan:</span> {{ $dokumen->catatanVerifikasi }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ asset('storage/' . $dokumen->urlFile) }}" target="_blank"
                                           class="flex-1 bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold py-2 px-3 rounded-lg transition-colors flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat
                                        </a>
                                        <a href="{{ asset('storage/' . $dokumen->urlFile) }}" download
                                           class="flex-1 bg-gray-500 hover:bg-gray-600 text-white text-xs font-semibold py-2 px-3 rounded-lg transition-colors flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Unduh
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white border-2 border-dashed border-rose-300 rounded-xl p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-rose-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada dokumen yang diupload</p>
                            <p class="text-sm text-gray-400 mt-1">Calon mahasiswa belum mengunggah dokumen persyaratan</p>
                        </div>
                    @endif

                    <div class="mt-4 p-3 bg-white rounded-lg border border-rose-300">
                        <p class="text-xs text-rose-800 flex items-start">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Info:</strong> Dokumen yang diupload user akan muncul di sini. Anda dapat melihat, mengunduh, dan memverifikasi dokumen-dokumen tersebut.</span>
                        </p>
                    </div>
                </div>

                <!-- PMB Progress Steps - Verifikasi Manual -->
                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-4 sm:p-6 border-2 border-teal-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Progress PMB - Verifikasi Manual
                    </h4>
                    <p class="text-xs text-teal-700 mb-4">Centang untuk memverifikasi setiap tahapan yang sudah diselesaikan calon mahasiswa</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <!-- Step 1: Pilih Prodi -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-teal-200 rounded-lg px-4 py-3 hover:bg-teal-50 transition-colors {{ old('is_prodi_selected', $user->is_prodi_selected) ? 'bg-teal-100 border-teal-400' : '' }}">
                            <input type="checkbox" name="is_prodi_selected" value="1" {{ old('is_prodi_selected', $user->is_prodi_selected) ? 'checked' : '' }}
                                   class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">1. Pilih Prodi</span>
                                <span class="text-xs text-gray-600">Sudah memilih program studi</span>
                            </div>
                        </label>

                        <!-- Step 2: Bayar Pendaftaran -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-teal-200 rounded-lg px-4 py-3 hover:bg-teal-50 transition-colors {{ old('is_bayar_pendaftaran', $user->is_bayar_pendaftaran) ? 'bg-teal-100 border-teal-400' : '' }}">
                            <input type="checkbox" name="is_bayar_pendaftaran" value="1" {{ old('is_bayar_pendaftaran', $user->is_bayar_pendaftaran) ? 'checked' : '' }}
                                   class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">2. Bayar Pendaftaran</span>
                                <span class="text-xs text-gray-600">Lunas biaya pendaftaran</span>
                            </div>
                        </label>

                        <!-- Step 3: Data Lengkap -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-teal-200 rounded-lg px-4 py-3 hover:bg-teal-50 transition-colors {{ old('is_data_completed', $user->is_data_completed) ? 'bg-teal-100 border-teal-400' : '' }}">
                            <input type="checkbox" name="is_data_completed" value="1" {{ old('is_data_completed', $user->is_data_completed) ? 'checked' : '' }}
                                   class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">3. Data Pribadi</span>
                                <span class="text-xs text-gray-600">Upload data pribadi lengkap</span>
                            </div>
                        </label>

                        <!-- Step 4: Upload Dokumen -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-orange-200 rounded-lg px-4 py-3 hover:bg-orange-50 transition-colors {{ old('is_dokumen_uploaded', $user->is_dokumen_uploaded) ? 'bg-orange-100 border-orange-400' : '' }}">
                            <input type="checkbox" name="is_dokumen_uploaded" value="1" {{ old('is_dokumen_uploaded', $user->is_dokumen_uploaded) ? 'checked' : '' }}
                                   class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">4. Upload Dokumen</span>
                                <span class="text-xs text-gray-600">Dokumen persyaratan lengkap</span>
                            </div>
                        </label>

                        <!-- Step 5: Tes Selesai -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-orange-200 rounded-lg px-4 py-3 hover:bg-orange-50 transition-colors {{ old('is_tes_selesai', $user->is_tes_selesai) ? 'bg-orange-100 border-orange-400' : '' }}">
                            <input type="checkbox" name="is_tes_selesai" value="1" {{ old('is_tes_selesai', $user->is_tes_selesai) ? 'checked' : '' }}
                                   class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">5. Tes Selesai</span>
                                <span class="text-xs text-gray-600">Sudah mengikuti tes</span>
                            </div>
                        </label>

                        <!-- Step 6: Wawancara Selesai -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-orange-200 rounded-lg px-4 py-3 hover:bg-orange-50 transition-colors {{ old('is_wawancara_selesai', $user->is_wawancara_selesai) ? 'bg-orange-100 border-orange-400' : '' }}">
                            <input type="checkbox" name="is_wawancara_selesai" value="1" {{ old('is_wawancara_selesai', $user->is_wawancara_selesai) ? 'checked' : '' }}
                                   class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">6. Wawancara</span>
                                <span class="text-xs text-gray-600">Sudah mengikuti wawancara</span>
                            </div>
                        </label>

                        <!-- Step 7: Daftar Ulang -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-purple-200 rounded-lg px-4 py-3 hover:bg-purple-50 transition-colors {{ old('is_daftar_ulang', $user->is_daftar_ulang) ? 'bg-purple-100 border-purple-400' : '' }}">
                            <input type="checkbox" name="is_daftar_ulang" value="1" {{ old('is_daftar_ulang', $user->is_daftar_ulang) ? 'checked' : '' }}
                                   class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">7. Daftar Ulang</span>
                                <span class="text-xs text-gray-600">Sudah daftar ulang</span>
                            </div>
                        </label>

                        <!-- Step 8: Bayar UKT -->
                        <label class="flex items-start cursor-pointer bg-white border-2 border-purple-200 rounded-lg px-4 py-3 hover:bg-purple-50 transition-colors {{ old('is_ukt_paid', $user->is_ukt_paid) ? 'bg-purple-100 border-purple-400' : '' }}">
                            <input type="checkbox" name="is_ukt_paid" value="1" {{ old('is_ukt_paid', $user->is_ukt_paid) ? 'checked' : '' }}
                                   class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 focus:ring-2 mt-0.5">
                            <div class="ml-3">
                                <span class="block text-sm font-semibold text-gray-900">8. Bayar UKT</span>
                                <span class="text-xs text-gray-600">Lunas pembayaran UKT</span>
                            </div>
                        </label>
                    </div>

                    <div class="mt-4 p-3 bg-white rounded-lg border border-teal-300">
                        <p class="text-xs text-teal-800 flex items-start">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Catatan:</strong> Verifikasi manual diperlukan untuk step yang tidak otomatis terverifikasi sistem (upload data pribadi, upload dokumen, dan selesai wawancara). Centang checkbox untuk memverifikasi setiap tahapan.</span>
                        </p>
                    </div>
                </div>

                <!-- Role & Status -->
                <div class="bg-purple-50 rounded-xl p-4 sm:p-6 border-2 border-purple-200">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Role & Sudah wawancara
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role" required
                                    class="w-full border-2 border-purple-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all bg-white font-medium text-sm sm:text-base">
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User / Camaba</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Status Verifikasi Email
                            </label>
                            <label class="flex items-center cursor-pointer bg-white border-2 border-purple-300 rounded-xl px-4 py-3 hover:bg-purple-50 transition-colors">
                                <input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}
                                       class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 focus:ring-2">
                                <span class="ml-3 text-sm font-medium text-gray-700">Verifikasi Email manual</span>
                            </label>
                        </div>
                    </div>

                    <p class="text-xs text-purple-700 mt-3 flex items-start">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Admin memiliki akses penuh ke sistem
                    </p>
                </div>

                <!-- Additional Info -->
                <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Dibuat pada:</span>
                            <span class="font-semibold text-gray-900 ml-2">{{ $user->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Terakhir diupdate:</span>
                            <span class="font-semibold text-gray-900 ml-2">{{ $user->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($user->email_verified_at)
                        <div>
                            <span class="text-gray-600">Email verified:</span>
                            <span class="font-semibold text-gray-900 ml-2">{{ \Carbon\Carbon::parse($user->email_verified_at)->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit"
                            class="flex-1 bg-blue-500 text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-amber-500/30 hover:shadow-xl hover:shadow-amber-500/40 hover:from-amber-600 hover:to-orange-700 transition-all duration-200 flex items-center justify-center group text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Update Data Camaba
                    </button>
                    <a href="{{ route('admin.user.index') }}"
                       class="flex-1 bg-gray-500 text-white font-semibold py-3.5 rounded-xl shadow-lg hover:bg-gray-600 hover:shadow-xl transition-all duration-200 flex items-center justify-center group text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection