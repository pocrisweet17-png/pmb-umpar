@extends('admin.layouts.app')

@section('title', 'Kelola Program Studi')
@section('page-title', 'Kelola Program Studi')

@section('content')
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
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Program Studi</h2>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">Manajemen semua program studi di universitas</p>
            </div>
            <button onclick="document.getElementById('modalTambahProdi').classList.remove('hidden')"
               class="inline-flex items-center justify-center bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3.5 rounded-xl shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40 hover:from-green-700 hover:to-green-800 transition-all duration-200 font-semibold group">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Program Studi
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-blue-100 font-medium">Total Program Studi</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalProdi }}</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-blue-100">Program studi aktif</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-green-100 font-medium">S1</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalS1 }}</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-green-100">Sarjana</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-purple-100 font-medium">S2</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalS2 }}</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-purple-100">Magister</p>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-orange-100 font-medium">S3</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalS3 }}</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-orange-100">Doktor</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <form method="GET" action="{{ route('admin.program-studi.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Cari Program Studi</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari kode prodi, nama, atau fakultas..."
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <!-- Fakultas Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas</label>
                    <select name="fakultas" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Fakultas</option>
                        @foreach($fakultasList as $fakultas)
                            <option value="{{ $fakultas }}" {{ request('fakultas') == $fakultas ? 'selected' : '' }}>
                                {{ $fakultas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenjang Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenjang</label>
                    <select name="jenjang" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Jenjang</option>
                        <option value="S1" {{ request('jenjang') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ request('jenjang') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ request('jenjang') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
                
                @if(request()->anyFilled(['search', 'fakultas', 'jenjang']))
                    <a href="{{ route('admin.program-studi.index') }}" class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-xl font-semibold transition-all shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset
                    </a>
                    
                    <div class="flex items-center text-sm text-gray-600 bg-blue-50 px-4 py-2.5 rounded-xl border border-blue-200">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ $programStudis->total() }}</span>&nbsp;program studi ditemukan
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kode Prodi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Program Studi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Fakultas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jenjang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($programStudis as $prodi)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-blue-800 bg-blue-100 rounded-full">
                                    {{ $prodi->kodeProdi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $prodi->namaProdi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $prodi->fakultas }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($prodi->jenjang === 'S1')
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-green-800 bg-green-100 rounded-full">S1</span>
                                @elseif($prodi->jenjang === 'S2')
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-purple-800 bg-purple-100 rounded-full">S2</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-red-800 bg-red-100 rounded-full">S3</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    <button onclick="editProdi({{ json_encode($prodi) }})"
                                       class="inline-flex items-center bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition-all shadow-sm hover:shadow font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.program-studi.destroy', $prodi->kodeProdi) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus program studi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all shadow-sm hover:shadow font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 mb-1">Belum ada program studi</p>
                                <p class="text-gray-600">Tambahkan program studi pertama</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Pagination --}}
        <div class="px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-gray-100">

            <p class="text-sm text-gray-600 order-2 sm:order-1">
                Menampilkan
                <span class="font-semibold text-blue-700">{{ $programStudis->firstItem() ?? 0 }}</span>
                –
                <span class="font-semibold text-blue-700">{{ $programStudis->lastItem() ?? 0 }}</span>
                dari
                <span class="font-semibold text-blue-700">{{ $programStudis->total() }}</span>
                data
            </p>

            @if ($programStudis->hasPages())
                <div class="flex items-center gap-1 flex-wrap justify-center order-1 sm:order-2">

                    @if ($programStudis->onFirstPage())
                        <span class="px-3 py-2 rounded-lg text-sm font-medium text-gray-400 bg-gray-100 cursor-not-allowed select-none flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <span class="hidden sm:inline">Prev</span>
                        </span>
                    @else
                        <a href="{{ $programStudis->previousPageUrl() }}" class="px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <span class="hidden sm:inline">Prev</span>
                        </a>
                    @endif

                    @foreach ($programStudis->getUrlRange(1, $programStudis->lastPage()) as $page => $url)
                        @if ($page == $programStudis->currentPage())
                            <span class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-bold text-white bg-gradient-to-br from-blue-600 to-indigo-600 shadow-md shadow-blue-200 select-none">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-medium text-blue-700 bg-white border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($programStudis->hasMorePages())
                        <a href="{{ $programStudis->nextPageUrl() }}" class="px-3 py-2 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 flex items-center gap-1">
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

<!-- Modal Tambah Prodi -->
<div id="modalTambahProdi" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">Tambah Program Studi</h3>
                <button onclick="document.getElementById('modalTambahProdi').classList.add('hidden')" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form action="{{ route('admin.program-studi.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Prodi <span class="text-red-500">*</span></label>
                    <input type="text" name="kodeProdi" required maxlength="50"
                           placeholder="Contoh: S1-TI"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <p class="text-xs text-gray-500 mt-1">Maksimal 50 karakter, harus unik</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenjang <span class="text-red-500">*</span></label>
                    <select name="jenjang" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <option value="">Pilih Jenjang</option>
                        <option value="S1">S1 - Sarjana</option>
                        <option value="S2">S2 - Magister</option>
                        <option value="S3">S3 - Doktor</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Program Studi <span class="text-red-500">*</span></label>
                    <input type="text" name="namaProdi" required maxlength="255"
                           placeholder="Contoh: Teknik Informatika"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas <span class="text-red-500">*</span></label>
                    <input type="text" name="fakultas" required maxlength="255"
                           placeholder="Contoh: Fakultas Teknik"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Mahasiswa <span class="text-red-500">*</span></label>
                    <input type="number" name="kuota" required min="0" value="0"
                           placeholder="Contoh: 100"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <p class="text-xs text-gray-500 mt-1">Jumlah kuota penerimaan mahasiswa baru</p>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg">
                    Simpan
                </button>
                <button type="button" onclick="document.getElementById('modalTambahProdi').classList.add('hidden')"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 rounded-xl transition-all shadow-lg">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Prodi -->
<div id="modalEditProdi" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">Edit Program Studi</h3>
                <button onclick="document.getElementById('modalEditProdi').classList.add('hidden')" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="formEditProdi" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Prodi <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_kodeProdi" name="kodeProdi" required maxlength="50"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    <p class="text-xs text-gray-500 mt-1">Maksimal 50 karakter, harus unik</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenjang <span class="text-red-500">*</span></label>
                    <select id="edit_jenjang" name="jenjang" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                        <option value="">Pilih Jenjang</option>
                        <option value="S1">S1 - Sarjana</option>
                        <option value="S2">S2 - Magister</option>
                        <option value="S3">S3 - Doktor</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Program Studi <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_namaProdi" name="namaProdi" required maxlength="255"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fakultas <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_fakultas" name="fakultas" required maxlength="255"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Mahasiswa <span class="text-red-500">*</span></label>
                    <input type="number" id="edit_kuota" name="kuota" required min="0"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    <p class="text-xs text-gray-500 mt-1">Jumlah kuota penerimaan mahasiswa baru</p>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg">
                    Update
                </button>
                <button type="button" onclick="document.getElementById('modalEditProdi').classList.add('hidden')"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 rounded-xl transition-all shadow-lg">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editProdi(prodi) {
    document.getElementById('modalEditProdi').classList.remove('hidden');
    document.getElementById('formEditProdi').action = `/admin/program-studi/${prodi.kodeProdi}`;
    document.getElementById('edit_kodeProdi').value = prodi.kodeProdi;
    document.getElementById('edit_namaProdi').value = prodi.namaProdi;
    document.getElementById('edit_fakultas').value = prodi.fakultas;
    document.getElementById('edit_jenjang').value = prodi.jenjang;
    document.getElementById('edit_kuota').value = prodi.kuota || 0;
}
</script>
@endsection