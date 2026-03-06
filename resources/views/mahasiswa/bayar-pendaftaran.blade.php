@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="mb-1">Pembayaran Pendaftaran</h2>
                            <p class="text-muted mb-0">Step 2 dari 8 - Selesaikan pembayaran untuk melanjutkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Informasi Mahasiswa & Prodi --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informasi Pendaftar</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td class="text-muted">Nama</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. HP</td>
                            <td>{{ $user->no_whatsapp ?? '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    <h6 class="fw-semibold mb-3"><i class="bi bi-mortarboard-fill text-primary me-2"></i>Pilihan Prodi</h6>
                    
                    @if($user->namaProdi_1)
                    <div class="alert alert-light mb-2">
                        <small class="text-muted d-block">Pilihan 1</small>
                        <strong>{{ $user->namaProdi_1 }}</strong>
                        <br><small class="text-muted">{{ $user->fakultas_1 }}</small>
                    </div>
                    @endif

                    @if($user->namaProdi_2)
                    <div class="alert alert-light mb-0">
                        <small class="text-muted d-block">Pilihan 2</small>
                        <strong>{{ $user->namaProdi_2 }}</strong>
                        <br><small class="text-muted">{{ $user->fakultas_2 }}</small>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Ringkasan Biaya --}}
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Biaya</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Biaya Pendaftaran</span>
                        <span class="fw-semibold">Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Biaya Admin</span>
                        <span class="text-success fw-semibold">GRATIS</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Pembayaran</span>
                        <span class="fw-bold text-primary fs-5">Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Metode Pembayaran --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Pilih Metode Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Alert Jika Sudah Bayar --}}
                    @if($reg->is_bayar_pendaftaran)
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Pembayaran Anda sudah diverifikasi!</strong>
                        <p class="mb-0 mt-2">Silakan lanjutkan ke langkah berikutnya.</p>
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-success mt-3">
                            Kembali ke Dashboard
                        </a>
                    </div>
                    @else

                    {{-- Tab Navigation --}}
                    <ul class="nav nav-pills mb-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="midtrans-tab" data-bs-toggle="pill" 
                                    data-bs-target="#midtrans" type="button" role="tab">
                                <i class="bi bi-wallet2 me-2"></i>Pembayaran Online
                                <span class="badge bg-success ms-2">Otomatis</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manual-tab" data-bs-toggle="pill" 
                                    data-bs-target="#manual" type="button" role="tab">
                                <i class="bi bi-bank me-2"></i>Transfer Manual
                            </button>
                        </li>
                    </ul>

                    {{-- Tab Content --}}
                    <div class="tab-content">
                        
                        {{-- MIDTRANS PAYMENT --}}
                        <div class="tab-pane fade show active" id="midtrans" role="tabpanel">
                            <div class="text-center py-4">
                                <div class="mb-4">
                                    <i class="bi bi-credit-card text-primary" style="font-size: 64px;"></i>
                                </div>
                                <h4 class="mb-3">Pembayaran Online via Midtrans</h4>
                                <p class="text-muted mb-4">
                                    Bayar dengan berbagai metode: Virtual Account, E-Wallet (GoPay, OVO, Dana, ShopeePay), 
                                    Kartu Kredit/Debit, Indomaret, Alfamart, dan lainnya.
                                </p>

                                <div class="row justify-content-center mb-4">
                                    <div class="col-md-8">
                                        <div class="alert alert-info text-start">
                                            <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-2"></i>Keuntungan Pembayaran Online:</h6>
                                            <ul class="mb-0 small">
                                                <li>✅ Langsung terverifikasi otomatis</li>
                                                <li>✅ Bisa bayar 24/7 kapan saja</li>
                                                <li>✅ Pilihan metode pembayaran lengkap</li>
                                                <li>✅ Aman dan terpercaya</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('bayar.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-credit-card-fill me-2"></i>
                                        Bayar Sekarang - Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- MANUAL PAYMENT --}}
                        <div class="tab-pane fade" id="manual" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-3"><i class="bi bi-bank me-2"></i>Informasi Rekening</h5>
                                    
                                    {{-- Bank Transfer --}}
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/200px-BNI_logo.svg.png" 
                                                     alt="BNI" style="height: 30px;" class="me-3">
                                                <div>
                                                    <strong>Bank BNI</strong>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 text-muted">No. Rekening</div>
                                                <div class="col-sm-8">
                                                    <strong class="text-primary">1234567890</strong>
                                                    <button class="btn btn-sm btn-outline-primary ms-2" 
                                                            onclick="copyToClipboard('1234567890')">
                                                        <i class="bi bi-clipboard"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-sm-4 text-muted">Atas Nama</div>
                                                <div class="col-sm-8"><strong>Universitas XXX</strong></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BCA --}}
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/200px-Bank_Central_Asia.svg.png" 
                                                     alt="BCA" style="height: 30px;" class="me-3">
                                                <div>
                                                    <strong>Bank BCA</strong>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 text-muted">No. Rekening</div>
                                                <div class="col-sm-8">
                                                    <strong class="text-primary">9876543210</strong>
                                                    <button class="btn btn-sm btn-outline-primary ms-2" 
                                                            onclick="copyToClipboard('9876543210')">
                                                        <i class="bi bi-clipboard"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-sm-4 text-muted">Atas Nama</div>
                                                <div class="col-sm-8"><strong>Universitas XXX</strong></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Instructions --}}
                                    <div class="alert alert-warning">
                                        <h6 class="fw-semibold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Petunjuk Transfer Manual:</h6>
                                        <ol class="mb-0 small">
                                            <li>Transfer sejumlah <strong>Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}</strong></li>
                                            <li>Simpan bukti transfer (screenshot/foto)</li>
                                            <li>Upload bukti transfer melalui form di bawah</li>
                                            <li>Tunggu verifikasi maksimal 1x24 jam</li>
                                        </ol>
                                    </div>

                                    {{-- Upload Form --}}
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="bi bi-upload me-2"></i>Upload Bukti Transfer</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('qris.upload') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="jumlah" value="{{ $biaya_pendaftaran }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">
                                                        Bukti Transfer <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="file" 
                                                           name="bukti_bayar" 
                                                           class="form-control @error('bukti_bayar') is-invalid @enderror" 
                                                           accept="image/*"
                                                           required
                                                           onchange="previewImage(event)">
                                                    @error('bukti_bayar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB)</small>
                                                </div>

                                                {{-- Preview --}}
                                                <div id="imagePreview" class="mb-3" style="display: none;">
                                                    <label class="form-label fw-semibold">Preview:</label>
                                                    <div class="border rounded p-2">
                                                        <img id="preview" src="" alt="Preview" class="img-fluid" style="max-height: 300px;">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-upload me-2"></i>
                                                    Upload Bukti Transfer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nomor rekening berhasil disalin!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}

// Preview image before upload
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush

<style>
.nav-pills .nav-link {
    border-radius: 10px;
    padding: 12px 20px;
    color: #6c757d;
    transition: all 0.3s;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.nav-pills .nav-link:hover:not(.active) {
    background-color: #f8f9fa;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}
</style>
@endsection