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
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

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

                        {{-- JENIS KELAMIN --}}
                        <div>
                            <label for="jenisKelamin" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="jenisKelamin" 
                                name="jenisKelamin" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        {{-- AGAMA --}}
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

                        {{-- ALAMAT SECTION --}}
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipe Alamat<span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mb-4">
                                <label class="flex items-center">
                                    <input type="radio" name="tipe_alamat" value="indonesia" class="mr-2" checked>
                                    <span class="text-sm">Indonesia</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="tipe_alamat" value="luar_negeri" class="mr-2">
                                    <span class="text-sm">Luar Negeri</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            {{-- Provinsi / Negara --}}
                            <div>
                                <label for="provinsi_label" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat<span class="text-red-500">*</span>
                                </label>
                                <label id="provinsi_label" class="block text-sm font-semibold mb-1">Provinsi</label>
                                
                                {{-- Dropdown untuk Indonesia --}}
                                <select id="provinsi" name="provinsi" class="w-full border rounded-lg p-2 alamat-indonesia">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                
                                {{-- Input Manual untuk Luar Negeri --}}
                                <input type="text" id="provinsi_manual" name="provinsi" 
                                    class="w-full border rounded-lg p-2 alamat-luar-negeri hidden" 
                                    placeholder="Masukkan Negara">
                            </div>

                            {{-- Kabupaten / Kota --}}
                            <div>
                                <label id="kabupaten_label" class="block text-sm font-semibold mb-1">Kabupaten/Kota</label>
                                
                                {{-- Dropdown untuk Indonesia --}}
                                <select id="kabupaten" name="kabupaten" class="w-full border rounded-lg p-2 alamat-indonesia" disabled>
                                    <option value="">Pilih Kabupaten</option>
                                </select>
                                
                                {{-- Input Manual untuk Luar Negeri --}}
                                <input type="text" id="kabupaten_manual" name="kabupaten" 
                                    class="w-full border rounded-lg p-2 alamat-luar-negeri hidden" 
                                    placeholder="Masukkan Kota">
                            </div>

                            {{-- Kecamatan / Wilayah --}}
                            <div>
                                <label id="kecamatan_label" class="block text-sm font-semibold mb-1">Kecamatan</label>
                                
                                {{-- Dropdown untuk Indonesia --}}
                                <select id="kecamatan" name="kecamatan" class="w-full border rounded-lg p-2 alamat-indonesia" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                
                                {{-- Input Manual untuk Luar Negeri --}}
                                <input type="text" id="kecamatan_manual" name="kecamatan" 
                                    class="w-full border rounded-lg p-2 alamat-luar-negeri hidden" 
                                    placeholder="Masukkan Wilayah/District">
                            </div>

                            {{-- Desa / Alamat Lengkap --}}
                            <div>
                                <label id="desa_label" class="block text-sm font-semibold mb-1">Desa/Kelurahan</label>
                                
                                {{-- Dropdown untuk Indonesia --}}
                                <select id="desa" name="desa" class="w-full border rounded-lg p-2 alamat-indonesia" disabled>
                                    <option value="">Pilih Desa</option>
                                </select>
                                
                                {{-- Input Manual untuk Luar Negeri --}}
                                <input type="text" id="desa_manual" name="desa" 
                                    class="w-full border rounded-lg p-2 alamat-luar-negeri hidden" 
                                    placeholder="Masukkan Alamat Lengkap">
                            </div>
                        </div>
                        {{-- ALAMAT JALAN (WAJIB ADA!) --}}
                        <div class="mt-4">
                            <label for="alamat_jalan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Jalan / Detail Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="alamat_jalan" 
                                name="alamat_jalan"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02"
                                required></textarea>
                        </div>

                        {{-- HIDDEN INPUT UNTUK ALAMAT LENGKAP (INI YANG DIKIRIM KE DB!) --}}
                        <input type="hidden" name="alamat" id="alamat_final">


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
document.addEventListener('DOMContentLoaded', function () {

    // ========== MODAL FUNCTIONS ==========
    window.openModalIsiDataPribadi = function () {
        const modal = document.getElementById('modalIsiDataPribadi');
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    window.closeModalDataPribadi = function () {
        const modal = document.getElementById('modalIsiDataPribadi');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Reset form jika ada
            const form = modal.querySelector('form');
            if (form) {
                form.reset();
            }
            
            // Jalankan fungsi berikutnya jika ada
            setTimeout(() => {
                if (typeof checkAndOpenNextModal === 'function') {
                    checkAndOpenNextModal();
                }
            }, 300);
        }
    }

    // Function untuk tutup modal ketika klik di luar modal
    window.closeModalIfOutside = function(event, modalId) {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            closeModalDataPribadi();
        }
    }

    // Event listener untuk tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('modalIsiDataPribadi');
            if (modal && !modal.classList.contains('hidden')) {
                closeModalDataPribadi();
            }
        }
    });

    // Event listener untuk klik di luar modal
    const modal = document.getElementById('modalIsiDataPribadi');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeModalDataPribadi();
            }
        });
        
        // PASTIKAN MODAL TERTUTUP SAAT PAGE LOAD
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // ========== FORM SUBMIT HANDLER ==========
    const form = document.querySelector('form[action="{{ route('pendaftaran.store') }}"]');
    if (form) {
        form.addEventListener('submit', function (e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
            }
        });
    }

    // ========== WILAYAH INDONESIA & LUAR NEGERI ==========
    const API = '/wilayah';

    // Elements Indonesia (Dropdown)
    const provinsi     = document.getElementById('provinsi');
    const kabupaten    = document.getElementById('kabupaten');
    const kecamatan    = document.getElementById('kecamatan');
    const desa         = document.getElementById('desa');
    
    // Elements Luar Negeri (Input Manual)
    const provinsiManual  = document.getElementById('provinsi_manual');
    const kabupatenManual = document.getElementById('kabupaten_manual');
    const kecamatanManual = document.getElementById('kecamatan_manual');
    const desaManual      = document.getElementById('desa_manual');
    
    // Other elements
    const alamatJalan     = document.getElementById('alamat_jalan');
    const alamatFinal     = document.getElementById('alamat_final');
    const tipeAlamatRadios = document.querySelectorAll('input[name="tipe_alamat"]');
    
    // Label elements
    const provinsiLabel   = document.getElementById('provinsi_label');
    const kabupatenLabel  = document.getElementById('kabupaten_label');
    const kecamatanLabel  = document.getElementById('kecamatan_label');
    const desaLabel       = document.getElementById('desa_label');

    if (!provinsi) {
        console.error('Element provinsi tidak ditemukan');
        return;
    }

    // ========== SWITCH TIPE ALAMAT (Indonesia / Luar Negeri) ==========
    function switchAlamatType(type) {
        const indonesiaElements = document.querySelectorAll('.alamat-indonesia');
        const luarNegeriElements = document.querySelectorAll('.alamat-luar-negeri');
        
        if (type === 'indonesia') {
            // Tampilkan dropdown Indonesia
            indonesiaElements.forEach(el => {
                el.classList.remove('hidden');
                el.disabled = false;
            });
            
            // Sembunyikan input manual
            luarNegeriElements.forEach(el => {
                el.classList.add('hidden');
                el.disabled = true;
                el.value = ''; // Reset value
            });
            
            // Update labels
            if (provinsiLabel) provinsiLabel.textContent = 'Provinsi';
            if (kabupatenLabel) kabupatenLabel.textContent = 'Kabupaten/Kota';
            if (kecamatanLabel) kecamatanLabel.textContent = 'Kecamatan';
            if (desaLabel) desaLabel.textContent = 'Desa/Kelurahan';
            
            // Reset dropdown kabupaten, kecamatan, desa
            kabupaten.disabled = true;
            kecamatan.disabled = true;
            desa.disabled = true;
            kabupaten.innerHTML = '<option value="">Pilih Kabupaten</option>';
            kecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desa.innerHTML = '<option value="">Pilih Desa</option>';
            
        } else {
            // Sembunyikan dropdown Indonesia
            indonesiaElements.forEach(el => {
                el.classList.add('hidden');
                el.disabled = true;
            });
            
            // Tampilkan input manual
            luarNegeriElements.forEach(el => {
                el.classList.remove('hidden');
                el.disabled = false;
            });
            
            // Update labels
            if (provinsiLabel) provinsiLabel.textContent = 'Negara';
            if (kabupatenLabel) kabupatenLabel.textContent = 'Kota';
            if (kecamatanLabel) kecamatanLabel.textContent = 'Wilayah/District';
            if (desaLabel) desaLabel.textContent = 'Alamat Lengkap';
        }
        
        // Update alamat final setiap kali switch
        if (typeof gabungAlamat === 'function') {
            gabungAlamat();
        }
    }

    // Event listener untuk radio button
    tipeAlamatRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            switchAlamatType(this.value);
        });
    });

    // Initialize dengan Indonesia
    switchAlamatType('indonesia');

    // ========== LOAD WILAYAH INDONESIA (API) ==========
    
    // Load Provinsi
    fetch(`${API}/provinsi`)
        .then(res => res.json())
        .then(data => {
            data.forEach(p => {
                provinsi.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        })
        .catch(err => console.error('Error loading provinsi:', err));

    // Provinsi → Kabupaten
    provinsi.addEventListener('change', function () {
        kabupaten.disabled = true;
        kecamatan.disabled = true;
        desa.disabled = true;

        kabupaten.innerHTML = '<option value="">Pilih Kabupaten</option>';
        kecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
        desa.innerHTML = '<option value="">Pilih Desa</option>';

        if (!this.value) {
            if (typeof gabungAlamat === 'function') gabungAlamat();
            return;
        }

        fetch(`${API}/kabupaten/${this.value}`)
            .then(res => res.json())
            .then(data => {
                kabupaten.disabled = false;
                data.forEach(k => {
                    kabupaten.innerHTML += `<option value="${k.id}">${k.name}</option>`;
                });
                if (typeof gabungAlamat === 'function') gabungAlamat();
            })
            .catch(err => console.error('Error loading kabupaten:', err));
    });

    // Kabupaten → Kecamatan
    kabupaten.addEventListener('change', function () {
        kecamatan.disabled = true;
        desa.disabled = true;

        kecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
        desa.innerHTML = '<option value="">Pilih Desa</option>';

        if (!this.value) {
            if (typeof gabungAlamat === 'function') gabungAlamat();
            return;
        }

        fetch(`${API}/kecamatan/${this.value}`)
            .then(res => res.json())
            .then(data => {
                kecamatan.disabled = false;
                data.forEach(k => {
                    kecamatan.innerHTML += `<option value="${k.id}">${k.name}</option>`;
                });
                if (typeof gabungAlamat === 'function') gabungAlamat();
            })
            .catch(err => console.error('Error loading kecamatan:', err));
    });

    // Kecamatan → Desa
    kecamatan.addEventListener('change', function () {
        desa.disabled = true;
        desa.innerHTML = '<option value="">Pilih Desa</option>';

        if (!this.value) {
            if (typeof gabungAlamat === 'function') gabungAlamat();
            return;
        }

        fetch(`${API}/desa/${this.value}`)
            .then(res => res.json())
            .then(data => {
                desa.disabled = false;
                data.forEach(d => {
                    desa.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                });
                if (typeof gabungAlamat === 'function') gabungAlamat();
            })
            .catch(err => console.error('Error loading desa:', err));
    });

    // ========== GABUNG ALAMAT (Indonesia & Luar Negeri) ==========
    function gabungAlamat() {
        if (!alamatFinal) return;
        
        const tipeAlamat = document.querySelector('input[name="tipe_alamat"]:checked')?.value || 'indonesia';
        
        if (tipeAlamat === 'indonesia') {
            // Gabung alamat Indonesia (dari dropdown)
            alamatFinal.value = [
                alamatJalan?.value,
                desa.options[desa.selectedIndex]?.text !== 'Pilih Desa' ? desa.options[desa.selectedIndex]?.text : '',
                kecamatan.options[kecamatan.selectedIndex]?.text !== 'Pilih Kecamatan' ? kecamatan.options[kecamatan.selectedIndex]?.text : '',
                kabupaten.options[kabupaten.selectedIndex]?.text !== 'Pilih Kabupaten' ? kabupaten.options[kabupaten.selectedIndex]?.text : '',
                provinsi.options[provinsi.selectedIndex]?.text !== 'Pilih Provinsi' ? provinsi.options[provinsi.selectedIndex]?.text : '',
            ].filter(Boolean).join(', ');
        } else {
            // Gabung alamat Luar Negeri (dari input manual)
            alamatFinal.value = [
                alamatJalan?.value,
                desaManual?.value,
                kecamatanManual?.value,
                kabupatenManual?.value,
                provinsiManual?.value,
            ].filter(Boolean).join(', ');
        }
    }

    // Event listeners untuk update alamat
    if (provinsi) provinsi.addEventListener('change', gabungAlamat);
    if (kabupaten) kabupaten.addEventListener('change', gabungAlamat);
    if (kecamatan) kecamatan.addEventListener('change', gabungAlamat);
    if (desa) desa.addEventListener('change', gabungAlamat);
    if (alamatJalan) alamatJalan.addEventListener('input', gabungAlamat);
    
    // Event listeners untuk input manual (Luar Negeri)
    if (provinsiManual) provinsiManual.addEventListener('input', gabungAlamat);
    if (kabupatenManual) kabupatenManual.addEventListener('input', gabungAlamat);
    if (kecamatanManual) kecamatanManual.addEventListener('input', gabungAlamat);
    if (desaManual) desaManual.addEventListener('input', gabungAlamat);

});
</script>

