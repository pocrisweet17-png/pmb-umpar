<div id="modalProdi" 
     style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg relative mx-4" 
         style="background: white; padding: 2rem; border-radius: 1rem; max-width: 28rem; position: relative; max-height: 90vh; overflow-y: auto;"
         onclick="event.stopPropagation()">
        
        {{-- Tombol Close --}}
        <button type="button" 
                onclick="closeModalProdi()" 
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 2rem; cursor: pointer; line-height: 1; color: #9ca3af;">
            ×
        </button>

        <h2 class="text-xl font-bold mb-4 text-center text-gray-800">
            Pilih 2 Program Studi
        </h2>
        <p class="text-sm text-gray-600 mb-4 text-center">
            Pilih fakultas terlebih dahulu, kemudian pilih 2 program studi yang Anda minati
        </p>

        <form action="{{ route('prodi.store') }}" method="POST" id="formPilihProdi">
            @csrf

            {{-- untk jenjang --}}
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    <span class="inline-block px-2 py-1 bg-blue-500 text-white text-lg rounded mr-1">Pilih Jenjang</span> 
                    <span class="text-red-500">*</span>
                </label>
                <select id="selectJenjang" 
                        required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Jenjang --</option>
                    <option value="S1">S1 (Sarjana)</option>
                    <option value="S2">S2 (Magister)</option>
                    <option value="S3">S3 (Doktor)</option>
                    <option value="Profesi">Profesi</option>
                </select>
            </div>
            {{-- Fakultas --}}
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    Pilih Fakultas <span class="text-red-500">*</span>
                </label>
            <select id="selectFakultas1" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Fakultas --</option>
                    @foreach($fakultas as $f)
                        <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Prodi 1 --}}
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    <span class="inline-block px-2 py-1 bg-blue-600 text-white text-xs rounded mr-1">1</span> 
                    Pilihan 1 (Prioritas Utama) <span class="text-red-500">*</span>
                </label>
                <select name="pilihan_1" 
                        id="selectProdi1" 
                        required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                </select>
            </div>
            {{-- Fakultas untuk Pilihan 2 --}}
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    Pilih Fakultas <span class="text-red-500">*</span>
                </label>
                <select id="selectFakultas2" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Fakultas --</option>
                    @foreach($fakultas as $f)
                        <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Prodi 2 --}}
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    <span class="inline-block px-2 py-1 bg-green-600 text-white text-xs rounded mr-1">2</span> 
                    Pilihan 2 (Alternatif) <span class="text-red-500">*</span>
                </label>
                <select name="pilihan_2" 
                        id="selectProdi2" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                </select>
            </div>

            <div id="errorMessage" 
                 style="display: none;" 
                 class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            </div>

            <div id="loadingProdi" 
                 style="display: none;" 
                 class="text-center mb-4 text-gray-600">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-sm">Memuat data prodi...</p>
            </div>

            <button type="submit" 
                    id="btnSubmitProdi" 
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                Simpan Pilihan
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
// MODAL PRODI 

function openModalProdi() {
    console.log('🔓 Opening modalProdi');
    const modal = document.getElementById('modalProdi');
    
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('✅ Modal ditampilkan');
    } else {
        console.error('❌ Modal #tidak di temukan');
    }
}

function closeModalProdi(reload = false) {
    console.log('🔒 Tutup modalProdi');
    const modal = document.getElementById('modalProdi');
    
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        console.log('✅ Modal closed');
        
        if (reload) {
            setTimeout(() => window.location.reload(), 300);
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    console.log('🚀 Modal Prodi script initialized');
    
    const jenjangSelect = document.getElementById("selectJenjang");
    const fakultas1Select = document.getElementById("selectFakultas1");
    const fakultas2Select = document.getElementById("selectFakultas2");
    const prodi1Select = document.getElementById("selectProdi1");
    const prodi2Select = document.getElementById("selectProdi2");
    const loadingDiv = document.getElementById("loadingProdi");
    const errorDiv = document.getElementById("errorMessage");
    const formProdi = document.getElementById('formPilihProdi');
    const modal = document.getElementById('modalProdi');
    
    // Close modal 
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModalProdi();
            }
        });
    }
    
    // Close pake ESC 
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modalDisplay = window.getComputedStyle(modal).display;
            if (modalDisplay !== 'none') {
                closeModalProdi();
            }
        }
    });

    // FUNGSI LOAD PRODI DENGAN FILTER JENJANG 
    function loadProdi(fakultasValue, targetSelect) {
        targetSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
        errorDiv.style.display = 'none';
        
        if (!fakultasValue) return;
        
        const jenjang = jenjangSelect.value;
        if (!jenjang) {
            errorDiv.textContent = 'Harap pilih jenjang terlebih dahulu!';
            errorDiv.style.display = 'block';
            return;
        }
        
        loadingDiv.style.display = 'block';
        targetSelect.disabled = true;
        
        // Tambahkan parameter jenjang ke API call
        fetch(`/api/prodi-by-fakultas?fakultas=${encodeURIComponent(fakultasValue)}&jenjang=${encodeURIComponent(jenjang)}`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal memuat data prodi');
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    throw new Error(`Tidak ada program studi ${jenjang} untuk fakultas ini`);
                }
                
                const options = data.map(p => 
                    `<option value="${p.kodeProdi}">${p.namaProdi}</option>`
                ).join("");
                
                targetSelect.innerHTML = `<option value="">-- Pilih Program Studi --</option>${options}`;
                targetSelect.disabled = false;
                loadingDiv.style.display = 'none';
            })
            .catch(error => {
                errorDiv.textContent = error.message || 'Terjadi kesalahan';
                errorDiv.style.display = 'block';
                loadingDiv.style.display = 'none';
                targetSelect.disabled = false;
            });
    }

    //  EVENT LISTENER JENJANG
    jenjangSelect?.addEventListener("change", function () {
        const selectedJenjang = this.value;
        
        // Reset semua dropdown
        fakultas1Select.value = '';
        fakultas2Select.value = '';
        prodi1Select.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
        prodi2Select.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
        errorDiv.style.display = 'none';
        
        // Jika S3 dipilih, sembunyikan pilihan 2
        if (selectedJenjang === 'S3' || selectedJenjang === 'Profesi') {
            document.querySelector('label[for="selectFakultas2"]').parentElement.style.display = 'none';
            document.querySelector('label[for="selectProdi2"]').parentElement.style.display = 'none';
            
            // tidak harus isi dua dua prodi dan fakultas untuk S3 dan profesi
            prodi2Select.required = false;
            fakultas2Select.required = false;
        } else {
            document.querySelector('label[for="selectFakultas2"]').parentElement.style.display = 'block';
            document.querySelector('label[for="selectProdi2"]').parentElement.style.display = 'block';
            prodi2Select.required = true;
            fakultas2Select.required = true;
        }
    });

    // Event listener untuk fakultas 1
    fakultas1Select?.addEventListener("change", function () {
        loadProdi(this.value, prodi1Select);
    });

    // Event listener untuk fakultas 2
    fakultas2Select?.addEventListener("change", function () {
        loadProdi(this.value, prodi2Select);
    });

    // hindari prodi terpilih sama
    prodi1Select?.addEventListener("change", function() {
        const val1 = this.value;
        const jenjang = jenjangSelect.value;
        
        if ((jenjang === 'S3' || jenjang === 'Profesi') && val1) {
            prodi2Select.value = '';
            prodi2Select.innerHTML = '<option value="">-- Tidak Perlu Diisi --</option>';
            return;
        }
        
        if (val1 && val1 === prodi2Select.value) {
            errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
            errorDiv.style.display = 'block';
            this.value = '';
        } else {
            errorDiv.style.display = 'none';
        }
    });

    prodi2Select?.addEventListener("change", function() {
        const val2 = this.value;
        if (val2 && val2 === prodi1Select.value) {
            errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
            errorDiv.style.display = 'block';
            this.value = '';
        } else {
            errorDiv.style.display = 'none';
        }
    });

    // Handle form submit
    formProdi?.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted');
        
        const jenjang = jenjangSelect.value;
        const val1 = prodi1Select.value;
        let val2 = prodi2Select.value;
        
        // Validasi jenjang
        if (!jenjang) {
            errorDiv.textContent = 'Harap pilih jenjang!';
            errorDiv.style.display = 'block';
            return false;
        }
        
        // Validasi pilihan 1
        if (!val1) {
            errorDiv.textContent = 'Harap pilih program studi pilihan 1!';
            errorDiv.style.display = 'block';
            return false;
        }
        
        // Untuk S3 dan Profesi, pilihan 2 opsional (bisa kosong)
        if (jenjang === 'S3' || jenjang === 'Profesi') {
            // Pilihan 2 tidak wajib, bisa kosong atau null
            val2 = val2 || null;
        } else {
            if (!val2) {
                errorDiv.textContent = 'Harap pilih kedua program studi!';
                errorDiv.style.display = 'block';
                return false;
            }
            
            if (val1 === val2) {
                errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
                errorDiv.style.display = 'block';
                return false;
            }
        }
        
        // Disable button
        const submitBtn = document.getElementById('btnSubmitProdi');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span> Menyimpan...';
        errorDiv.style.display = 'none';
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                       || document.querySelector('input[name="_token"]')?.value;
        
        console.log('CSRF Token:', csrfToken ? 'Found' : 'Not found');
        
        // Kirim data
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                pilihan_1: val1,
                pilihan_2: val2
            })
        })
        .then(response => {
            console.log('Submit response status:', response.status);
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            console.log('Submit success:', data);
            
            if (data.success) {
                closeModalProdi();
                alert(data.message || 'Pilihan program studi berhasil disimpan!');
                
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.reload();
                }
            } else {
                throw new Error(data.message || 'Gagal menyimpan pilihan');
            }
        })
        .catch(error => {
            console.error('Submit error:', error);
            
            let errorMessage = 'Terjadi kesalahan saat menyimpan data';
            
            if (error.errors) {
                errorMessage = Object.values(error.errors).flat().join(', ');
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            errorDiv.textContent = errorMessage;
            errorDiv.style.display = 'block';
            
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Pilihan';
        });
    });
    
    console.log('All event listeners attached');
});
</script>
@endpush