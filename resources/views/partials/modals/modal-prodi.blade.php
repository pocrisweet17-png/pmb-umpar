{{-- MODAL PILIH PRODI --}}
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
                        required 
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
                        required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                </select>
            </div>

            {{-- Error Message --}}
            <div id="errorMessage" 
                 style="display: none;" 
                 class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            </div>

            {{-- Loading State --}}
            <div id="loadingProdi" 
                 style="display: none;" 
                 class="text-center mb-4 text-gray-600">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-sm">Memuat data prodi...</p>
            </div>

            {{-- Submit Button --}}
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
// ============================================
// MODAL PRODI FUNCTIONS - FIXED VERSION
// ============================================

function openModalProdi() {
    console.log('🔓 Opening modalProdi');
    const modal = document.getElementById('modalProdi');
    
    if (modal) {
        // Gunakan display flex untuk centering
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('✅ Modal displayed with flex');
        console.log('Modal computed style:', window.getComputedStyle(modal).display);
    } else {
        console.error('❌ Modal #modalProdi not found!');
    }
}

function closeModalProdi(reload = false) {
    console.log('🔒 Closing modalProdi');
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
    
    const fakultas1Select = document.getElementById("selectFakultas1");
    const fakultas2Select = document.getElementById("selectFakultas2");
    const prodi1Select = document.getElementById("selectProdi1");
    const prodi2Select = document.getElementById("selectProdi2");
    const loadingDiv = document.getElementById("loadingProdi");
    const errorDiv = document.getElementById("errorMessage");
    const formProdi = document.getElementById('formPilihProdi');
    const modal = document.getElementById('modalProdi');
    
    // Debug check
    console.log('Modal element:', modal);
    console.log('Form element:', formProdi);
    
    // Close modal when clicking overlay
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                console.log('👆 Clicked overlay, closing modal');
                closeModalProdi();
            }
        });
    }
    
    // Close with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modalDisplay = window.getComputedStyle(modal).display;
            if (modalDisplay !== 'none') {
                console.log('⌨️ ESC pressed, closing modal');
                closeModalProdi();
            }
        }
    });
    


// Function untuk load prodi
    function loadProdi(fakultasValue, targetSelect) {
        targetSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
        errorDiv.style.display = 'none';
        
        if (!fakultasValue) return;
        
        loadingDiv.style.display = 'block';
        targetSelect.disabled = true;
        
        fetch(`/api/prodi-by-fakultas?fakultas=${encodeURIComponent(fakultasValue)}`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal memuat data prodi');
                return response.json();
            })
            .then(data => {
                if (data.length === 0) throw new Error('Tidak ada program studi untuk fakultas ini');
                
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
            });
    }

    // Event listener untuk fakultas 1
    fakultas1Select?.addEventListener("change", function () {
        loadProdi(this.value, prodi1Select);
    });

    // Event listener untuk fakultas 2
    fakultas2Select?.addEventListener("change", function () {
        loadProdi(this.value, prodi2Select);
    });

    // Prevent selecting same prodi
    prodi1Select?.addEventListener("change", function() {
        const val1 = this.value;
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

        // Event listener untuk fakultas 1
        fakultas1Select?.addEventListener("change", function () {
            loadProdi(this.value, prodi1Select);
        });

        // Event listener untuk fakultas 2
        fakultas2Select?.addEventListener("change", function () {
            loadProdi(this.value, prodi2Select);
        });

            // Prevent selecting same prodi
            prodi1Select?.addEventListener("change", function() {
                const val1 = this.value;
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
        
        const val1 = prodi1Select.value;
        const val2 = prodi2Select.value;
        
        // Validasi
        if (!val1 || !val2) {
            errorDiv.textContent = 'Harap pilih kedua program studi!';
            errorDiv.style.display = 'block';
            return false;
        }
        
        if (val1 === val2) {
            errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
            errorDiv.style.display = 'block';
            return false;
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
                
                // Show success message
                alert(data.message || 'Pilihan program studi berhasil disimpan!');
                
                // Redirect
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
            
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Pilihan';
        });
    });
    
    console.log('All event listeners attached');
});
</script>
@endpush