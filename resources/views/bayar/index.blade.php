@extends('layouts.app')

@section('title', 'Pembayaran Pendaftaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        
        @if($user->is_bayar_pendaftaran)
        <!-- Sudah Bayar -->
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="text-green-500 text-6xl mb-4">✓</div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Sudah Lunas</h1>
            <p class="text-gray-600 mb-6">Anda sudah menyelesaikan pembayaran pendaftaran.</p>
            <a href="{{ route('mahasiswa.dashboard') }}" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition">
                Kembali ke Dashboard
            </a>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-lg p-8">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">💳</div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Pendaftaran</h1>
                <p class="text-gray-600">Klik tombol di bawah untuk melanjutkan pembayaran</p>
            </div>

            <!-- Ringkasan -->
            <div class="bg-blue-50 rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-700">Nama</span>
                    <span class="font-semibold">{{ $user->nama_lengkap ?? $user->name }}</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-700">Email</span>
                    <span class="font-semibold">{{ $user->email }}</span>
                </div>
                <hr class="my-4 border-blue-200">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold">Total Pembayaran</span>
                    <span class="text-2xl font-bold text-blue-600">
                        Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Tombol Bayar -->
            <button id="pay-button" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Bayar Sekarang
            </button>

            <!-- Info Metode Pembayaran -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <p class="mb-2">Metode pembayaran tersedia:</p>
                <div class="flex flex-wrap justify-center gap-2">
                    <span class="bg-gray-100 px-3 py-1 rounded">Transfer Bank</span>
                    <span class="bg-gray-100 px-3 py-1 rounded">GoPay</span>
                    <span class="bg-gray-100 px-3 py-1 rounded">ShopeePay</span>
                    <span class="bg-gray-100 px-3 py-1 rounded">QRIS</span>
                    <span class="bg-gray-100 px-3 py-1 rounded">Kartu Kredit</span>
                </div>
            </div>

            <!-- Loading -->
            <div id="loading" class="hidden mt-6 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">Memproses pembayaran...</p>
            </div>
            
            <!-- Error -->
            <div id="error-message" class="hidden mt-6 p-4 bg-red-50 border border-red-200 rounded-lg text-center">
                <p class="text-red-600" id="error-text"></p>
            </div>

        </div>
        @endif

        <!-- Tombol Kembali -->
        <div class="text-center mt-6">
            <a href="{{ route('mahasiswa.dashboard') }}" 
                class="text-blue-600 hover:text-blue-700 font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('pay-button');
    const loading = document.getElementById('loading');
    const errorDiv = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    
    if (payButton) {
        payButton.addEventListener('click', function() {
            // Tampilkan loading
            loading.classList.remove('hidden');
            errorDiv.classList.add('hidden');
            payButton.disabled = true;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Request snap token
            fetch('{{ route("bayar.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                loading.classList.add('hidden');
                payButton.disabled = false;
                
                if (data.success && data.snap_token) {
                    // Store order_id
                    localStorage.setItem('pending_order_id', data.order_id);
                    
                    // Open Snap popup
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=settlement';
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=pending';
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            errorText.textContent = 'Pembayaran gagal. Silakan coba lagi.';
                            errorDiv.classList.remove('hidden');
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                        }
                    });
                } else {
                    errorText.textContent = data.message || 'Gagal membuat transaksi. Silakan coba lagi.';
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loading.classList.add('hidden');
                payButton.disabled = false;
                errorText.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                errorDiv.classList.remove('hidden');
            });
        });
    }
});
</script>
@endsection