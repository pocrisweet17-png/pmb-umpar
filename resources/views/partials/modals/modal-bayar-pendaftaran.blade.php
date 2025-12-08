<div id="modalBayarPendaftaran" class="modal-custom">
    <div class="modal-overlay" onclick="closeModalBayarPendaftaran()"></div>

    <div class="modal-content-custom">

        {{-- HEADER --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex align-items-center">
                <button onclick="closeModalBayarPendaftaran()" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div>
                    <h3 class="mb-1">Pembayaran Pendaftaran</h3>
                    <p class="text-muted mb-0">Step 2 dari 8 — Selesaikan pembayaran untuk melanjutkan</p>
                </div>
            </div>
        </div>

        <div class="row">

            {{-- INFORMASI PENDAFTAR --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informasi Pendaftar</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr><td class="text-muted">Nama</td><td>{{ $user->name }}</td></tr>
                            <tr><td class="text-muted">Email</td><td>{{ $user->email }}</td></tr>
                            <tr><td class="text-muted">No HP</td><td>{{ $user->no_whatsapp ?? '-' }}</td></tr>
                        </table>

                        <hr>

                        <h6 class="fw-semibold mb-3"><i class="bi bi-mortarboard"></i> Pilihan Prodi</h6>

                        @if($user->namaProdi_1)
                            <div class="alert alert-light mb-2">
                                <small class="text-muted d-block">Pilihan 1</small>
                                <strong>{{ $user->namaProdi_1 }}</strong><br>
                                <small class="text-muted">{{ $user->fakultas_1 }}</small>
                            </div>
                        @endif

                        @if($user->namaProdi_2)
                            <div class="alert alert-light mb-0">
                                <small class="text-muted d-block">Pilihan 2</small>
                                <strong>{{ $user->namaProdi_2 }}</strong><br>
                                <small class="text-muted">{{ $user->fakultas_2 }}</small>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- RINGKASAN BIAYA --}}
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Biaya</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Biaya Pendaftaran</span>
                            <strong>Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Biaya Admin</span>
                            <span class="text-success fw-bold">GRATIS</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary fs-5">
                                Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- METODE PEMBAYARAN --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Pilih Metode Pembayaran</h5>
                    </div>

                    <div class="card-body">

                        {{-- Jika sudah bayar --}}
                        @if($reg->is_bayar_pendaftaran)
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Pembayaran sudah diverifikasi.
                                <br><br>
                                <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-success">Kembali</a>
                            </div>
                        @else

                            {{-- Tabs --}}
                            <ul class="nav nav-pills mb-4">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#midtrans">
                                        <i class="bi bi-wallet2"></i> Online (Midtrans)
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#manual">
                                        <i class="bi bi-bank"></i> Transfer Manual
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">

                                {{-- MIDTRANS --}}
                                <div class="tab-pane fade show active" id="midtrans">
                                    <div class="text-center py-4">
                                        <i class="bi bi-credit-card text-primary" style="font-size:60px"></i>
                                        <h4>Pembayaran Online</h4>
                                        <p class="text-muted">VA, e-wallet, kartu, dan lain-lain.</p>

                                        <form action="{{ route('bayar.store') }}" method="POST">
                                            @csrf
                                            <button class="btn btn-primary btn-lg">
                                                Bayar Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- MANUAL --}}
                                <div class="tab-pane fade" id="manual">
                                    <div class="alert alert-warning small">
                                        Transfer sesuai nominal & upload bukti pembayaran.
                                    </div>

                                    {{-- Form Upload --}}
                                    <form action="{{ route('qris.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="jumlah" value="{{ $biaya_pendaftaran }}">

                                        <label class="fw-semibold">Upload Bukti Transfer</label>
                                        <input type="file" name="bukti_bayar" class="form-control mb-3" accept="image/*" required>

                                        <button class="btn btn-primary w-100">Upload</button>
                                    </form>
                                </div>

                            </div>

                        @endif

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- JS --}}
<script>
function openModalBayarPendaftaran() {
    document.getElementById('modalBayarPendaftaran').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModalBayarPendaftaran() {
    document.getElementById('modalBayarPendaftaran').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
</script>

<style>
.modal-custom {
    position: fixed;
    inset: 0;
    display: none;
    justify-content: center;
    align-items: flex-start;
    padding-top: 40px;
    z-index: 9999;
}
.modal-custom:not(.hidden) { display: flex; }
.modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.5);
}
.modal-content-custom {
    position: relative;
    width: 90%;
    max-width: 1200px;
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    z-index: 10;
}
</style>
