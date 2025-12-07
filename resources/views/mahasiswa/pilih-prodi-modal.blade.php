<!-- Modal Pilih Prodi -->
<div id="modalPilihProdi" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg relative">
        
        <!-- Tombol Close -->
        <button type="button" onclick="closeModalProdi()" 
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <h2 class="text-xl font-bold mb-4 text-center text-gray-800">Pilih 2 Program Studi</h2>
        <p class="text-sm text-gray-600 mb-4 text-center">Pilih fakultas terlebih dahulu, kemudian pilih 2 program studi yang Anda minati</p>

        <form action="{{ route('prodi.store') }}" method="POST" id="formPilihProdi">
            @csrf

            <!-- Fakultas -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    <i class="bi bi-building"></i> Pilih Fakultas
                </label>
                <select id="selectFakultas" required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Fakultas --</option>
                    @foreach($fakultas as $f)
                        <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Prodi 1 -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    <i class="bi bi-1-circle-fill text-blue-600"></i> Pilihan 1 (Prioritas Utama)
                </label>
                <select name="pilihan_1" id="selectProdi1" required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                </select>
            </div>

            <!-- Prodi 2 -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    <i class="bi bi-2-circle-fill text-green-600"></i> Pilihan 2 (Alternatif)
                </label>
                <select name="pilihan_2" id="selectProdi2" required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                </select>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="hidden mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
            </div>

            <!-- Loading State -->
            <div id="loadingProdi" class="hidden mb-4 text-center text-gray-600">
                <svg class="animate-spin h-5 w-5 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memuat data prodi...
            </div>

            <!-- Submit Button -->
            <button type="submit" id="btnSubmitProdi"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-200 ease-in-out transform hover:scale-105">
                <i class="bi bi-check-circle-fill mr-2"></i>
                Simpan Pilihan
            </button>
        </form>
    </div>
</div>

<script>
// Fungsi untuk membuka modal
function openModalProdi() {
    document.getElementById('modalPilihProdi').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

// Fungsi untuk menutup modal
function closeModalProdi() {
    document.getElementById('modalPilihProdi').classList.add('hidden');
    document.body.style.overflow = 'auto'; // Allow scrolling
}

// Event listener untuk fakultas
document.addEventListener("DOMContentLoaded", function () {
    const fakultasSelect = document.getElementById("selectFakultas");
    const prodi1Select = document.getElementById("selectProdi1");
    const prodi2Select = document.getElementById("selectProdi2");
    const loadingDiv = document.getElementById("loadingProdi");
    const errorDiv = document.getElementById("errorMessage");
    
    // Handle fakultas change
    fakultasSelect?.addEventListener("change", function () {
        const fakultas = this.value;
        
        // Reset prodi selects
        prodi1Select.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
        prodi2Select.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
        errorDiv.classList.add('hidden');
        
        if (!fakultas) return;
        
        // Show loading
        loadingDiv.classList.remove('hidden');
        prodi1Select.disabled = true;
        prodi2Select.disabled = true;
        
        // Fetch prodi data
        fetch(`/api/prodi-by-fakultas?fakultas=${encodeURIComponent(fakultas)}`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal memuat data prodi');
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    throw new Error('Tidak ada program studi untuk fakultas ini');
                }
                
                // Build options
                const options = data.map(p => 
                    `<option value="${p.kodeProdi}">${p.namaProdi} (${p.jenjang})</option>`
                ).join("");
                
                const html = `<option value="">-- Pilih Program Studi --</option>${options}`;
                
                prodi1Select.innerHTML = html;
                prodi2Select.innerHTML = html;
                
                // Enable selects
                prodi1Select.disabled = false;
                prodi2Select.disabled = false;
                
                loadingDiv.classList.add('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = error.message || 'Terjadi kesalahan saat memuat data';
                errorDiv.classList.remove('hidden');
                loadingDiv.classList.add('hidden');
            });
    });
    
    // Prevent selecting same prodi
    prodi1Select?.addEventListener("change", function() {
        const val1 = this.value;
        if (val1 && val1 === prodi2Select.value) {
            errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
            errorDiv.classList.remove('hidden');
            this.value = '';
        } else {
            errorDiv.classList.add('hidden');
        }
    });
    
    prodi2Select?.addEventListener("change", function() {
        const val2 = this.value;
        if (val2 && val2 === prodi1Select.value) {
            errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
            errorDiv.classList.remove('hidden');
            this.value = '';
        } else {
            errorDiv.classList.add('hidden');
        }
    });
    
    // Form validation before submit
    document.getElementById('formPilihProdi')?.addEventListener('submit', function(e) {
        const val1 = prodi1Select.value;
        const val2 = prodi2Select.value;
        
        if (!val1 || !val2) {
            e.preventDefault();
            errorDiv.textContent = 'Harap pilih kedua program studi!';
            errorDiv.classList.remove('hidden');
            return false;
        }
        
        if (val1 === val2) {
            e.preventDefault();
            errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
            errorDiv.classList.remove('hidden');
            return false;
        }
    });
    
    // Close modal when clicking outside
    document.getElementById('modalPilihProdi')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModalProdi();
        }
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalProdi();
        }
    });
});
</script>

<style>
    /* Smooth transitions */
    #modalPilihProdi {
        transition: opacity 0.3s ease-in-out;
    }
    
    #modalPilihProdi > div {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Custom scrollbar for selects */
    select {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }
    
    select::-webkit-scrollbar {
        width: 8px;
    }
    
    select::-webkit-scrollbar-track {
        background: #f7fafc;
    }
    
    select::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 4px;
    }
</style>