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
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Informasi Tes</h4>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Tes berlangsung 90 menit</li>
                            <li>• Terdiri dari 50 soal pilihan ganda</li>
                            <li>• Pastikan koneksi internet stabil</li>
                        </ul>
                    </div>
                </div>
            </div>

            <form action="{{ route('tes.store') }}" method="POST">
                @csrf
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">Klik tombol di bawah untuk memulai tes</p>
                    <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                        Mulai Tes Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>