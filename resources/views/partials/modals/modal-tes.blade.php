<div id="modalTes" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-white">Tes Masuk</h3>
            <button onclick="closeModalTes()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            @if($user->is_tes_selesai)
                <div class="text-center py-10">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tes Sudah Selesai!</h3>
                    <p class="text-gray-600 mb-6">Anda telah menyelesaikan tes masuk.</p>
                    
                    <button onclick="closeModalTes()" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                        Tutup
                    </button>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">Klik tombol di bawah untuk memulai tes</p>
                    <a href="{{ route('mahasiswa.ujian') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                        Mulai Tes Sekarang →
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>