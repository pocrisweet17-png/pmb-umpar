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




@push('scripts')

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
@include('partials.modals.modal-prodi')

