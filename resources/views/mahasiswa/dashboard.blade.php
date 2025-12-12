@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    
    {{-- Header --}}
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">Dashboard Pendaftaran Mahasiswa Baru</h1>
                        <p class="text-gray-600">Selamat datang, <span class="font-semibold text-gray-900">{{ $user->name }}</span></p>
                    </div>
                    <div class="hidden md:flex items-center gap-3">
                        {{-- Tombol Test Modal Isi Data --}}
                        <button onclick="openModalDataPribadi()" class="flex items-center gap-2 px-4 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors border border-purple-200" title="Test Modal Isi Data">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">Test Isi Data</span>
                        </button>
                        
                        {{-- Tombol Lihat Data Pribadi --}}
                        <button onclick="openModalLihatDataPribadi()" class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors border border-blue-200" title="Lihat Data Pribadi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium">Data Pribadi</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wizard Progress Indicator --}}
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Proses Pendaftaran</h2>
                    @php
                        $completedSteps = collect($steps)->where('completed', true)->count();
                        $totalSteps = count($steps);
                        $progressPercent = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Progress:</span>
                        <span class="text-sm font-bold text-gray-900">{{ $progressPercent }}%</span>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="mb-8">
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-500 rounded-full" 
                             style="width: {{ $progressPercent }}%">
                        </div>
                    </div>
                </div>

                {{-- Wizard Steps --}}
                <div class="relative">
                    <div class="flex items-start justify-between">
                        @foreach($steps as $index => $step)
                        <div class="flex flex-col items-center" style="flex: 1;">
                            {{-- Step Circle --}}
                            <div class="relative z-10 mb-3">
                                @if($step['completed'])
                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center shadow-sm">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @elseif($step['enabled'])
                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center shadow-sm ring-4 ring-blue-100">
                                        <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 font-semibold text-sm">{{ $index + 1 }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Step Label --}}
                            <div class="text-center max-w-[120px]">
                                <p class="text-xs font-medium {{ $step['completed'] ? 'text-blue-600' : ($step['enabled'] ? 'text-blue-600' : 'text-gray-400') }}">
                                    {{ $step['name'] }}
                                </p>
                                @if($step['completed'])
                                    <span class="inline-block mt-1 text-xs text-green-600 font-medium">✓ Selesai</span>
                                @elseif($step['enabled'])
                                    <span class="inline-block mt-1 text-xs text-blue-600 font-medium">● Aktif</span>
                                @endif
                            </div>

                            {{-- Connecting Line --}}
                            @if($index < count($steps) - 1)
                            <div class="absolute left-0 right-0 top-5 flex items-center" style="z-index: 0;">
                                <div class="h-0.5 bg-gray-300 flex-1 mx-auto" style="width: calc(100% - 80px); margin-left: {{ 40 + (100 / $totalSteps * ($index + 0.5)) }}%;">
                                    @if($step['completed'] && $steps[$index + 1]['completed'])
                                        <div class="h-full bg-blue-600"></div>
                                    @elseif($step['completed'])
                                        <div class="h-full bg-blue-600" style="width: 50%"></div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Next Step Action --}}
                @if($nextStep)
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 font-medium">Langkah Selanjutnya</p>
                                <p class="text-sm font-bold text-gray-900">{{ $nextStep['name'] }}</p>
                            </div>
                        </div>
                        {{-- @if($modalFunction)
                            <button onclick="{{ $modalFunction }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                Lanjutkan →
                            </button>
                        @endif
                    </div> --}}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Steps Detail Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($steps as $index => $step)
        <div class="bg-white rounded-lg shadow-sm border {{ $step['completed'] ? 'border-blue-200 bg-blue-50/30' : 'border-gray-200' }} hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    {{-- Step Number --}}
                    <div class="flex-shrink-0">
                        @if($step['completed'])
                            <div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        @elseif($step['enabled'])
                            <div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 font-bold text-lg">{{ $index + 1 }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        {{-- Step Title & Status --}}
                        <div class="mb-3">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $step['name'] }}</h3>
                            @if($step['completed'])
                                <span class="inline-flex items-center text-xs font-medium text-green-700">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terverifikasi
                                </span>
                            @elseif($step['enabled'])
                                <span class="inline-flex items-center text-xs font-medium text-blue-700">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Dapat Dikerjakan
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-medium text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Menunggu Step Sebelumnya
                                </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <p class="text-sm text-gray-600 mb-4">
                            @if($step['completed'])
                                Data telah tersimpan dan terverifikasi.
                            @elseif($step['enabled'])
                                Silakan lengkapi langkah ini untuk melanjutkan proses pendaftaran.
                            @else
                                Langkah ini akan tersedia setelah menyelesaikan langkah sebelumnya.
                            @endif
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex gap-2">
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
                                {{-- Jika sudah selesai --}}
                                @if($modalFunction)
                                    <div 
                                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Selesai
                                    </div>
                                @endif
                            @elseif($step['enabled'])
                                {{-- Jika enabled (bisa dikerjakan) --}}
                                @if($modalFunction)
                                    <button onclick="{{ $modalFunction }}" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                                        Mulai Sekarang →
                                    </button>
                                @endif
                            @else
                                {{-- Jika disabled --}}
                                <button class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terkunci
                                </button>
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
    <div class="mt-8">
        <div class="bg-green-50 border border-green-200 rounded-lg shadow-sm">
            <div class="p-6 flex items-center gap-4">
                <div class="w-14 h-14 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Pendaftaran Selesai!</h3>
                    <p class="text-gray-700">Selamat! Anda telah menyelesaikan semua tahap pendaftaran mahasiswa baru.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- DEBUG PANEL --}}
    @if(config('app.debug'))
    <div class="mt-8">
        <div class="bg-gray-50 border border-gray-300 rounded-lg">
            <div class="bg-gray-200 px-6 py-3 border-b border-gray-300">
                <h3 class="text-sm font-bold text-gray-800">DEBUG PANEL</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <h4 class="font-bold text-gray-800 mb-3">User Status:</h4>
                        <ul class="space-y-2">
                            <li><span class="text-gray-600">User ID:</span> <code class="px-2 py-1 bg-gray-200 rounded">{{ $user->id }}</code></li>
                            <li><span class="text-gray-600">Prodi Selected:</span> <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->is_prodi_selected ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $user->is_prodi_selected ? 'YES' : 'NO' }}</span></li>
                            <li><span class="text-gray-600">Bayar Pendaftaran:</span> <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->is_bayar_pendaftaran ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $user->is_bayar_pendaftaran ? 'YES' : 'NO' }}</span></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 mb-3">Direct Access Test:</h4>
                        <div class="space-y-2">
                            <a href="{{ route('bayar.index') }}" class="block px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded text-center transition-colors">Test Bayar Route</a>
                            <a href="{{ route('prodi.view') }}" class="block px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded text-center transition-colors">Test Prodi Route</a>
                        </div>
                        <div class="mt-4">
                            <h4 class="font-bold text-gray-800 mb-3">🧪 Test Modal Buttons:</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                <button onclick="openModalProdi()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Prodi</button>
                                <button onclick="openModalBayarPendaftaran()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Bayar</button>
                                <button onclick="openModalIsiDataPribadi()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Data</button>
                                <button onclick="openModalUploadDokumen()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Upload</button>
                                <button onclick="openModalTes()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Tes</button>
                                <button onclick="openModalWawancara()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Wawancara</button>
                                <button onclick="openModalDaftarUlang()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Daftar Ulang</button>
                                <button onclick="openModalBayarUkt()" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-semibold">Test Bayar UKT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>


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
     'modalUploadDokumen', 'modalTes', 'modalWawancara', 'modalDaftarUlang', 'modalBayarUkt'].forEach(id => {
        console.log(document.getElementById(id) ? `✅ ${id}` : `❌ ${id}`);
    });
    console.groupEnd();
});
</script>
@endpush
@endsection

{{-- Include Modal Components --}}
@include('partials.modals.modal-prodi')
@include('partials.modals.isi-data-pribadi')
@include('partials.modals.lihat-data-pribadi')
@include('partials.modals.modal-bayar-pendaftaran')
@include('partials.modals.modal-upload-dokumen')
@include('partials.modals.modal-tes')
@include('partials.modals.modal-wawancara')
@include('partials.modals.modal-daftar-ulang')
@include('partials.modals.modal-bayar-ukt')
