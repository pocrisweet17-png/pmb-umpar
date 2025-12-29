{{-- Modal Lihat Data Pribadi --}}
{{-- ENHANCED VERSION - Smooth animations, better UX --}}

<style>
    @keyframes modalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes modalSlideUp {
        from { 
            opacity: 0; 
            transform: translateY(30px) scale(0.95); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
        }
    }
    
    @keyframes shimmerData {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    .modal-overlay-animate {
        animation: modalFadeIn 0.3s ease-out forwards;
    }
    
    .modal-content-animate {
        animation: modalSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .data-row {
        transition: all 0.2s ease;
    }
    
    .data-row:hover {
        background: rgba(59, 130, 246, 0.05);
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        margin-left: -0.25rem;
        margin-right: -0.25rem;
        border-radius: 0.5rem;
    }
    
    .modal-section {
        transition: all 0.3s ease;
    }
    
    .modal-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -8px rgba(0, 0, 0, 0.1);
    }
    
    .close-btn-hover {
        transition: all 0.2s ease;
    }
    
    .close-btn-hover:hover {
        transform: rotate(90deg);
        background: #fee2e2;
        color: #dc2626;
    }
    
    .avatar-modal {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    }
    
    .info-badge {
        animation: shimmerData 3s infinite;
        background: linear-gradient(90deg, #eff6ff 25%, #dbeafe 50%, #eff6ff 75%);
        background-size: 200% 100%;
    }
</style>

<div id="modalLihatDataPribadi" class="hidden fixed inset-0 z-50 overflow-y-auto" onclick="closeModalIfOutside(event, 'modalLihatDataPribadi')">
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm modal-overlay-animate"></div>
    
    {{-- Modal Container --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl modal-content-animate" onclick="event.stopPropagation()">
            
            {{-- Modal Content --}}
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                
                {{-- Modal Header with Gradient --}}
                <div class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-6 py-8 overflow-hidden">
                    {{-- Decorative circles --}}
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                    
                    {{-- Close Button --}}
                    <button onclick="closeModalLihatDataPribadi()" type="button" class="close-btn-hover absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white rounded-xl flex items-center justify-center text-white hover:text-gray-900 backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    {{-- Header Content --}}
                    <div class="relative flex items-center gap-4">
                        <div class="avatar-modal w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl">{{ strtoupper(substr($user->nama_lengkap ?? $user->name ?? 'U', 0, 1)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-1">{{ $user->nama_lengkap ?? $user->name ?? 'User' }}</h3>
                            <div class="flex items-center gap-2">
                                <span class="info-badge px-3 py-1 rounded-full text-xs font-semibold text-blue-700">
                                    {{ $user->nomor_registrasi ?? 'Belum terdaftar' }}
                                </span>
                                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                <span class="text-blue-100 text-xs">Online</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 max-h-[60vh] overflow-y-auto custom-scroll bg-gray-50/50">
                    
                    {{-- Data Akun Section --}}
                    <div class="modal-section mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Informasi Akun</h4>
                                <p class="text-xs text-gray-500">Data akun dan kontak</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="divide-y divide-gray-100">
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Nama Lengkap
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $user->nama_lengkap ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Jurusan
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $user->namaProdiPilihan1 ?? $user->pilihan_1 ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Nim
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $user->nim ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Email
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $user->email ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        No. WhatsApp
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $user->no_whatsapp ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                        NIK
                                    </span>
                                    <span class="text-sm font-semibold text-gray-900 font-mono tracking-wide">{{ $user->nik ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5 bg-blue-50/50">
                                    <span class="text-sm text-gray-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        No. Registrasi
                                    </span>
                                    <span class="text-sm font-bold text-blue-600 font-mono tracking-wide">{{ $user->nomor_registrasi ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Lengkap Section --}}
                    @if(isset($registrasi))
                    <div class="modal-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Data Pribadi</h4>
                                <p class="text-xs text-gray-500">Informasi pribadi lengkap</p>
                            </div>
                            <span class="ml-auto px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Lengkap
                            </span>
                        </div>
                        <div class="bg-white rounded-xl border border-green-100 shadow-sm overflow-hidden">
                            <div class="divide-y divide-gray-100">
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500">Tempat Lahir</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $registrasi->tempatLahir ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500">Tanggal Lahir</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $registrasi->tanggalLahir ? \Carbon\Carbon::parse($registrasi->tanggalLahir)->format('d F Y') : '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500">Agama</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $registrasi->agama ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-start justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500">Alamat</span>
                                    <span class="text-sm font-semibold text-gray-900 text-right max-w-[60%] leading-relaxed">{{ $registrasi->alamat ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500">Asal Sekolah</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $registrasi->asalSekolah ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500">Jurusan Sekolah</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $registrasi->jurusan ?? '-' }}</span>
                                </div>
                                <div class="data-row flex items-center justify-between px-4 py-3.5">
                                    <span class="text-sm text-gray-500">Tahun Lulus</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $registrasi->tahunLulus ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="modal-section">
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-amber-800 mb-1">Data Pribadi Belum Lengkap</p>
                                <p class="text-sm text-amber-700">Silakan lengkapi data pribadi Anda untuk melanjutkan proses pendaftaran.</p>
                                <button onclick="closeModalLihatDataPribadi(); setTimeout(() => openModalIsiDataPribadi(), 300);" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Lengkapi Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-white">
                    <button 
                        type="button" 
                        onclick="closeModalLihatDataPribadi()" 
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30 active:scale-[0.98] transition-all duration-200">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function closeModalLihatDataPribadi() {
    const modal = document.getElementById('modalLihatDataPribadi');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function closeModalIfOutside(event, modalId) {
    if (event.target.id === modalId || event.target.closest('.modal-overlay-animate') === event.target) {
        closeModalLihatDataPribadi();
    }
}

// Prevent modal from closing when clicking inside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalLihatDataPribadi');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this || e.target.classList.contains('modal-overlay-animate')) {
                closeModalLihatDataPribadi();
            }
        });
    }
});
</script>