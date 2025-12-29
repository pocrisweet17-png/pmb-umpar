@extends('admin.layouts.app')

@section('title', 'Daftar Soal')
@section('page-title', 'Kelola Soal')

@section('content')
<div class="space-y-6">

    <!-- Success Notification -->
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

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Bank Soal</h2>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">Kelola semua soal ujian di sini</p>
            </div>
            <a href="{{ route('admin.soal.create') }}"
               class="inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3.5 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-semibold group">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Soal Baru
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

        <!-- Mobile Card View -->
        <div class="lg:hidden divide-y divide-gray-100">
            @forelse ($soals as $soal)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded">ID: {{ $soal->idSoal }}</span>
                                <span class="text-xs font-semibold text-green-800 bg-green-100 px-3 py-1 rounded-full uppercase">
                                    Jawaban: {{ $soal->jawabanBenar }}
                                </span>
                            </div>
                            <p class="text-gray-900 font-medium text-sm leading-relaxed">{{ $soal->textSoal }}</p>
                            
                            {{-- untuk gambar --}}
                                @if($soal->gambar_soal)
                                    <img src="{{ asset('storage/' . $soal->gambar_soal) }}" 
                                            alt="Gambar Soal" 
                                            class="w-20 h-20 object-cover rounded-lg mt-2 border border-gray-200">
                                @endif
                        </div>
                    </div>

                    <div class="space-y-2 mb-4 bg-gray-50 rounded-lg p-3">
                        <div class="text-xs text-gray-700"><strong class="text-gray-900">A:</strong> {{ $soal->opsi_a }}</div>
                        <div class="text-xs text-gray-700"><strong class="text-gray-900">B:</strong> {{ $soal->opsi_b }}</div>
                        <div class="text-xs text-gray-700"><strong class="text-gray-900">C:</strong> {{ $soal->opsi_c }}</div>
                        <div class="text-xs text-gray-700"><strong class="text-gray-900">D:</strong> {{ $soal->opsi_d }}</div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.soal.edit', $soal->idSoal) }}"
                           class="flex-1 bg-amber-500 text-white px-4 py-2.5 rounded-lg hover:bg-amber-600 transition-colors text-center font-medium text-sm shadow-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.soal.destroy', $soal->idSoal) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-500 text-white px-4 py-2.5 rounded-lg hover:bg-red-600 transition-colors font-medium text-sm shadow-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-gray-900 mb-1">Belum ada soal</p>
                    <p class="text-gray-600 mb-4">Mulai dengan menambahkan soal pertama Anda</p>
                    <a href="{{ route('admin.soal.create') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        Tambah Soal
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Soal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Opsi A</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Opsi B</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Opsi C</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Opsi D</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jawaban</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($soals as $soal)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">{{ $soal->idSoal }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    @if($soal->gambar_soal)
                                        <img src="{{ asset('storage/' . $soal->gambar_soal) }}" 
                                             alt="Gambar Soal" 
                                             class="w-12 h-12 object-cover rounded-lg border border-gray-200 flex-shrink-0">
                                    @endif
                                    <p class="text-sm text-gray-900">{{ Str::limit($soal->textSoal, 60) }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">{{ Str::limit($soal->opsi_a, 30) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">{{ Str::limit($soal->opsi_b, 30) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">{{ Str::limit($soal->opsi_c, 30) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">{{ Str::limit($soal->opsi_d, 30) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-green-800 bg-green-100 rounded-full uppercase ring-2 ring-green-200">
                                    {{ $soal->jawabanBenar }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.soal.edit', $soal->idSoal) }}"
                                       class="inline-flex items-center bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition-all shadow-sm hover:shadow font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.soal.destroy', $soal->idSoal) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
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
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 mb-1">Belum ada soal</p>
                                <p class="text-gray-600 mb-4">Mulai dengan menambahkan soal pertama Anda</p>
                                <a href="{{ route('admin.soal.create') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                    Tambah Soal
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
