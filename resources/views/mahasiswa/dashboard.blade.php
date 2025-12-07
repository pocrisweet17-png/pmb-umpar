@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="mb-2">Dashboard PMB</h2>
                    <p class="text-muted mb-0">Selamat datang, <strong>{{ $user->name }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Card --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Progress Pendaftaran</h5>
                        <span class="badge bg-primary fs-6">{{ number_format($percent, 0) }}%</span>
                    </div>
                    
                    <div class="progress" style="height: 30px; border-radius: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                             role="progressbar" 
                             style="width: {{ $percent }}%"
                             aria-valuenow="{{ $percent }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            <strong>{{ number_format($percent, 0) }}% Selesai</strong>
                        </div>
                    </div>

                    @if($nextStep)
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Langkah Selanjutnya:</strong> {{ $nextStep['name'] }}
                        @if($nextStep['key'] === 'is_prodi_selected')
                            <button onclick="openModalProdi()" class="btn btn-sm btn-primary float-end">
                                Lanjutkan <i class="bi bi-arrow-right"></i>
                            </button>
                        @else
                            <a href="{{ route($nextStep['route']) }}" class="btn btn-sm btn-primary float-end">
                                Lanjutkan <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Steps Cards --}}
    <div class="row">
        @foreach($steps as $index => $step)
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm h-100 {{ $step['completed'] ? 'border-success' : '' }}">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            @if($step['completed'])
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; font-size: 24px;">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                            @else
                                <div class="rounded-circle {{ $step['enabled'] ? 'bg-warning' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; font-size: 20px;">
                                    {{ $index + 1 }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow-1">
                            <h5 class="card-title mb-2">
                                {{ $step['name'] }}
                                @if($step['completed'])
                                    <span class="badge bg-success ms-2">Selesai</span>
                                @elseif($step['enabled'])
                                    <span class="badge bg-warning text-dark ms-2">Belum Selesai</span>
                                @else
                                    <span class="badge bg-secondary ms-2">Terkunci</span>
                                @endif
                            </h5>
                            
                            <p class="text-muted mb-3 small">
                                @if($step['completed'])
                                    Langkah ini sudah selesai. Anda dapat melanjutkan ke langkah berikutnya.
                                @elseif($step['enabled'])
                                    Silakan selesaikan langkah ini untuk melanjutkan.
                                @else
                                    Selesaikan langkah sebelumnya terlebih dahulu.
                                @endif
                            </p>

                            @if($step['completed'])
                                @if($step['key'] === 'is_prodi_selected')
                                    <button onclick="openModalProdi()" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-pencil"></i> Ubah Pilihan
                                    </button>
                                @else
                                    <a href="{{ route($step['route']) }}" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                @endif
                            @elseif($step['enabled'])
                                @if($step['key'] === 'is_prodi_selected')
                                    <button onclick="openModalProdi()" class="btn btn-primary btn-sm">
                                        <i class="bi bi-arrow-right-circle"></i> Pilih Prodi
                                    </button>
                                @else
                                    <a href="{{ route($step['route']) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-arrow-right-circle"></i> Lanjutkan
                                    </a>
                                @endif
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-lock"></i> Terkunci
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Info Footer --}}
    @if($percent == 100)
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="alert alert-success shadow-sm border-0">
                <h5 class="alert-heading"><i class="bi bi-trophy-fill me-2"></i>Selamat!</h5>
                <p class="mb-0">Anda telah menyelesaikan semua langkah pendaftaran. Selamat bergabung!</p>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- MODAL PILIH PRODI --}}
<div id="modalPilihProdi" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 9999;">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg relative" style="background: white; padding: 2rem; border-radius: 1rem; width: 90%; max-width: 500px; position: relative;">
        
        {{-- Tombol Close --}}
        <button type="button" onclick="closeModalProdi()" 
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; cursor: pointer; font-size: 1.5rem; color: #9ca3af;">
            ×
        </button>

        <h2 class="text-xl font-bold mb-4 text-center text-gray-800" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; text-align: center;">
            Pilih 2 Program Studi
        </h2>
        <p class="text-sm text-gray-600 mb-4 text-center" style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem; text-align: center;">
            Pilih fakultas terlebih dahulu, kemudian pilih 2 program studi yang Anda minati
        </p>

        <form action="{{ route('prodi.store') }}" method="POST" id="formPilihProdi">
            @csrf

            {{-- Fakultas --}}
            <div class="mb-4" style="margin-bottom: 1rem;">
                <label class="block font-semibold text-gray-700 mb-2" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Pilih Fakultas
                </label>
                <select id="selectFakultas" required class="form-select w-full" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem;">
                    <option value="">-- Pilih Fakultas --</option>
                    @foreach($fakultas as $f)
                        <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Prodi 1 --}}
            <div class="mb-4" style="margin-bottom: 1rem;">
                <label class="block font-semibold text-gray-700 mb-2" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    <span class="badge bg-primary">1</span> Pilihan 1 (Prioritas Utama)
                </label>
                <select name="pilihan_1" id="selectProdi1" required class="form-select w-full" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem;">
                    <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                </select>
            </div>

            {{-- Prodi 2 --}}
            <div class="mb-4" style="margin-bottom: 1rem;">
                <label class="block font-semibold text-gray-700 mb-2" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    <span class="badge bg-success">2</span> Pilihan 2 (Alternatif)
                </label>
                <select name="pilihan_2" id="selectProdi2" required class="form-select w-full" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem;">
                    <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                </select>
            </div>

            {{-- Error Message --}}
            <div id="errorMessage" class="alert alert-danger" style="display: none; padding: 0.75rem; margin-bottom: 1rem; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; border-radius: 0.5rem; font-size: 0.875rem;">
            </div>

            {{-- Loading State --}}
            <div id="loadingProdi" class="text-center" style="display: none; text-align: center; margin-bottom: 1rem; color: #6b7280;">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Memuat data prodi...
            </div>

            {{-- Submit Button --}}
            <button type="submit" id="btnSubmitProdi" class="btn btn-primary w-100" style="width: 100%; padding: 0.75rem; background: #3b82f6; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                Simpan Pilihan
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Fungsi untuk membuka modal
function openModalProdi() {
    const modal = document.getElementById('modalPilihProdi');
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Fungsi untuk menutup modal
function closeModalProdi() {
    const modal = document.getElementById('modalPilihProdi');
    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.addEventListener("DOMContentLoaded", function () {
    const fakultasSelect = document.getElementById("selectFakultas");
    const prodi1Select = document.getElementById("selectProdi1");
    const prodi2Select = document.getElementById("selectProdi2");
    const loadingDiv = document.getElementById("loadingProdi");
    const errorDiv = document.getElementById("errorMessage");
    
    // Handle fakultas change
    fakultasSelect?.addEventListener("change", function () {
        const fakultas = this.value;
        
        prodi1Select.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
        prodi2Select.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
        errorDiv.style.display = 'none';
        
        if (!fakultas) return;
        
        loadingDiv.style.display = 'block';
        prodi1Select.disabled = true;
        prodi2Select.disabled = true;
        
        fetch(`/api/prodi-by-fakultas?fakultas=${encodeURIComponent(fakultas)}`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal memuat data prodi');
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    throw new Error('Tidak ada program studi untuk fakultas ini');
                }
                
                const options = data.map(p => 
                    `<option value="${p.kodeProdi}">${p.namaProdi} (${p.jenjang})</option>`
                ).join("");
                
                const html = `<option value="">-- Pilih Program Studi --</option>${options}`;
                
                prodi1Select.innerHTML = html;
                prodi2Select.innerHTML = html;
                prodi1Select.disabled = false;
                prodi2Select.disabled = false;
                loadingDiv.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = error.message || 'Terjadi kesalahan saat memuat data';
                errorDiv.style.display = 'block';
                loadingDiv.style.display = 'none';
            });
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
    
    // Form validation
    document.getElementById('formPilihProdi')?.addEventListener('submit', function(e) {
        const val1 = prodi1Select.value;
        const val2 = prodi2Select.value;
        
        if (!val1 || !val2) {
            e.preventDefault();
            errorDiv.textContent = 'Harap pilih kedua program studi!';
            errorDiv.style.display = 'block';
            return false;
        }
        
        if (val1 === val2) {
            e.preventDefault();
            errorDiv.textContent = 'Pilihan 1 dan Pilihan 2 tidak boleh sama!';
            errorDiv.style.display = 'block';
            return false;
        }
    });
    
    // Close when clicking outside
    document.getElementById('modalPilihProdi')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModalProdi();
        }
    });
    
    // Close with ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalProdi();
        }
    });
});
</script>
@endpush

<style>
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .progress {
        overflow: visible;
    }

    .badge {
        font-weight: 600;
    }
    
    .fixed {
        position: fixed !important;
    }
    
    .inset-0 {
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    
    .hidden {
        display: none !important;
    }
</style>
@endsection