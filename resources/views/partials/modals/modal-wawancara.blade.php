@?php
    $user = Auth::user();
    $sudahWawancara = $user->is_wawancara_selesai;
    
    // Ambil pertanyaan dari database
    $pertanyaans = \App\Models\PertanyaanWawancara::where('is_active', true)
        ->get();
    
    // Ambil data wawancara jika sudah pernah
    $wawancara = null;
    if ($sudahWawancara) {
        $wawancara = \App\Models\Wawancara::where('user_id', $user->id)->first();
    }
@endphp

<!-- MODAL WAWANCARA -->
<div id="modalWawancara" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-2 md:p-4">
    <div class="bg-white rounded-2xl md:rounded-3xl shadow-2xl w-full max-w-5xl max-h-[95vh] md:max-h-[90vh] flex flex-col animate-scaleIn">

        @if($sudahWawancara)
            {{-- Jika Sudah Wawancara --}}
            <div class="p-6 md:p-10">
                <div class="text-center">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-green-500 rounded-full blur-xl opacity-50 animate-pulse"></div>
                        <svg class="w-20 h-20 md:w-28 md:h-28 relative text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4">✅ Wawancara Sudah Diselesaikan</h2>
                    <p class="text-gray-600 text-base md:text-lg mb-8 max-w-xl mx-auto">Terima kasih! Anda sudah menyelesaikan tahap wawancara.</p>

                    @if($wawancara)
                    <div class="bg-gray-50 rounded-2xl p-6 md:p-8 mb-8 shadow-inner border border-gray-200">
                        <div class="text-left">
                            <h3 class="font-bold text-lg mb-3 text-gray-800">Jawaban Anda:</h3>
                            <div class="space-y-2">
                                @foreach($wawancara->jawaban as $pertanyaanId => $jawaban)
                                    <p class="text-sm text-gray-600">
                                        Pertanyaan {{ $loop->iteration }}: 
                                        <span class="font-semibold text-purple-600 uppercase">{{ $jawaban }}</span>
                                    </p>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-4">
                                Tanggal: {{ $wawancara->tanggal_wawancara->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                    @endif
                    <button onclick="closeModalWawancara()" 
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 md:px-10 py-3 md:py-4 rounded-xl font-semibold text-base md:text-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-xl hover:shadow-2xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tutup
                    </button>
                </div>
            </div>
        @else
            {{-- Jika Belum Wawancara --}}
            
            <!-- Header Modal (Fixed) -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-700 text-white p-4 md:p-6 rounded-t-2xl md:rounded-t-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-3 md:gap-0">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                        <span>💬</span>
                        <span>Wawancara Seleksi</span>
                    </h2>
                    <p class="text-xs md:text-sm text-purple-100 mt-1">Total: {{ count($pertanyaans) }} pertanyaan</p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-xs md:text-sm opacity-90">Peserta:</p>
                    <p class="font-bold text-sm md:text-base">{{ $user->nama_lengkap ?? $user->name }}</p>
                </div>
            </div>

            <!-- Body Modal (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
                <form id="formWawancara" action="{{ route('wawancara.store') }}" method="POST">
                    @csrf

                    @if(count($pertanyaans) > 0)
                        <div class="space-y-4 md:space-y-6">
                            @foreach($pertanyaans as $index => $pertanyaan)
                            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border-2 border-gray-200 hover:border-purple-400 hover:shadow-xl transition-all">

                                <!-- Nomor & Pertanyaan -->
                                <div class="mb-4">
                                    <div class="flex items-start gap-3">
                                        <span class="inline-flex items-center justify-center w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-blue-600 to-blue-600 text-white font-bold text-sm md:text-base flex-shrink-0 shadow-lg">
                                            {{ $index + 1 }}
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-gray-800 font-medium leading-relaxed text-sm md:text-base">
                                                {{ $pertanyaan->pertanyaan }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Pilihan Jawaban -->
                                    <div class="space-y-2 md:space-y-3 mt-4 ml-0 md:ml-12">
                                        @foreach(['a' => $pertanyaan->opsi_a, 'b' => $pertanyaan->opsi_b, 'c' => $pertanyaan->opsi_c, 'd' => $pertanyaan->opsi_d] as $key => $opsi)
                                        <label class="flex items-start gap-3 p-3 md:p-4 rounded-lg hover:bg-purple-50 cursor-pointer transition-all border-2 border-transparent hover:border-purple-300 group">
                                            <input type="radio"
                                                   name="jawaban[{{ $pertanyaan->id }}]"
                                                   value="{{ $key }}"
                                                   class="w-5 h-5 md:w-6 md:h-6 text-purple-600 focus:ring-purple-500 cursor-pointer mt-0.5 flex-shrink-0"
                                                   required>
                                            <span class="text-gray-700 text-sm md:text-base flex-1 group-hover:text-purple-700 transition-colors">
                                                <strong class="text-purple-600 uppercase">{{ $key }}.</strong> {{ $opsi }}
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>

                        <!-- Footer Modal (Fixed) -->
                        <div class="sticky bottom-0 bg-white pt-4 md:pt-6 mt-4 md:mt-6 border-t-2 border-gray-300 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                            <button type="button"
                                    onclick="closeModalWawancara()"
                                    class="bg-gray-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-600 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>Batal</span>
                            </button>

                            <button type="button"
                                    onclick="submitWawancara()"
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 md:px-8 py-3 rounded-xl font-bold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-xl hover:shadow-2xl flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Selesaikan Wawancara</span>
                            </button>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-gray-600 text-lg font-medium mb-4">Belum ada pertanyaan wawancara</p>
                            <button type="button" onclick="closeModalWawancara()" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                Tutup
                            </button>
                        </div>
                    @endif

                </form>
            </div>
        @endif

    </div>
</div>

<!-- MODAL NOTIFIKASI INFORMASI LANJUTAN -->
<div id="modalNotifikasiLanjutan" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden z-[60] flex items-center justify-center p-3">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] animate-scaleIn overflow-y-auto">
        <!-- Header dengan Gradient -->
        <div class="bg-gradient-to-r from-green-500 via-green-600 to-emerald-600 p-4 text-center">
            <div class="relative inline-block mb-2">
                <div class="absolute inset-0 bg-white rounded-full blur-xl opacity-30 animate-pulse"></div>
                <svg class="w-14 h-14 md:w-16 md:h-16 relative text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg md:text-xl font-bold text-white">Wawancara Berhasil Diselesaikan!</h3>
        </div>

        <!-- Body Content -->
        <div class="p-5">
            <div class="text-center mb-4">
                <p class="text-sm md:text-base text-gray-700 mb-2">
                    Terima kasih <strong class="text-blue-600">{{ $user->nama_lengkap ?? $user->name }}</strong>,
                </p>
                <p class="text-xs md:text-sm text-gray-600 leading-relaxed">
                    Anda telah berhasil menyelesaikan tes wawancara. Pihak kampus akan menghubungi Anda untuk wawancara lanjutan secara langsung melalui <strong>telepon video</strong> atau <strong>Zoom Meeting</strong> dalam waktu <strong class="text-blue-600">2 x 24 jam</strong> ke depan.
                </p>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded-lg mb-4">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-blue-800 mb-1 text-xs md:text-sm">Mohon Perhatikan:</p>
                        <p class="text-xs text-blue-700">
                            Harap periksa <strong>Email</strong> dan <strong>WhatsApp</strong> Anda secara berkala untuk mendapatkan informasi jadwal wawancara selanjutnya.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Checklist Tips -->
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="font-semibold text-gray-800 mb-2 flex items-center gap-2 text-xs md:text-sm">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Persiapan Wawancara:
                </p>
                <ul class="space-y-1.5 text-xs text-gray-700">
                    <li class="flex items-center gap-2">
                        <span class="text-green-500">✓</span>
                        <span>Pastikan koneksi internet stabil</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-green-500">✓</span>
                        <span>Siapkan tempat yang tenang dan pencahayaan yang baik</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-green-500">✓</span>
                        <span>Kenakan pakaian yang rapi dan sopan</span>
                    </li>
                </ul>
            </div>

            <!-- Button Close -->
            <button onclick="closeModalNotifikasi()" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm md:text-base hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Saya Mengerti</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function submitWawancara() {
    const form = document.getElementById('formWawancara');
    const totalPertanyaan = {{ count($pertanyaans) }};
    const radios = form.querySelectorAll('input[type="radio"]:checked');

    if (radios.length < totalPertanyaan) {
        alert('⚠️ Harap jawab SEMUA pertanyaan sebelum menyelesaikan wawancara!\n\nAnda baru menjawab ' + radios.length + ' dari ' + totalPertanyaan + ' pertanyaan.');
        return false;
    }

    if (confirm('✅ Apakah Anda yakin sudah menjawab semua pertanyaan dengan benar?\n\n⚠️ Setelah dikirim, jawaban TIDAK DAPAT DIUBAH!')) {
        // Tampilkan loading
        const submitBtn = event.target;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 inline-block mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
        
        // Tampilkan modal notifikasi sebelum submit
        showModalNotifikasi();
        
        // Submit form setelah delay singkat untuk animasi
        setTimeout(() => {
            form.submit();
        }, 500);
    }
}

function showModalNotifikasi() {
    const modal = document.getElementById('modalNotifikasiLanjutan');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModalNotifikasi() {
    const modal = document.getElementById('modalNotifikasiLanjutan');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Prevent accidental page leave
window.addEventListener('beforeunload', function (e) {
    const modal = document.getElementById('modalWawancara');
    if (modal && !modal.classList.contains('hidden')) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('modalWawancara');
        const modalNotif = document.getElementById('modalNotifikasiLanjutan');
        
        if (modalNotif && !modalNotif.classList.contains('hidden')) {
            closeModalNotifikasi();
        } else if (modal && !modal.classList.contains('hidden')) {
            closeModalWawancara();
        }
    }
});
</script>
@endpush

<style>
@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-scaleIn {
    animation: scaleIn 0.3s ease-out;
}

input[type="radio"]:checked + span {
    background-color: #ede9fe;
    border-color: #8b5cf6;
}
</style>