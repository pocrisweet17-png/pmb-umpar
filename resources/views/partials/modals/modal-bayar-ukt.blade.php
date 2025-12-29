<div id="modalBayarUkt" class="fixed inset-0 hidden z-[9999]">
    data-ukt-store-url="{{ route('ukt.store') }}"
     data-ukt-check-url="{{ route('ukt.check-status') }}">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
         onclick="closeModalBayarUkt()"></div>

    <!-- Modal Card -->
    <div class="relative mx-auto mt-10 w-[95%] max-w-6xl bg-white rounded-2xl shadow-2xl overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="flex items-center gap-4 p-6 border-b bg-blue-600 text-white rounded-t-2xl">
            <button onclick="closeModalBayarUkt()"
                class="p-2 bg-white/20 rounded-full hover:bg-white/30 transition">
                ✕
            </button>
            <div>
                <h2 class="text-2xl font-semibold">Pembayaran UKT Semester 1</h2>
                <p class="text-blue-100 text-sm">Step 7 dari 8 — Selesaikan pembayaran UKT untuk melanjutkan</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">

            <!-- INFORMASI MAHASISWA -->
            <div class="space-y-6">
                <!-- Info -->
                <div class="bg-white border rounded-xl shadow p-6">
                    <h3 class="font-semibold text-blue-700 mb-4">Informasi Mahasiswa</h3>

                    <table class="w-full text-sm">
                        <tr>
                            <td class="text-gray-500 py-1">Nama</td>
                            <td class="font-medium">{{ $user->nama_lengkap ?? $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1">Email</td>
                            <td class="font-medium">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1">No HP</td>
                            <td class="font-medium">{{ $user->no_whatsapp ?? '-' }}</td>
                        </tr>
                        @if($user->nim)
                        <tr>
                            <td class="text-gray-500 py-1">NIM</td>
                            <td class="font-medium text-blue-600">{{ $user->nim }}</td>
                        </tr>
                        @endif
                    </table>

                    <hr class="my-4">

                    <h4 class="font-semibold mb-2 text-blue-700">Program Studi</h4>

                    @if($user->pilihan_1)
                        <div class="bg-blue-50 p-3 rounded-lg border text-sm">
                            <p class="font-semibold">{{ $user->namaProdiPilihan1 ?? $user->pilihan_1 }}</p>
                        </div>
                    @endif
                </div>

                <!-- Ringkasan biaya -->
                <div class="bg-white border rounded-xl shadow p-6">
                    <h3 class="font-semibold text-green-700 mb-4">Ringkasan Biaya</h3>

                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Biaya UKT Semester 1</span>
                        <span class="font-semibold">Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-sm mb-4">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="font-bold text-green-600">GRATIS</span>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between">
                        <span class="font-semibold text-lg">Total</span>
                        <span class="text-blue-700 font-bold text-2xl" id="totalBiayaUkt">
                            Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- PEMBAYARAN -->
            <div class="lg:col-span-2">
                <div class="bg-white border rounded-xl shadow">

                    <div class="border-b p-6">
                        <h3 class="font-semibold text-blue-700">Pilih Metode Pembayaran</h3>
                    </div>

                    <div class="p-6">

                        @if($user->is_ukt_paid)
                            <!-- SUDAH BAYAR -->
                            <div class="p-6 bg-green-100 border border-green-300 rounded-xl text-center">
                                <div class="text-green-600 text-5xl mb-3">✓</div>
                                <p class="font-semibold text-green-700 text-lg mb-2">
                                    Pembayaran UKT Sudah Diverifikasi
                                </p>
                                <p class="text-green-600 text-sm mb-4">
                                    Anda dapat melanjutkan ke tahap daftar ulang
                                </p>
                                <button onclick="closeModalBayarUkt()"
                                    class="mt-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Tutup
                                </button>
                            </div>
                        @else
                        
                        <!-- Tabs -->
                        <div class="flex gap-3 mb-6">
                            <button class="tab-btn-bayar-ukt active px-4 py-2 bg-blue-600 text-white rounded-lg font-medium transition"
                                data-target="#onlineTabUkt">
                                💳 Pembayaran Online
                            </button>

                            <button class="tab-btn-bayar-ukt px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium transition hover:bg-gray-200"
                                data-target="#offlineTabUkt">
                                🏢 Pembayaran Tunai
                            </button>
                        </div>

                        <!-- TAB: ONLINE PAYMENT -->
                        <div id="onlineTabUkt" class="tab-content-bayar-ukt block">
                            <div class="text-center py-10">
                                <div class="text-blue-600 text-6xl mb-4">💳</div>
                                <h3 class="text-xl font-semibold mb-2">Pembayaran Online Otomatis</h3>
                                <p class="text-gray-500 mb-2">Bayar dengan mudah menggunakan:</p>
                                
                                <!-- Metode Pembayaran -->
                                <div class="flex flex-wrap justify-center gap-2 mb-6">
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">Transfer Bank</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">GoPay</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">ShopeePay</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">QRIS</span>
                                </div>

                                <form id="formMidtransUkt">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="button" id="btnBayarOnlineUkt" 
                                        class="px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center gap-2 mx-auto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        Bayar Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}
                                    </button>
                                </form>

                                <!-- Loading Indicator -->
                                <div class="mt-4 hidden" id="loadingPaymentUkt">
                                    <div class="inline-block animate-spin border-4 border-blue-600 border-t-transparent rounded-full w-10 h-10"></div>
                                    <p class="text-gray-600 mt-2 text-sm">Memproses pembayaran...</p>
                                </div>
                                
                                <!-- Error Message -->
                                <div class="mt-4 hidden p-4 bg-red-50 border border-red-200 rounded-lg" id="errorPaymentUkt">
                                    <p class="text-red-600 text-sm" id="errorMessageUkt"></p>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: OFFLINE PAYMENT -->
                        <div id="offlineTabUkt" class="tab-content-bayar-ukt hidden">
                            <div class="text-center py-10">
                                <div class="text-orange-600 text-6xl mb-4">🏢</div>
                                <h3 class="text-xl font-semibold mb-2">Pembayaran Tunai di Kampus</h3>
                                <p class="text-gray-500 mb-6">Lakukan pembayaran langsung di Kantor Kampus</p>
                                
                                <!-- Info Box -->
                                <div class="bg-orange-50 border-l-4 border-orange-400 rounded-lg p-4 mb-6 text-left">
                                    <p class="font-semibold text-orange-800 mb-2">📍 Informasi Pembayaran UKT:</p>
                                    <ul class="text-sm text-orange-700 space-y-1">
                                        <li>• Datang ke Kantor Kampus</li>
                                        <li>• Tunjukkan NIM atau Nomor Registrasi Anda</li>
                                        <li>• Lakukan pembayaran UKT di Kasir</li>
                                        <li>• Status akan diverifikasi oleh Admin</li>
                                    </ul>
                                </div>

                                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                                    <div class="text-sm text-gray-600 mb-2">Total Pembayaran UKT:</div>
                                    <div class="text-2xl font-bold text-blue-700">
                                        Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>

                                <button type="button" id="btnBayarOfflineUkt" 
                                        class="px-8 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition font-semibold flex items-center justify-center gap-2 mx-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pilih Pembayaran Tunai
                                </button>

                                <!-- Loading Offline -->
                                <div class="mt-4 hidden" id="loadingOfflineUkt">
                                    <div class="inline-block animate-spin border-4 border-orange-600 border-t-transparent rounded-full w-10 h-10"></div>
                                    <p class="text-gray-600 mt-2 text-sm">Memproses...</p>
                                </div>
                            </div>
                        </div>

                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Success Popup UKT -->
<div id="paymentSuccessPopupUkt" class="hidden fixed inset-0 z-[10000]">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative mx-auto mt-10 w-[95%] max-w-md bg-white rounded-2xl shadow-2xl p-6">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran UKT Berhasil!</h3>
            <p class="text-gray-600 mb-4">Pembayaran UKT Anda telah berhasil diverifikasi. Silakan lanjut ke daftar ulang.</p>
            <button onclick="closeSuccessPopupUktAndReload()" class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold">
                Tutup dan Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- Offline Success Popup UKT -->
<div id="offlineSuccessPopupUkt" class="hidden fixed inset-0 z-[10000]">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative mx-auto mt-10 w-[95%] max-w-md bg-white rounded-2xl shadow-2xl p-6">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Tunai Terdaftar!</h3>
            <p class="text-gray-600 mb-4">Silakan datang ke kampus untuk melakukan pembayaran UKT. Status akan diverifikasi setelah pembayaran diterima.</p>
            <button onclick="closeOfflinePopupUktAndReload()" class="w-full py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition font-semibold">
                Mengerti
            </button>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Modal bayar UKT loaded');
    
    // Tab switching untuk UKT
    document.querySelectorAll(".tab-btn-bayar-ukt").forEach(btn => {
        btn.addEventListener("click", () => {
            document.querySelectorAll(".tab-btn-bayar-ukt").forEach(b => {
                b.classList.remove("bg-blue-600", "text-white");
                b.classList.add("bg-gray-100", "text-gray-700");
            });

            btn.classList.add("bg-blue-600", "text-white");
            btn.classList.remove("bg-gray-100", "text-gray-700");

            document.querySelectorAll(".tab-content-bayar-ukt").forEach(tab => tab.classList.add("hidden"));
            const targetTab = document.querySelector(btn.dataset.target);
            if (targetTab) targetTab.classList.remove("hidden");
        });
    });

    // ONLINE PAYMENT HANDLER (UKT)
    const btnBayarUkt = document.getElementById('btnBayarOnlineUkt');
    if (btnBayarUkt) {
        btnBayarUkt.addEventListener('click', function(e) {
            e.preventDefault();
            
            const loadingDiv = document.getElementById('loadingPaymentUkt');
            const errorDiv = document.getElementById('errorPaymentUkt');
            const errorMsg = document.getElementById('errorMessageUkt');
            
            if (loadingDiv) loadingDiv.classList.remove('hidden');
            if (errorDiv) errorDiv.classList.add('hidden');
            btnBayarUkt.disabled = true;
            btnBayarUkt.classList.add('opacity-50', 'cursor-not-allowed');
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('❌ CSRF token not found');
                if (errorMsg) errorMsg.textContent = 'Error: CSRF token tidak ditemukan';
                if (errorDiv) errorDiv.classList.remove('hidden');
                if (loadingDiv) loadingDiv.classList.add('hidden');
                btnBayarUkt.disabled = false;
                btnBayarUkt.classList.remove('opacity-50', 'cursor-not-allowed');
                return;
            }
            
            fetch('{{ route("ukt.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (loadingDiv) loadingDiv.classList.add('hidden');
                btnBayarUkt.disabled = false;
                btnBayarUkt.classList.remove('opacity-50', 'cursor-not-allowed');
                
                if (data.success && data.snap_token) {
                    if (data.order_id) {
                        localStorage.setItem('pending_order_id_ukt', data.order_id);
                        localStorage.setItem('pending_payment_type', 'ukt');
                    }
                    
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=settlement&type=ukt';
                        },
                        onPending: function(result) {
                            window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=pending&type=ukt';
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal. Silakan coba lagi.');
                        },
                        onClose: function() {
                            window.location.reload();
                        }
                    });
                } else {
                    if (errorMsg) errorMsg.textContent = data.message || 'Gagal membuat transaksi. Silakan coba lagi.';
                    if (errorDiv) errorDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('❌ Fetch error:', error);
                if (loadingDiv) loadingDiv.classList.add('hidden');
                btnBayarUkt.disabled = false;
                btnBayarUkt.classList.remove('opacity-50', 'cursor-not-allowed');
                if (errorMsg) errorMsg.textContent = 'Terjadi kesalahan: ' + error.message;
                if (errorDiv) errorDiv.classList.remove('hidden');
            });
        });
    }

    // ⭐ OFFLINE PAYMENT HANDLER UKT - DENGAN PROTEKSI DOUBLE CLICK
    const btnBayarOfflineUkt = document.getElementById('btnBayarOfflineUkt');
    if (btnBayarOfflineUkt) {
        console.log('✅ Offline UKT button found');
        
        btnBayarOfflineUkt.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🟠 Offline UKT button clicked');
            
            const loadingDiv = document.getElementById('loadingOfflineUkt');
            
            if (!loadingDiv) {
                console.error('❌ Loading div not found');
                alert('Error: Element loading tidak ditemukan');
                return;
            }
            
            // ⭐ PROTEKSI: Disable button segera untuk cegah double click
            btnBayarOfflineUkt.disabled = true;
            btnBayarOfflineUkt.classList.add('opacity-50', 'cursor-not-allowed');
            loadingDiv.classList.remove('hidden');
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('❌ CSRF token not found');
                alert('Error: CSRF token tidak ditemukan');
                loadingDiv.classList.add('hidden');
                btnBayarOfflineUkt.disabled = false;
                btnBayarOfflineUkt.classList.remove('opacity-50', 'cursor-not-allowed');
                return;
            }
            
            console.log('📤 Sending request to:', '{{ route("ukt.store.offline") }}');
            
            fetch('{{ route("ukt.store.offline") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                console.log('📥 Response status:', response.status);
                return response.text();
            })
            .then(text => {
                console.log('📄 Response text:', text.substring(0, 200));
                
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('❌ Failed to parse JSON:', e);
                    throw new Error('Server response bukan JSON: ' + text.substring(0, 100));
                }
                
                loadingDiv.classList.add('hidden');
                
                // ⭐ STRICT CHECK: success === true
                if (data.success === true) {
                    console.log('✅ Payment offline UKT successful!');
                    showOfflineSuccessPopupUkt();
                    // ⭐ Button tetap disabled karena sudah berhasil
                } else {
                    console.error('❌ Payment failed:', data.message);
                    alert(data.message || 'Gagal membuat transaksi offline.');
                    // Enable button hanya jika gagal (untuk retry)
                    btnBayarOfflineUkt.disabled = false;
                    btnBayarOfflineUkt.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('❌ Fetch error:', error);
                loadingDiv.classList.add('hidden');
                btnBayarOfflineUkt.disabled = false;
                btnBayarOfflineUkt.classList.remove('opacity-50', 'cursor-not-allowed');
                alert('Terjadi kesalahan: ' + error.message);
            });
        });
    } else {
        console.warn('⚠️ Offline UKT button NOT found');
    }

    // Check for pending payment on page load (UKT)
    const pendingOrderIdUkt = localStorage.getItem('pending_order_id_ukt');
    const pendingType = localStorage.getItem('pending_payment_type');
    if (pendingOrderIdUkt && pendingType === 'ukt') {
        startPaymentPollingUkt(pendingOrderIdUkt);
    }
});

// Polling function for UKT
function startPaymentPollingUkt(orderId) {
    let attempts = 0;
    const maxAttempts = 30;
    
    const poll = setInterval(() => {
        attempts++;
        
        fetch(`/payment/check-ukt-status?order_id=${orderId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'settlement') {
                clearInterval(poll);
                localStorage.removeItem('pending_order_id_ukt');
                localStorage.removeItem('pending_payment_type');
                showSuccessPopupUkt();
            } else if (data.status === 'pending' && attempts >= maxAttempts) {
                clearInterval(poll);
                alert('Pembayaran masih diproses. Status akan diperbarui secara otomatis.');
            } else if (['cancel', 'expire', 'deny'].includes(data.status)) {
                clearInterval(poll);
                localStorage.removeItem('pending_order_id_ukt');
                localStorage.removeItem('pending_payment_type');
                alert(`Pembayaran ${data.status}. Silakan coba lagi.`);
            }
        })
        .catch(error => {
            console.error('Polling error:', error);
            if (attempts >= maxAttempts) {
                clearInterval(poll);
            }
        });
    }, 2000);
}

function showSuccessPopupUkt() {
    const popup = document.getElementById('paymentSuccessPopupUkt');
    if (popup) {
        popup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function showOfflineSuccessPopupUkt() {
    const popup = document.getElementById('offlineSuccessPopupUkt');
    if (popup) {
        popup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Auto close after 3 seconds
        setTimeout(() => {
            closeOfflinePopupUktAndReload();
        }, 3000);
    } else {
        console.error('❌ Popup not found, using fallback');
        alert('Pembayaran offline UKT berhasil didaftarkan!');
        closeModalBayarUkt();
        window.location.reload();
    }
}

function closeSuccessPopupUktAndReload() {
    const popup = document.getElementById('paymentSuccessPopupUkt');
    if (popup) popup.classList.add('hidden');
    closeModalBayarUkt();
    window.location.reload();
}

function closeOfflinePopupUktAndReload() {
    const popup = document.getElementById('offlineSuccessPopupUkt');
    if (popup) popup.classList.add('hidden');
    closeModalBayarUkt();
    window.location.reload();
}
</script>