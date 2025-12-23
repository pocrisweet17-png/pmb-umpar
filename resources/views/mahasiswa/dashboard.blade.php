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
                        <p class="text-gray-600">Selamat datang, <span class="font-semibold text-gray-900">{{ $user->name }}</span> NIM:<span class="font-semibold text-gray-900">{{ $user->nim }}</span></p>
                    </div>
                    <!-- <div class="hidden md:flex items-center gap-3">
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
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    

    {{-- Steps Flow Design --}}
    <div class="py-8 px-4">
        <div class="max-w-5xl mx-auto relative">
            <!-- Garis Tengah Vertikal (background) -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 bg-gray-200 rounded-full"
                style="top: 4rem; bottom: 2rem;"></div>

            @foreach($steps as $index => $step)
                <div class="relative flex items-center mb-32 last:mb-0">
                    <!-- Connector Lurus Horizontal + Vertikal (kecuali step pertama & terakhir) -->
                    @if($index > 0)
                        <div class="absolute w-full h-full pointer-events-none">
                            <div class="absolute w-1/2 h-32 {{ $index % 2 === 1 ? 'left-0' : 'right-0' }} top-[-8rem]">
                                <div class="w-full h-full flex items-center">
                                    <div class="w-full h-1 {{ $steps[$index-1]['completed'] ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                                </div>
                            </div>
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-32 top-[-8rem]
                                        {{ $steps[$index-1]['completed'] ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                        </div>
                    @endif

                    <!-- Step Item -->
                    <div class="flex items-start w-full {{ $index % 2 === 0 ? 'justify-start' : 'justify-end' }}">
                        <div class="flex items-center gap-6 w-full max-w-lg">
                            @if($index % 2 === 1)
                                <!-- Spacer kiri untuk step ganjil -->
                                <div class="w-12 md:w-16"></div>
                            @endif

                            <!-- Circle -->
                            <div class="flex-shrink-0 relative z-10">
                                <div class="w-12 h-12 md:w-16 md:h-16 rounded-full border-4 
                                    {{ $step['completed'] ? 'bg-blue-600 border-blue-700 shadow-lg shadow-blue-500/40' : 
                                    ($step['enabled'] ? 'bg-blue-500 border-blue-600 shadow-lg shadow-blue-400/40' : 'bg-gray-300 border-gray-400') }}
                                    flex items-center justify-center transition-all duration-300">
                                    @if($step['completed'])
                                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span class="text-white font-bold text-lg md:text-2xl">{{ $index + 1 }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card -->
                            <div class="flex-1">
                                <div class="bg-white rounded-xl shadow-md border-2 p-4 hover:shadow-lg transition-all duration-300
                                    {{ $step['completed'] ? 'border-blue-400 shadow-blue-200/40' : 
                                    ($step['enabled'] ? 'border-blue-300 shadow-blue-100/40' : 'border-gray-200') }}">
                                    
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($step['completed'])
                                            <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @elseif($step['enabled'])
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <h3 class="text-base md:text-lg font-bold text-gray-900">{{ $step['name'] }}</h3>
                                    </div>

                                    <div class="mb-2">
                                        @if($step['completed'])
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Terverifikasi</span>
                                        @elseif($step['enabled'])
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Dapat Dikerjakan</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Terkunci</span>
                                        @endif
                                    </div>

                                    <p class="text-xs md:text-sm text-gray-600 mb-3">
                                        @if($step['completed']) Data telah tersimpan dan terverifikasi.
                                        @elseif($step['enabled']) Silakan lengkapi langkah ini untuk melanjutkan.
                                        @else Selesaikan langkah sebelumnya terlebih dahulu.
                                        @endif
                                    </p>

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

                                    <div>
                                        @if($step['completed'] && $modalFunction)
                                            <button onclick="{{ $modalFunction }}" class="inline-flex items-center px-3 py-1.5 bg-white border-2 border-gray-300 text-gray-700 rounded-lg text-xs md:text-sm font-semibold hover:bg-gray-50">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                Lihat Detail
                                            </button>
                                        @elseif($step['enabled'] && $modalFunction)
                                            <button onclick="{{ $modalFunction }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-xs md:text-sm font-bold hover:bg-blue-700 shadow-md shadow-blue-500/30">
                                                Mulai →
                                            </button>
                                        @elseif(!$step['enabled'])
                                            <button disabled class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-xs md:text-sm font-semibold cursor-not-allowed">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                                Terkunci
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($index % 2 === 0)
                                <!-- Spacer kanan untuk step genap -->
                                <div class="w-12 md:w-16"></div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
