<div id="modalUploadDokumen" 
     style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 1rem;">
    
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
         onclick="event.stopPropagation()">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between sticky top-0 z-10 rounded-t-xl">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload Dokumen Pendaftaran
            </h3>
            <button onclick="closeModalUploadDokumen()" 
                    type="button"
                    class="text-white hover:text-gray-200 transition-colors text-2xl leading-none">
                ×
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6">
            
            {{-- Alert Messages --}}
            <div id="uploadAlert" style="display: none;" class="mb-4 p-4 rounded-lg"></div>

            {{-- Info Box --}}
            <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Ketentuan Upload:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Dokumen PDF maksimal 5MB per file</li>
                            <li>Foto format JPG/JPEG maksimal 2MB</li>
                            <li>Pastikan dokumen terlihat jelas dan tidak buram</li>
                        </ul>
                    </div>
                </div>
            </div>

            <form id="formUploadDokumen" action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">

                    {{-- Ijazah --}}
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Fotokopi Ijazah SMA/SMK/MA <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               name="dokumen[ijazah]" 
                               id="file_ijazah"
                               accept=".pdf" 
                               required
                               class="block w-full text-sm text-gray-600 
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                      hover:file:bg-blue-100 file:cursor-pointer cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format: PDF, Max: 5MB</p>
                    </div>

                    {{-- Nilai UN --}}
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Fotokopi Nilai Ujian Nasional <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               name="dokumen[nilai_un]" 
                               id="file_nilai_un"
                               accept=".pdf" 
                               required
                               class="block w-full text-sm text-gray-600 
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                      hover:file:bg-blue-100 file:cursor-pointer cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format: PDF, Max: 5MB</p>
                    </div>

                    {{-- Akte --}}
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Fotokopi Akte Kelahiran <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               name="dokumen[akte]" 
                               id="file_akte"
                               accept=".pdf" 
                               required
                               class="block w-full text-sm text-gray-600 
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                      hover:file:bg-blue-100 file:cursor-pointer cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format: PDF, Max: 5MB</p>
                    </div>

                    {{-- KK --}}
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Fotokopi Kartu Keluarga <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               name="dokumen[kk]" 
                               id="file_kk"
                               accept=".pdf" 
                               required
                               class="block w-full text-sm text-gray-600 
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                      hover:file:bg-blue-100 file:cursor-pointer cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format: PDF, Max: 5MB</p>
                    </div>

                    {{-- Foto --}}
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Pas Foto 3x4 <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               name="dokumen[foto]" 
                               id="file_foto"
                               accept=".jpg,.jpeg" 
                               required
                               class="block w-full text-sm text-gray-600 
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                      file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                      hover:file:bg-blue-100 file:cursor-pointer cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG/JPEG, Max: 2MB</p>
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="mt-6 flex gap-3">
                    <button type="button" 
                            onclick="closeModalUploadDokumen()" 
                            class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit" 
                            id="btnUploadDokumen"
                            class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Dokumen
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
// ============================================
// MODAL UPLOAD DOKUMEN FUNCTIONS
// ============================================

function openModalUploadDokumen() {
    console.log('🔓 Opening modalUploadDokumen');
    const modal = document.getElementById('modalUploadDokumen');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('✅ Modal opened');
    } else {
        console.error('❌ Modal not found!');
    }
}

function closeModalUploadDokumen(reload = false) {
    console.log('🔒 Closing modalUploadDokumen');
    const modal = document.getElementById('modalUploadDokumen');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        
        // Reset form
        const form = document.getElementById('formUploadDokumen');
        if (form) form.reset();
        
        console.log('✅ Modal closed');
        
        if (reload) {
            setTimeout(() => window.location.reload(), 300);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Upload Dokumen script initialized');
    
    const form = document.getElementById('formUploadDokumen');
    const modal = document.getElementById('modalUploadDokumen');
    const alertDiv = document.getElementById('uploadAlert');
    
    // Debug check
    console.log('Form:', form);
    console.log('Modal:', modal);
    
    // Close modal when clicking overlay
    modal?.addEventListener('click', function(e) {
        if (e.target === this) {
            console.log('👆 Clicked overlay');
            closeModalUploadDokumen();
        }
    });
    
    // Close with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modalDisplay = window.getComputedStyle(modal).display;
            if (modalDisplay !== 'none') {
                console.log('⌨️ ESC pressed');
                closeModalUploadDokumen();
            }
        }
    });
    
    // File size validation
    const fileInputs = [
        { id: 'file_ijazah', maxSize: 5, label: 'Ijazah' },
        { id: 'file_nilai_un', maxSize: 5, label: 'Nilai UN' },
        { id: 'file_akte', maxSize: 5, label: 'Akte Kelahiran' },
        { id: 'file_kk', maxSize: 5, label: 'Kartu Keluarga' },
        { id: 'file_foto', maxSize: 2, label: 'Pas Foto' }
    ];
    
    fileInputs.forEach(({ id, maxSize, label }) => {
        const input = document.getElementById(id);
        input?.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024);
                console.log(`📁 File ${label}: ${fileSizeMB.toFixed(2)}MB`);
                
                if (fileSizeMB > maxSize) {
                    showAlert(`File ${label} terlalu besar! Maksimal ${maxSize}MB`, 'error');
                    this.value = '';
                }
            }
        });
    });
    
    // Handle form submit
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('📤 Form submitted');
        
        const submitBtn = document.getElementById('btnUploadDokumen');
        const formData = new FormData(this);
        
        // Debug FormData
        console.log('📦 FormData contents:');
        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                console.log(`  ${key}: ${value.name} (${(value.size / 1024).toFixed(2)}KB)`);
            } else {
                console.log(`  ${key}: ${value}`);
            }
        }
        
        // Validasi semua file terisi
        let allFilled = true;
        let missingFiles = [];
        fileInputs.forEach(({ id, label }) => {
            const input = document.getElementById(id);
            if (!input.files || input.files.length === 0) {
                allFilled = false;
                missingFiles.push(label);
            }
        });
        
        if (!allFilled) {
            showAlert(`File berikut belum diupload: ${missingFiles.join(', ')}`, 'error');
            return;
        }
        
        // Disable button dan show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Mengupload...
        `;
        alertDiv.style.display = 'none';
        
        // Submit form (tidak pakai AJAX karena controller redirect()->back())
        console.log('🚀 Submitting form to:', this.action);
        this.submit();
        
        // Note: Setelah submit(), halaman akan reload/redirect
        // Jadi kode di bawah ini tidak akan dijalankan
    });
    
    // Helper function untuk show alert
    window.showAlert = function(message, type = 'info') {
        const alertDiv = document.getElementById('uploadAlert');
        if (!alertDiv) return;
        
        const colors = {
            success: 'bg-green-50 border-green-200 text-green-800',
            error: 'bg-red-50 border-red-200 text-red-800',
            info: 'bg-blue-50 border-blue-200 text-blue-800'
        };
        
        const icons = {
            success: '✓',
            error: '✕',
            info: 'ℹ'
        };
        
        alertDiv.className = `mb-4 p-4 rounded-lg border ${colors[type] || colors.info}`;
        alertDiv.innerHTML = `
            <div class="flex items-start">
                <span class="text-lg mr-2">${icons[type] || icons.info}</span>
                <span>${message}</span>
            </div>
        `;
        alertDiv.style.display = 'block';
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 5000);
    };
    
    console.log('✅ Upload Dokumen event listeners attached');
});
</script>
@endpush