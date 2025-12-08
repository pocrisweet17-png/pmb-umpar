{{-- Modal Isi Data Pribadi --}}
<div id="modalIsiDataPribadi" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50" onclick="closeModalIfOutside(event, 'modalIsiDataPribadi')">
    <div class="relative top-20 mx-auto p-5 w-full max-w-3xl">
        <div class="relative bg-white rounded-lg shadow-xl" onclick="event.stopPropagation()">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">
                    Isi Data Pribadi
                </h3>
                <button onclick="closeModalDataPribadi()" type="button" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('pendaftaran.store') }}">
                @csrf

                {{-- Modal Body --}}
                <div class="p-6 max-h-[calc(100vh-300px)] overflow-y-auto">
                    
                    {{-- Info Data Akun --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Data Akun Anda
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ auth()->user()->nama_lengkap }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Email:</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ auth()->user()->email }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">No WA:</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ auth()->user()->no_whatsapp }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">NIK :</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ auth()->user()->nik }}</span>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-gray-600">Nomor Registrasi:</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ auth()->user()->nomor_registrasi }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Form Fields --}}
                    <div class="space-y-4">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Tempat Lahir --}}
                            <div>
                                <label for="tempatLahir" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="tempatLahir" 
                                    name="tempatLahir" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    placeholder="Contoh: Jakarta"
                                    required>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="tanggalLahir" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="tanggalLahir" 
                                    name="tanggalLahir" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    required>
                            </div>
                        </div>

                        {{-- Kelamin --}}
                        <div>
                            <label for="agama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="jenis_kelamin" 
                                name="jenis_kelamin" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                required>
                                <option value="">Jenis Kelamin</option>
                                <option value="Islam">Laki-laki</option>
                                <option value="Kristen">Perempuan</option>
                            </select>
                        </div>
                        {{-- Agama --}}
                        <div>
                            <label for="agama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Agama <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="agama" 
                                name="agama" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="alamat" 
                                name="alamat" 
                                rows="3" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                placeholder="Masukkan alamat lengkap Anda"
                                required></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Asal Sekolah --}}
                            <div>
                                <label for="asalSekolah" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Asal Sekolah <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="asalSekolah" 
                                    name="asalSekolah" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    placeholder="Contoh: SMA Negeri 1 Jakarta"
                                    required>
                            </div>

                            {{-- Jurusan --}}
                            <div>
                                <label for="jurusan" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jurusan <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="jurusan" 
                                    name="jurusan" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                    placeholder="Contoh: IPA"
                                    required>
                            </div>
                        </div>

                        {{-- Tahun Lulus --}}
                        <div>
                            <label for="tahunLulus" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tahun Lulus <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="tahunLulus" 
                                name="tahunLulus" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                placeholder="Contoh: 2024"
                                min="2000"
                                max="2030"
                                required>
                        </div>

                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
                    <button 
                        type="button" 
                        onclick="closeModalDataPribadi()" 
                        class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Data
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function closeModalDataPribadi() {
    document.getElementById('modalIsiDataPribadi').classList.add('hidden');
}

function closeModalIfOutside(event, modalId) {
    if (event.target.id === modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
}

// Prevent modal from closing when clicking inside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalIsiDataPribadi');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModalDataPribadi();
            }
        });
    }
});
</script>