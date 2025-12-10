<div id="modalWawancara" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-white">Jadwal Wawancara</h3>
            <button onclick="closeModalWawancara()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Jadwal Wawancara Anda</h4>
                <p class="text-gray-600 mb-4">Silakan datang sesuai jadwal yang telah ditentukan</p>
                
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal</p>
                            <p class="font-bold text-gray-900">15 Januari 2025</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Waktu</p>
                            <p class="font-bold text-gray-900">10:00 WIB</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="font-bold text-gray-900">Gedung Rektorat Lt.2</p>
                        </div>
                    </div>
                </div>

                <button onclick="closeModalWawancara()" class="mt-6 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>