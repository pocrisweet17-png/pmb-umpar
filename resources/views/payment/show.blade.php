<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran {{ ucfirst($tipePembayaran) }} - PMB UMPAR</title>
    
    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .payment-card {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        .badge-pembayaran {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            margin-top: 10px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .total-row {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: bold;
        }
        .btn-pay {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 40px;
            font-size: 1.1em;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85em;
        }
        .status-lunas {
            background: #d4edda;
            color: #155724;
        }
        .status-belum {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="payment-card">
        <div class="header">
            <h2>Pembayaran {{ ucfirst($tipePembayaran) }}</h2>
            <p class="mb-0">Universitas Muhammadiyah Parepare</p>
            <div class="badge-pembayaran">
                {{ $registrasi->nomorPendaftaran }}
            </div>
        </div>
        
        <div class="p-4">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            
            <!-- Status Pembayaran -->
            <div class="alert alert-light border">
                <strong>Status Pembayaran:</strong>
                <div class="mt-2">
                    <span class="me-2">Pendaftaran:</span>
                    @if($registrasi->sudahBayarPendaftaran())
                        <span class="status-badge status-lunas">✓ Lunas</span>
                    @else
                        <span class="status-badge status-belum">⏳ Belum Bayar</span>
                    @endif
                </div>
                <div class="mt-2">
                    <span class="me-2">UKT Semester 1:</span>
                    @if($registrasi->sudahBayarUkt())
                        <span class="status-badge status-lunas">✓ Lunas</span>
                    @else
                        <span class="status-badge status-belum">⏳ Belum Bayar</span>
                    @endif
                </div>
            </div>
            
            <h5 class="mb-3">Detail Pendaftaran</h5>
            
            <div class="detail-row">
                <span>Nomor Pendaftaran</span>
                <strong>{{ $registrasi->nomorPendaftaran }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Nama Lengkap</span>
                <strong>{{ $registrasi->namaLengkap }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Program Studi</span>
                <strong>{{ $registrasi->prodiDipilih->namaProdi ?? $registrasi->programStudiPilihan }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Tanggal Daftar</span>
                <strong>{{ $registrasi->tanggalDaftar->format('d/m/Y') }}</strong>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3">Rincian Biaya</h5>
            
            @if($tipePembayaran === 'pendaftaran')
                <div class="detail-row">
                    <span>Biaya Pendaftaran</span>
                    <strong>Rp {{ number_format($biaya->biaya_pendaftaran, 0, ',', '.') }}</strong>
                </div>
                
                <div class="total-row">
                    <div class="d-flex justify-content-between">
                        <span>Total Pembayaran</span>
                        <span class="text-primary">Rp {{ number_format($biaya->biaya_pendaftaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            @else
                <div class="detail-row">
                    <span>UKT Semester 1</span>
                    <strong>Rp {{ number_format($biaya->ukt_semester_1, 0, ',', '.') }}</strong>
                </div>
                
                <div class="total-row">
                    <div class="d-flex justify-content-between">
                        <span>Total Pembayaran</span>
                        <span class="text-primary">Rp {{ number_format($biaya->ukt_semester_1, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif
            
            <div class="alert alert-info">
                <strong>Metode Pembayaran:</strong>
                <ul class="mb-0 mt-2">
                    <li>QRIS</li>
                    <li>Transfer Bank (BCA, BNI, BRI, Permata, BSI)</li>
                </ul>
            </div>
            
            <div class="text-center mt-4">
                <button id="pay-button" class="btn btn-primary btn-pay">
                    <i class="bi bi-credit-card"></i> Bayar Sekarang
                </button>
            </div>

            @if($tipePembayaran === 'pendaftaran')
                <div class="text-center mt-3">
                    <small class="text-muted">Setelah pembayaran pendaftaran selesai, Anda dapat melanjutkan pembayaran UKT</small>
                </div>
            @endif
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Memproses pembayaran...</p>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            const loadingOverlay = document.getElementById('loading-overlay');
            loadingOverlay.style.display = 'block';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch('{{ route('payment.process', [$registrasi->idRegistrasi, $tipePembayaran]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => response.json())
            .then(data => {
                loadingOverlay.style.display = 'none';
                
                if (data.success) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            window.location.href = '{{ route('payment.finish', '') }}/' + data.order_id;
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            window.location.href = '{{ route('payment.finish', '') }}/' + data.order_id;
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            alert('Pembayaran gagal. Silakan coba lagi.');
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                            alert('Anda menutup popup pembayaran. Silakan coba lagi jika ingin melanjutkan.');
                        }
                    });
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                loadingOverlay.style.display = 'none';
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        });
    </script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>