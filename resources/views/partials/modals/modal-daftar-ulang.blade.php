<!-- Modal Daftar Ulang -->
<div id="modalDaftarUlang" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-white">Formulir Pendaftaran Ulang Online</h3>
                <p class="text-indigo-100 text-sm mt-1">Universitas Muhammadiyah Parepare</p>
            </div>
            <button onclick="closeModalDaftarUlang()" class="text-white hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Status Info jika sudah daftar ulang -->
            @if(isset($mahasiswa) && $mahasiswa->is_daftar_ulang)
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 px-4 py-3 rounded">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-blue-800">Status Pendaftaran Ulang</p>
                            <p class="text-sm text-blue-700 mt-1">
                                @if($mahasiswa->status_daftar_ulang == 'pending')
                                    ⏳ Menunggu Verifikasi
                                @elseif($mahasiswa->status_daftar_ulang == 'verified')
                                    ✅ Terverifikasi
                                @elseif($mahasiswa->status_daftar_ulang == 'rejected')
                                    ❌ Ditolak - Silakan hubungi admin
                                @endif
                            </p>
                            <p class="text-xs text-blue-600 mt-1">
                                Tanggal: {{ $mahasiswa->tanggal_daftar_ulang ? $mahasiswa->tanggal_daftar_ulang->format('d M Y H:i') : '-' }}
                            </p>
                        </div>
                        @if($mahasiswa->bukti_pembayaran)
                            <a href="{{ Storage::url($mahasiswa->bukti_pembayaran) }}" target="_blank" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Lihat Bukti
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <form action="{{ route('daftar-ulang.store') }}" method="POST" enctype="multipart/form-data" 
                  @if(isset($mahasiswa) && $mahasiswa->is_daftar_ulang && $mahasiswa->status_daftar_ulang != 'rejected') 
                      onsubmit="return false;" 
                  @endif>
                @csrf
                
                <!-- Informasi Mahasiswa -->
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">1</span>
                        Informasi Mahasiswa
                    </h4>
                    
                    <div class="space-y-4 pl-11">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Induk Mahasiswa (NIM) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nim" value="nim"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50  font-mono text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ $user->nama_lengkap ?? '' }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <input type="text" value="{{ $user->namaProdiPilihan1 ?? $mahasiswa->namaProdi ?? '' }}"  readonly
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed text-sm">
                        </div>
                    </div>
                </div>

                <!-- Informasi Pendaftaran Ulang -->
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">2</span>
                        Informasi Pendaftaran Ulang
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-11">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Semester</label>
                            <input type="text" value="1 / Ganjil" readonly
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Akademik</label>
                            <input type="text" value="2026/2027" readonly
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed text-sm">
                        </div>
                    </div>
                </div>

                <!-- Dokumen yang Diunggah -->
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">3</span>
                        Dokumen yang Diunggah
                    </h4>
                    
                    <div class="pl-11">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Bukti Pembayaran Biaya Kuliah Semester (format PDF) <span class="text-red-500">*</span>
                        </label>
                        
                        @if(isset($mahasiswa) && $mahasiswa->is_daftar_ulang && $mahasiswa->bukti_pembayaran)
                            <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 text-sm">File sudah diunggah</p>
                                    <p class="text-xs text-gray-600">{{ basename($mahasiswa->bukti_pembayaran) }}</p>
                                </div>
                                <a href="{{ Storage::url($mahasiswa->bukti_pembayaran) }}" target="_blank"
                                   class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-xs">
                                    Lihat File
                                </a>
                            </div>
                        @else
                            <input type="file" name="bukti_pembayaran" accept=".pdf" required
                                   class="w-full px-4 py-2.5 border-2 border-dashed border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 text-sm"
                                   onchange="updateFileName(this)">
                            <p class="text-xs text-gray-500 mt-2">📎 Maksimal ukuran file: 2MB</p>
                            <p id="fileName" class="text-xs text-indigo-600 mt-1 font-semibold"></p>
                        @endif
                        
                        @error('bukti_pembayaran')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pernyataan -->
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">4</span>
                        Pernyataan
                    </h4>
                    
                    <div class="bg-indigo-50 border-2 border-indigo-200 rounded-lg p-4 pl-11">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" name="pernyataan" value="1" 
                                   @if(isset($mahasiswa) && $mahasiswa->is_daftar_ulang) checked disabled @else required @endif
                                   class="mt-1 mr-3 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="text-sm text-gray-700 leading-relaxed">
                                Saya menyatakan bahwa data yang saya isi adalah benar dan saya siap untuk melanjutkan studi di <strong>Universitas Muhammadiyah Parepare</strong>.
                            </span>
                        </label>
                        @error('pernyataan')
                            <p class="text-red-500 text-xs mt-2 ml-8">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex gap-3 pt-4 border-t">
                    <button type="button" onclick="closeModalDaftarUlang()" 
                            class="flex-1 px-4 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition text-sm">
                        Batal
                    </button>
                    
                    @if(isset($mahasiswa) && $mahasiswa->is_daftar_ulang && $mahasiswa->status_daftar_ulang != 'rejected')
                        <div class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-500 rounded-lg text-center font-semibold text-sm">
                            ✓ Sudah Melakukan Pendaftaran Ulang
                        </div>
                    @else
                        <button type="submit" 
                                class="flex-1 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg hover:from-indigo-700 hover:to-indigo-800 font-semibold transition shadow-lg hover:shadow-xl text-sm">
                            📤 Submit Pendaftaran Ulang
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const size = (file.size / 1024 / 1024).toFixed(2);
        fileName.textContent = `✓ File terpilih: ${file.name} (${size} MB)`;
    } else {
        fileName.textContent = '';
    }
}

// function closeModalDaftarUlang() {
//     document.getElementById('modalDaftarUlang').classList.add('hidden');
// }

// // Fungsi untuk membuka modal (panggil dari tombol/link lain)
// function openModalDaftarUlang() {
//     document.getElementById('modalDaftarUlang').classList.remove('hidden');
// }

// Auto show modal jika ada error atau success
@if(session('success') || session('error') || $errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        openModalDaftarUlang();
    });
@endif
</script>