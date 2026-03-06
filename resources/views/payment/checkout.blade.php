@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- Card Checkout --}}
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0"><i class="bi bi-credit-card-fill me-2"></i>Pembayaran Pendaftaran</h3>
                </div>
                <div class="card-body p-5 text-center">
                    
                    {{-- Loading State --}}
                    <div id="loadingState">
                        <div class="spinner-border text-primary mb-3" style="width: 4rem; height: 4rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5 class="mb-3">Memproses Pembayaran...</h5>
                        <p class="text-muted">Mohon tunggu, jangan tutup halaman ini</p>
                    </div>

                    {{-- Invoice Info --}}
                    <div class="mt-4 p-3 bg-light rounded">
                        <div class="row text-start">
                            <div class="col-6">
                                <small class="text-muted">Invoice Number</small>
                                <p class="mb-0 fw-semibold">{{ $payment->order_id }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted">Total Pembayaran</small>
                                <p class="mb-0 fw-bold text-primary fs-5">
                                    Rp {{ number_format($jumlah, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="alert alert-info mt-4 text-start">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-2"></i>Informasi:</h6>
                        <ul class="mb-0 small">
                            <li>Halaman pembayaran akan muncul otomatis</li>
                            <li>Pilih metode pembayaran yang Anda inginkan</li>
                            <li>Selesaikan pembayaran sesuai instruksi</li>
                            <li>Status pembayaran akan diupdate otomatis</li>
                        </ul>
                    </div>

                    {{-- Button Manual --}}
                    <button id="pay-button" class="btn btn-primary btn-lg mt-3 d-none">
                        <i class="bi bi-wallet2 me-2"></i>Lanjutkan Pembayaran
                    </button>

                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary mt-3">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    const snapToken = '{{ $snapToken }}';
    
    // Auto trigger payment popup
    window.onload = function() {
        setTimeout(() => {
            payNow();
        }, 1000); // Delay 1 detik untuk user experience
    };

    // Pay function
    function payNow() {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('success', result);
                window.location.href = "{{ route('mahasiswa.dashboard') }}?status=success";
            },
            onPending: function(result) {
                console.log('pending', result);
                window.location.href = "{{ route('mahasiswa.dashboard') }}?status=pending";
            },
            onError: function(result) {
                console.log('error', result);
                alert('Pembayaran gagal! Silakan coba lagi.');
                window.location.href = "{{ route('bayar.index') }}";
            },
            onClose: function() {
                console.log('customer closed the popup without finishing the payment');
                const confirmBack = confirm('Anda belum menyelesaikan pembayaran. Kembali ke halaman sebelumnya?');
                if (confirmBack) {
                    window.location.href = "{{ route('bayar.index') }}";
                } else {
                    // Show manual button
                    document.getElementById('pay-button').classList.remove('d-none');
                    document.getElementById('loadingState').style.display = 'none';
                }
            }
        });
    }

    // Manual button click
    document.getElementById('pay-button')?.addEventListener('click', function() {
        payNow();
    });
</script>

<style>
.spinner-border {
    border-width: 0.3rem;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border: none;
}
</style>
@endsection