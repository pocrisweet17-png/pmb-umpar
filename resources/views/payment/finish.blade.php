@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if($payment && $payment->status_transaksi == 'settlement')
            {{-- SUCCESS --}}
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="success-checkmark mx-auto">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-success mb-3">Pembayaran Berhasil!</h2>
                    <p class="text-muted mb-4">
                        Terima kasih, pembayaran Anda telah berhasil diverifikasi.
                    </p>

                    <div class="bg-light rounded p-4 mb-4">
                        <div class="row text-start">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Invoice Number</small>
                                <strong>{{ $payment->order_id }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Jumlah Pembayaran</small>
                                <strong class="text-primary">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Metode Pembayaran</small>
                                <strong>{{ ucfirst($payment->tipe_pembayaran) }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-success">{{ ucfirst($payment->status_transaksi) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info text-start">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-2"></i>Langkah Selanjutnya:</h6>
                        <p class="mb-0">Silakan kembali ke dashboard untuk melanjutkan ke langkah berikutnya yaitu <strong>Daftar Ulang</strong>.</p>
                    </div>

                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-house-door-fill me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>

            @elseif($payment && $payment->status_transaksi == 'pending')
            {{-- PENDING --}}
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="bi bi-hourglass-split text-warning" style="font-size: 80px;"></i>
                    </div>

                    <h2 class="text-warning mb-3">Pembayaran Menunggu</h2>
                    <p class="text-muted mb-4">
                        Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran sesuai instruksi yang diberikan.
                    </p>

                    <div class="bg-light rounded p-4 mb-4">
                        <div class="row text-start">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Invoice Number</small>
                                <strong>{{ $payment->order_id }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Jumlah Pembayaran</small>
                                <strong class="text-primary">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning text-start">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Perhatian:</h6>
                        <p class="mb-0">Selesaikan pembayaran Anda dalam waktu yang ditentukan. Status akan diupdate otomatis setelah pembayaran terverifikasi.</p>
                    </div>

                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-house-door-fill me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>

            @else
            {{-- ERROR/NOT FOUND --}}
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="bi bi-x-circle text-danger" style="font-size: 80px;"></i>
                    </div>

                    <h2 class="text-danger mb-3">Pembayaran Tidak Ditemukan</h2>
                    <p class="text-muted mb-4">
                        Data pembayaran tidak ditemukan atau terjadi kesalahan.
                    </p>

                    <a href="{{ route('bayar.index') }}" class="btn btn-primary me-2">
                        <i class="bi bi-arrow-repeat me-2"></i>Coba Lagi
                    </a>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-house-door-fill me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
/* Success Checkmark Animation */
.success-checkmark {
    width: 80px;
    height: 80px;
    margin: 0 auto;
}

.success-checkmark .check-icon {
    width: 80px;
    height: 80px;
    position: relative;
    border-radius: 50%;
    box-sizing: content-box;
    border: 4px solid #4CAF50;
}

.success-checkmark .check-icon::before {
    top: 3px;
    left: -2px;
    width: 30px;
    transform-origin: 100% 50%;
    border-radius: 100px 0 0 100px;
}

.success-checkmark .check-icon::after {
    top: 0;
    left: 30px;
    width: 60px;
    transform-origin: 0 50%;
    border-radius: 0 100px 100px 0;
    animation: rotate-circle 4.25s ease-in;
}

.success-checkmark .check-icon::before, 
.success-checkmark .check-icon::after {
    content: '';
    height: 100px;
    position: absolute;
    background: #FFFFFF;
    transform: rotate(-45deg);
}

.success-checkmark .check-icon .icon-line {
    height: 5px;
    background-color: #4CAF50;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 10;
}

.success-checkmark .check-icon .icon-line.line-tip {
    top: 46px;
    left: 14px;
    width: 25px;
    transform: rotate(45deg);
    animation: icon-line-tip 0.75s;
}

.success-checkmark .check-icon .icon-line.line-long {
    top: 38px;
    right: 8px;
    width: 47px;
    transform: rotate(-45deg);
    animation: icon-line-long 0.75s;
}

.success-checkmark .check-icon .icon-circle {
    top: -4px;
    left: -4px;
    z-index: 10;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    position: absolute;
    box-sizing: content-box;
    border: 4px solid rgba(76, 175, 80, .5);
}

.success-checkmark .check-icon .icon-fix {
    top: 8px;
    width: 5px;
    left: 26px;
    z-index: 1;
    height: 85px;
    position: absolute;
    transform: rotate(-45deg);
    background-color: #FFFFFF;
}

@keyframes rotate-circle {
    0% {
        transform: rotate(-45deg);
    }
    5% {
        transform: rotate(-45deg);
    }
    12% {
        transform: rotate(-405deg);
    }
    100% {
        transform: rotate(-405deg);
    }
}

@keyframes icon-line-tip {
    0% {
        width: 0;
        left: 1px;
        top: 19px;
    }
    54% {
        width: 0;
        left: 1px;
        top: 19px;
    }
    70% {
        width: 50px;
        left: -8px;
        top: 37px;
    }
    84% {
        width: 17px;
        left: 21px;
        top: 48px;
    }
    100% {
        width: 25px;
        left: 14px;
        top: 45px;
    }
}

@keyframes icon-line-long {
    0% {
        width: 0;
        right: 46px;
        top: 54px;
    }
    65% {
        width: 0;
        right: 46px;
        top: 54px;
    }
    84% {
        width: 55px;
        right: 0px;
        top: 35px;
    }
    100% {
        width: 47px;
        right: 8px;
        top: 38px;
    }
}
</style>
@endsection