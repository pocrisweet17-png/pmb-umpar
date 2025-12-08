{{-- Modal Lihat Data Pribadi --}}
<div id="modalLihatDataPribadi" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50" onclick="closeModalIfOutside(event, 'modalLihatDataPribadi')">
    <div class="relative top-20 mx-auto p-5 w-full max-w-3xl">
        <div class="relative bg-white rounded-lg shadow-xl" onclick="event.stopPropagation()">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">
                        Data Pribadi Lengkap
                    </h3>
                </div>
                <button onclick="closeModalLihatDataPribadi()" type="button" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 max-h-[calc(100vh-250px)] overflow-y-auto">
                
                {{-- Data Akun Section --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h4 class="text-lg font-bold text-gray-900">Data Akun</h4>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Nama Lengkap:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->nama_lengkap ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Jurusan:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->pilihan_1 ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Email:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->email ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">No Whatsapp:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->no_whatsapp ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">NIK:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->nik ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Nomor Registrasi:</span>
                            <span class="text-sm font-semibold text-blue-600">{{ $user->nomor_registrasi ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Data Lengkap Section --}}
                @if(isset($registrasi))
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h4 class="text-lg font-bold text-gray-900">Data Pribadi Lengkap</h4>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 space-y-3">
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Tempat Lahir:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $registrasi->tempatLahir ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Tanggal Lahir:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $registrasi->tanggalLahir ? \Carbon\Carbon::parse($registrasi->tanggalLahir)->format('d F Y') : '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Agama:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $registrasi->agama ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Alamat:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $registrasi->alamat ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Asal Sekolah:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $registrasi->asalSekolah ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Jurusan:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $registrasi->jurusan ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-sm text-gray-600 w-40">Tahun Lulus:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $registrasi->tahunLulus ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-yellow-800 mb-1">Data Pribadi Belum Dilengkapi</p>
                        <p class="text-sm text-yellow-700">Silakan lengkapi data pribadi Anda terlebih dahulu.</p>
                    </div>
                </div>
                @endif

            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
                <button 
                    type="button" 
                    onclick="closeModalLihatDataPribadi()" 
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<script>
function closeModalLihatDataPribadi() {
    document.getElementById('modalLihatDataPribadi').classList.add('hidden');
}

function closeModalIfOutside(event, modalId) {
    if (event.target.id === modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
}

// Prevent modal from closing when clicking inside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalLihatDataPribadi');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModalLihatDataPribadi();
            }
        });
    }
});
</script>