@extends('layouts.app')

@section('title', 'Status Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            
            @if($payment && $payment->status_transaksi === 'settlement')
                <!-- Berhasil -->
                <div class="text-green-500 text-6xl mb-4">✓</div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-gray-600 mb-6">
                    Terima kasih. Pembayaran Anda telah berhasil diverifikasi. <br>
                    Lihat NIM Anda di tab Data Pribadi
                </p>
                
                <div class="bg-green-50 rounded-lg p-4 mb-6 text-left">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Order ID</span>
                        <span class="font-semibold">{{ $payment->order_id }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Jumlah</span>
                        <span class="font-semibold">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Tipe</span>
                        <span class="font-semibold">{{ ucfirst($payment->tipe_pembayaran) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="font-semibold text-green-600">Lunas</span>
                    </div>
                </div>
                
            @elseif($transactionStatus === 'pending' || ($payment && $payment->status_transaksi === 'pending'))
                <!-- Pending -->
                <div class="text-yellow-500 text-6xl mb-4">⏳</div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Menunggu Pembayaran</h1>
                <p class="text-gray-600 mb-6">
                    Silakan selesaikan pembayaran Anda sesuai instruksi yang diberikan.
                </p>
                
            @else
                <!-- Gagal/Dibatalkan -->
                <div class="text-red-500 text-6xl mb-4">✕</div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Gagal</h1>
                <p class="text-gray-600 mb-6">
                    Transaksi pembayaran Anda dibatalkan atau gagal.
                </p>
            @endif
            
            <a href="{{ route('mahasiswa.dashboard') }}" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection