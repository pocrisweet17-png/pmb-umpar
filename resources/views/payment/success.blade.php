<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - PMB UMPAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .success-card {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .success-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-header">
            <i class="bi bi-check-circle-fill success-icon"></i>
            <h2>Pembayaran Berhasil!</h2>
            <p class="mb-0">Terima kasih telah melakukan pembayaran</p>
        </div>
        
        <div class="p-4">
            <div class="alert alert-success">
                <strong>Status:</strong> Pembayaran Anda telah berhasil diverifikasi dan registrasi Anda sudah aktif.
            </div>
            
            <h5 class="mb-3">Detail Transaksi</h5>
            
            <div class="detail-row">
                <span>Order ID</span>
                <strong>{{ $payment->order_id }}</strong>
            </div>
            
            <div class="detail-row">
                <span>ID Transaksi</span>
                <strong>{{ $payment->id_transaksi }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Metode Pembayaran</span>
                <strong>{{ strtoupper(str_replace('_', ' ', $payment->tipe_pembayaran)) }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Total Bayar</span>
                <strong class="text-success">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Tanggal & Waktu</span>
                <strong>{{ $payment->updated_at->format('d/m/Y H:i:s') }}</strong>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3">Informasi Pendaftar</h5>
            
            <div class="detail-row">
                <span>Nama</span>
                <strong>{{ $registrasi->nama }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Email</span>
                <strong>{{ $registrasi->email }}</strong>
            </div>
            
            <div class="detail-row">
                <span>Program Studi</span>
                <strong>{{ $registrasi->kodeProdi }}</strong>
            </div>
            <div class="detail-row">
                <span>NIM</span>
                <strong>{{ $user->nim ?? 'Belum tersedia' }}</strong>
            </div>
            
            <div class="alert alert-info mt-4">
                <strong><i class="bi bi-info-circle"></i> Informasi:</strong>
                <ul class="mb-0 mt-2">
                    <li>Bukti pembayaran telah dikirim ke email Anda</li>
                    <li>Silakan cek email untuk informasi lebih lanjut</li>
                    <li>Simpan bukti pembayaran ini untuk keperluan administrasi</li>
                </ul>
            </div>
            
            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-outline-primary me-2">
                    <i class="bi bi-printer"></i> Cetak Bukti
                </button>
                <a href="/" class="btn btn-success">
                    <i class="bi bi-house"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>