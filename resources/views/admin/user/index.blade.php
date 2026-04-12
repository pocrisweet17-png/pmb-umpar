@extends('admin.layouts.app')

@section('title', 'Daftar User')
@section('page-title', 'Kelola User')

@section('content')
@php
    $isAdmin = auth()->user()->role === 'admin';
    $isAdmisi = auth()->user()->role === 'admisi';
    $isWr3 = auth()->user()->role === 'wr-3';
    $isDekan = auth()->user()->role === 'dekan';
    $isPimpinan = auth()->user()->role === 'pimpinan';
@endphp
<div class="space-y-6">

    <!-- Success/Error Notification -->
    @if (session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fade-in" role="alert" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm" role="alert" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen User</h2>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">Kelola semua pengguna sistem di sini</p>
            </div>
            <a href="{{ $isAdmin ? route('admin.user.create') : '#' }}"
                class="inline-flex items-center justify-center bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3.5 rounded-xl shadow-lg font-semibold group
                        {{ !$isAdmin ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}"
                {{ !$isAdmin ? 'onclick="return false;"' : '' }}>
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User Baru
            </a>
        </div>
    </div>
    <!-- Search & Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <form method="GET" action="{{ route('admin.user.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        🔍 Cari Camaba
                    </label>
                    <div class="relative">
                        <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama, username, email, NIK, WA, atau no registrasi..."
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 pl-11 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="keuangan" {{ request('role') == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="wr-3" {{ request('role') == 'wr-3' ? 'selected' : '' }}>Wakil Rektor 3</option>
                        <option value="admisi" {{ request('role') == 'admisi' ? 'selected' : '' }}>Admisi</option>
                        <option value="dekan" {{ request('role') == 'dekan' ? 'selected' : '' }}>Dekan</option>
                        <option value="pimpinan" {{ request('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    </select>
                </div>

                <!-- Status / Progress Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status / Progress</label>
                    <select name="verified"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Status</option>
                        <optgroup label="── Status Verifikasi ──">
                            <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified</option>
                            <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Unverified</option>
                        </optgroup>
                        <optgroup label="── Progress PMB ──">
                            <option value="step_prodi"        {{ request('verified') === 'step_prodi'        ? 'selected' : '' }}>1. Sudah Pilih Prodi</option>
                            <option value="step_bayar"        {{ request('verified') === 'step_bayar'        ? 'selected' : '' }}>2. Sudah Bayar Pendaftaran</option>
                            <option value="step_data"         {{ request('verified') === 'step_data'         ? 'selected' : '' }}>3. Data Pribadi Lengkap</option>
                            <option value="step_dokumen"      {{ request('verified') === 'step_dokumen'      ? 'selected' : '' }}>4. Dokumen Terupload</option>
                            <option value="step_tes"          {{ request('verified') === 'step_tes'          ? 'selected' : '' }}>5. Tes Selesai</option>
                            <option value="step_wawancara"    {{ request('verified') === 'step_wawancara'    ? 'selected' : '' }}>6. Wawancara Selesai</option>
                            <option value="step_ukt"          {{ request('verified') === 'step_ukt'          ? 'selected' : '' }}>7. Sudah Bayar Pendaftaran Ulang</option>
                            <option value="step_daftar_ulang" {{ request('verified') === 'step_daftar_ulang' ? 'selected' : '' }}>8. Sudah Daftar Ulang</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Filter Fakultas -->
                @if(in_array(auth()->user()->role, ['admin','wr-3','admisi']))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                    <select name="fakultas"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Fakultas</option>
                        @foreach(\App\Models\Fakultas::where('is_active', true)->get() as $fak)
                            <option value="{{ $fak->id }}" {{ request('fakultas') == $fak->id ? 'selected' : '' }}>
                                {{ $fak->nama_fakultas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Filter Prodi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                    <select name="prodi"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Prodi</option>
                        @foreach(\App\Models\ProgramStudy::all() as $prodi)
                            <option value="{{ $prodi->kodeProdi }}" {{ request('prodi') == $prodi->kodeProdi ? 'selected' : '' }}>
                                {{ $prodi->namaProdi }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <button type="submit"
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>

                @if(request('search') || request('role') || request('verified') !== null || request('fakultas') || request('prodi'))
                    <a href="{{ route('admin.user.index') }}"
                        class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-xl font-semibold transition-all shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset Filter
                    </a>

                    <div class="flex items-center text-sm text-gray-600 bg-blue-50 px-4 py-2.5 rounded-xl border border-blue-200">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ $users->count() }}</span>&nbsp;hasil ditemukan
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Total User</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $users->total() }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $users->count() }} ditampilkan di halaman ini</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">User Verified</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalVerified }}</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Admin</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAdmin }}</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

        <!-- Mobile Card View -->
        <div class="lg:hidden divide-y divide-gray-100">
            @forelse ($users as $user)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-bold text-gray-900">{{ $user->nama_lengkap }}</h3>
                                @if($user->role === 'admin')
                                    <span class="text-xs font-semibold text-purple-800 bg-purple-100 px-2 py-1 rounded-full">ADMIN</span>
                                @endif
                                @if($user->is_verified)
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><strong>Username:</strong> {{ $user->username }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>NIK:</strong> {{ $user->nik }}</p>
                                <p><strong>WhatsApp:</strong> {{ $user->no_whatsapp }}</p>
                                <p><strong>Prodi Pilihan 1:</strong> {{ $user->programStudiPilihan1?->namaProdi ?? '-'  }}</p>
                                <p><strong>Prodi Pilihan 2:</strong> {{ $user->programStudiPilihan2?->namaProdi ?? '-'  }}</p>
                                
                            </div>
                        </div>
                    </div>
                    {{-- Progress Steps PMB Mobile --}}
                    @php
                        $steps = [
                            ['field' => 'is_prodi_selected', 'label' => 'Prodi', 'short' => '1'],
                            ['field' => 'is_bayar_pendaftaran', 'label' => 'Bayar', 'short' => '2'],
                            ['field' => 'is_data_completed', 'label' => 'Data', 'short' => '3'],
                            ['field' => 'is_dokumen_uploaded', 'label' => 'Dokumen', 'short' => '4'],
                            ['field' => 'is_tes_selesai', 'label' => 'Tes', 'short' => '5'],
                            ['field' => 'is_wawancara_selesai', 'label' => 'Wawancara', 'short' => '6'],
                            ['field' => 'is_ukt_paid', 'label' => 'Bayar Ulang', 'short' => '7'],
                            ['field' => 'is_daftar_ulang', 'label' => 'Daftar Ulang', 'short' => '8'],
                        ];
                        $completedCount = collect($steps)->filter(fn($s) => $user->{$s['field']})->count();
                    @endphp
                    <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-gray-700">Progress PMB</span>
                            <span class="text-xs font-bold {{ $completedCount === count($steps) ? 'text-green-600' : 'text-gray-600' }}">{{ $completedCount }}/{{ count($steps) }}</span>
                        </div>
                        <div class="bg-gray-200 rounded-full h-2 mb-2">
                            <div class="h-2 rounded-full transition-all duration-300 {{ $completedCount === count($steps) ? 'bg-green-500' : ($completedCount >= 5 ? 'bg-blue-500' : ($completedCount >= 3 ? 'bg-yellow-500' : 'bg-red-400')) }}"
                                style="width: {{ count($steps) > 0 ? ($completedCount / count($steps)) * 100 : 0 }}%"></div>
                        </div>
                        <div class="flex items-center gap-1">
                            @foreach($steps as $step)
                                <div title="{{ $step['short'] }}. {{ $step['label'] }}"
                                    class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold
                                            {{ $user->{$step['field']} 
                                                ? 'bg-green-500 text-white' 
                                                : 'bg-gray-200 text-gray-500' }}">
                                    {{ $step['short'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @if($isAdmisi)
                            <div class="flex-1 relative group/btn">
                                <button disabled
                                        class="w-full inline-flex items-center justify-center bg-gray-200 text-gray-400 px-4 py-2.5 rounded-lg cursor-not-allowed font-medium text-sm border border-gray-300">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Edit
                                </button>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 z-50 pointer-events-none
                                            opacity-0 group-hover/btn:opacity-100 transition-opacity duration-200">
                                    <div class="bg-gray-900 text-white text-xs font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-lg">
                                        Akses ditolak — Role Admisi
                                    </div>
                                    <div class="w-2 h-2 bg-gray-900 rotate-45 mx-auto -mt-1"></div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('admin.user.edit', $user->id) }}"
                            class="flex-1 bg-amber-500 text-white px-4 py-2.5 rounded-lg hover:bg-amber-600 transition-colors text-center font-medium text-sm shadow-sm">
                                Edit
                            </a>
                        @endif

                            @if($user->id !== auth()->id() && $isAdmin)
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all shadow-sm font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-gray-900 mb-1">Belum ada user</p>
                    <p class="text-gray-600 mb-4">Mulai dengan menambahkan user pertama</p>
                </div>
            @endforelse
            {{-- Pagination --}}
            <div class="mt-4 px-4 pb-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                
                <p class="text-sm text-gray-600 order-2 sm:order-1">
                    Menampilkan
                    <span class="font-semibold text-blue-700">{{ $users->firstItem() ?? 0 }}</span>
                    –
                    <span class="font-semibold text-blue-700">{{ $users->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-blue-700">{{ $users->total() }}</span>
                    data
                </p>

                @if ($users->hasPages())
                    <div class="flex items-center gap-1 flex-wrap justify-center order-1 sm:order-2">

                        @if ($users->onFirstPage())
                            <span class="px-3 py-2 rounded-lg text-sm font-medium text-gray-400 bg-gray-100 cursor-not-allowed select-none flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                <span class="hidden sm:inline">Prev</span>
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                <span class="hidden sm:inline">Prev</span>
                            </a>
                        @endif

                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-bold text-white bg-gradient-to-br from-blue-600 to-indigo-600 shadow-md shadow-blue-200 select-none">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-medium text-blue-700 bg-white border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 flex items-center gap-1">
                                <span class="hidden sm:inline">Next</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <span class="px-3 py-2 rounded-lg text-sm font-medium text-gray-400 bg-gray-100 cursor-not-allowed select-none flex items-center gap-1">
                                <span class="hidden sm:inline">Next</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        @endif

                    </div>
                @endif
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-40">Nama</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-28">Username</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-44">Email</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-36">NIK</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-32">WhatsApp</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-40">Prodi Pilihan 1</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-40">Prodi Pilihan 2</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-24">Role</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-24">Status</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-52">Progres</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold mr-3">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $user->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->nik }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->no_whatsapp }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->programStudiPilihan1?->namaProdi ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->programStudiPilihan2?->namaProdi ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-purple-800 bg-purple-100 rounded-full">
                                        ADMIN
                                    </span>
                                @elseif($user->role === 'keuangan')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-green-800 bg-green-100 rounded-full">
                                        Keuangan
                                    </span>
                                @elseif($user->role === 'wr-3')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-yellow-800 bg-yellow-100 rounded-full">
                                        Wakil Rektor 3
                                    </span>
                                @elseif($user->role === 'dekan')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-red-800 bg-red-100 rounded-full">
                                        Dekan
                                    </span>
                                @elseif($user->role === 'pimpinan')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-indigo-800 bg-indigo-100 rounded-full">
                                        Pimpinan
                                    </span>
                                @elseif($user->role === 'admisi')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-blue-800 bg-blue-100 rounded-full">
                                        ADMISI
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-blue-800 bg-blue-100 rounded-full">
                                        USER
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            @if($isAdmin || $isAdmisi)
                                <form action="{{ route('admin.user.toggle-verify', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center text-xs font-semibold px-3 py-1 rounded-full transition-all cursor-pointer
                                            {{ $user->is_verified 
                                                ? 'text-green-800 bg-green-100 hover:bg-red-100 hover:text-red-700' 
                                                : 'text-gray-600 bg-gray-100 hover:bg-green-100 hover:text-green-700' }}">
                                        @if($user->is_verified)
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Verified
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Unverified
                                        @endif
                                    </button>
                                </form>
                            @else
                                {{-- Non-admin: tampilkan badge biasa tanpa tombol --}}
                                @if($user->is_verified)
                                    <span class="inline-flex items-center text-xs font-semibold text-green-800 bg-green-100 px-3 py-1 rounded-full">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Unverified
                                    </span>
                                @endif
                            @endif
                        </td>
                            {{-- Progress Steps PMB --}}
                            <td class="px-6 py-4">
                                @php
                                    $steps = [
                                        ['field' => 'is_prodi_selected', 'label' => 'Prodi', 'short' => '1'],
                                        ['field' => 'is_bayar_pendaftaran', 'label' => 'Bayar', 'short' => '2'],
                                        ['field' => 'is_data_completed', 'label' => 'Data', 'short' => '3'],
                                        ['field' => 'is_dokumen_uploaded', 'label' => 'Dokumen', 'short' => '4'],
                                        ['field' => 'is_tes_selesai', 'label' => 'Tes', 'short' => '5'],
                                        ['field' => 'is_wawancara_selesai', 'label' => 'Wawancara', 'short' => '6'],
                                        ['field' => 'is_ukt_paid', 'label' => 'Bayar Ulang', 'short' => '7'],
                                        ['field' => 'is_daftar_ulang', 'label' => 'Daftar Ulang', 'short' => '8'],
                                    ];
                                    $completedCount = collect($steps)->filter(fn($s) => $user->{$s['field']})->count();
                                @endphp
                                <div class="min-w-[200px]">
                                    {{-- Progress Bar --}}
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="h-2 rounded-full transition-all duration-300 {{ $completedCount === count($steps) ? 'bg-green-500' : ($completedCount >= 5 ? 'bg-blue-500' : ($completedCount >= 3 ? 'bg-yellow-500' : 'bg-red-400')) }}"
                                                style="width: {{ count($steps) > 0 ? ($completedCount / count($steps)) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold {{ $completedCount === count($steps) ? 'text-green-600' : 'text-gray-600' }}">{{ $completedCount }}/{{ count($steps) }}</span>
                                    </div>
                                    {{-- Step Dots --}}
                                    <div class="flex items-center gap-1">
                                        @foreach($steps as $step)
                                            <div title="{{ $step['short'] }}. {{ $step['label'] }}: {{ $user->{$step['field']} ? 'Selesai' : 'Belum' }}"
                                                class="w-5 h-5 rounded-full flex items-center justify-center text-[9px] font-bold cursor-default transition-all
                                                        {{ $user->{$step['field']} 
                                                            ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' 
                                                            : 'bg-gray-200 text-gray-500' }}">
                                                {{ $step['short'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    @if($isAdmisi)
                                    {{-- disable admisi --}}
                                        <div class="relative group/btn">
                                            <button disabled
                                                    class="inline-flex items-center bg-gray-200 text-gray-400 px-4 py-2 rounded-lg cursor-not-allowed font-medium text-sm border border-gray-300">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                                Lihat / Edit
                                            </button>
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 z-50 pointer-events-none
                                                        opacity-0 group-hover/btn:opacity-100 transition-opacity duration-200">
                                                <div class="bg-gray-900 text-white text-xs font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-lg">
                                                    Akses ditolak — Role Admisi
                                                </div>
                                                <div class="w-2 h-2 bg-gray-900 rotate-45 mx-auto -mt-1"></div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('admin.user.edit', $user->id) }}"
                                        class="inline-flex items-center bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition-all shadow-sm hover:shadow font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Lihat / Edit
                                        </a>
                                    @endif
                                    @if($user->id !== auth()->id() && $isAdmin)
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all shadow-sm font-medium text-sm">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 mb-1">Belum ada user</p>
                                <p class="text-gray-600 mb-4">Mulai dengan menambahkan user pertama</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
{{-- Pagination --}}
<div class="mt-4 px-4 pb-4 flex flex-col sm:flex-row items-center justify-between gap-3">
    
    <p class="text-sm text-gray-600 order-2 sm:order-1">
        Menampilkan
        <span class="font-semibold text-blue-700">{{ $users->firstItem() ?? 0 }}</span>
        –
        <span class="font-semibold text-blue-700">{{ $users->lastItem() ?? 0 }}</span>
        dari
        <span class="font-semibold text-blue-700">{{ $users->total() }}</span>
        data
    </p>

    @if ($users->hasPages())
        <div class="flex items-center gap-1 flex-wrap justify-center order-1 sm:order-2">

            @if ($users->onFirstPage())
                <span class="px-3 py-2 rounded-lg text-sm font-medium text-gray-400 bg-gray-100 cursor-not-allowed select-none flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span class="hidden sm:inline">Prev</span>
                </span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span class="hidden sm:inline">Prev</span>
                </a>
            @endif

            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if ($page == $users->currentPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-bold text-white bg-gradient-to-br from-blue-600 to-indigo-600 shadow-md shadow-blue-200 select-none">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-medium text-blue-700 bg-white border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 flex items-center gap-1">
                    <span class="hidden sm:inline">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="px-3 py-2 rounded-lg text-sm font-medium text-gray-400 bg-gray-100 cursor-not-allowed select-none flex items-center gap-1">
                    <span class="hidden sm:inline">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif

        </div>
    @endif
</div>
        </div>
    </div>

</div>
@endsection