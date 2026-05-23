<div id="modalBayarPendaftaran" class="fixed inset-0 hidden z-[9999]">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
         onclick="closeModalBayarPendaftaran()"></div>

    <!-- Modal Card -->
    <div class="relative mx-auto mt-10 w-[95%] max-w-6xl bg-white rounded-2xl shadow-2xl overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="flex items-center gap-4 p-6 border-b bg-blue-600 text-white rounded-t-2xl">
            <button onclick="closeModalBayarPendaftaran()"
                class="p-2 bg-white/20 rounded-full hover:bg-white/30 transition">
                ✕
            </button>
            <div>
                <h2 class="text-2xl font-semibold">Pembayaran Pendaftaran</h2>
                <p class="text-blue-100 text-sm">Step 2 dari 8 — Selesaikan pembayaran untuk melanjutkan</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">

            <!-- INFORMASI PENDAFTAR -->
            <div class="space-y-6">
                <!-- Info -->
                <div class="bg-white border rounded-xl shadow p-6">
                    <h3 class="font-semibold text-blue-700 mb-4">Informasi Pendaftar</h3>

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
                    </table>

                    <hr class="my-4">

                    <h4 class="font-semibold mb-2 text-blue-700">Pilihan Prodi</h4>

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
                        <span class="text-gray-600">Biaya Pendaftaran</span>
                        <span class="font-semibold">Rp 50.000</span>
                    </div>

                    <div class="flex justify-between text-sm mb-4">
                        <h6 class="text-gray-600">Biaya Admin</p>
                        <span class="font-bold text-green-600">disesuaikan dengan metode yang dipilih</span>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between">
                        <span class="font-semibold text-lg">Total</span>
                        <span class="text-blue-700 font-bold text-2xl" id="totalBiaya">
                            Rp {{ number_format($biaya_pendaftaran ?? 0, 0, ',', '.') }}
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

                        @if($user->is_bayar_pendaftaran)
                            <!-- SUDAH BAYAR -->
                            <div class="p-6 bg-green-100 border border-green-300 rounded-xl text-center">
                                <div class="text-green-600 text-5xl mb-3">✓</div>
                                <p class="font-semibold text-green-700 text-lg mb-2">
                                    Pembayaran Sudah Diverifikasi
                                </p>
                                <p class="text-green-600 text-sm mb-4">
                                    Anda dapat melanjutkan ke tahap berikutnya
                                </p>
                                <button onclick="closeModalBayarPendaftaran()"
                                    class="mt-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Tutup
                                </button>
                            </div>
                        @else
                        
                        <!-- Tabs -->
                        <div class="flex gap-3 mb-6">
                            <button class="tab-btn-bayar active px-4 py-2 bg-blue-600 text-white rounded-lg font-medium transition"
                                data-target="#onlineTab">
                                💳 Pembayaran Online
                            </button>

                            <button class="tab-btn-bayar px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium transition hover:bg-gray-200"
                                data-target="#offlineTab">
                                🏢 Pembayaran Tunai
                            </button>
                        </div>

                        <!-- TAB: ONLINE PAYMENT -->
                        <div id="onlineTab" class="tab-content-bayar block">
                            <div class="py-6">
                                <h3 class="text-xl font-semibold mb-2 text-center">Pilih Metode Pembayaran</h3>
                                <p class="text-gray-500 mb-6 text-center">Klik metode yang ingin Anda gunakan</p>

                                <!-- Grid Metode Pembayaran -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                                    <!-- QRIS -->
                                    <button type="button" class="btn-metode-bayar p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition flex flex-col items-center gap-2 group"
                                            data-metode="qris">
                                        <div class="w-12 h-12 flex items-center justify-center">
                                            <img
                                                src="{{ asset('img/qris.jpeg') }}"
                                                alt="QRIS"
                                                class="max-w-full max-h-full object-contain"
                                            >
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-purple-700">QRIS</span>
                                        <span class="text-xs text-gray-400">Semua E-Wallet</span>
                                    </button>

                                    <!-- GoPay -->
                                    {{-- <button type="button" class="btn-metode-bayar p-4 border-2 border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition flex flex-col items-center gap-2 group"
                                            data-metode="gopay">
                                        <div class="w-12 h-12 flex items-center justify-center">
                                            <img
                                                src="{{ asset('img/gopay.jpeg') }}"
                                                alt="GOPAY"
                                                class="max-w-full max-h-full object-contain"
                                            >
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-green-700">GoPay</span>
                                        <span class="text-xs text-gray-400">Gojek</span>
                                    </button> --}}

                                    <!-- ShopeePay -->
                                    {{-- <button type="button" class="btn-metode-bayar p-4 border-2 border-gray-200 rounded-xl hover:border-orange-500 hover:bg-orange-50 transition flex flex-col items-center gap-2 group"
                                            data-metode="shopeepay">
                                        <div class="w-12 h-12 flex items-center justify-center">
                                            <img
                                                src="{{ asset('img/shopeepay.jpeg') }}"
                                                alt="SHOPEEPAY"
                                                class="max-w-full max-h-full object-contain"
                                            >
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-orange-700">ShopeePay</span>
                                        <span class="text-xs text-gray-400">Shopee</span>
                                    </button> --}}

                                    <!-- Dana -->
                                    {{-- <button type="button" class="btn-metode-bayar p-4 border-2 border-gray-200 rounded-xl hover:border-orange-500 hover:bg-orange-50 transition flex flex-col items-center gap-2 group"
                                            data-metode="dana">
                                        <div class="w-12 h-12 flex items-center justify-center">
                                            <img
                                                src="{{ asset('img/dana.jpeg') }}"
                                                alt="DANA"
                                                class="max-w-full max-h-full object-contain"
                                            >
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-orange-700">Dana</span>
                                        <span class="text-xs text-gray-400">Dana</span>
                                    </button> --}}

                                     <!-- Alfamart -->
                                    {{-- <button type="button" class="btn-metode-bayar p-4 border-2 border-gray-200 rounded-xl hover:border-orange-500 hover:bg-orange-50 transition flex flex-col items-center gap-2 group"
                                            data-metode="alfamart">
                                        <div class="w-12 h-12 flex items-center justify-center">
                                            <img
                                                src="{{ asset('img/alfamart.jpeg') }}"
                                                alt="ALFAMART"
                                                class="max-w-full max-h-full object-contain"
                                            >
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-orange-700">Alfamart</span>
                                        <span class="text-xs text-gray-400">Alfamart</span>
                                    </button> --}}

                                    <!-- Bank Transfer -->
                                    <button type="button" class="btn-metode-bayar p-4 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition flex flex-col items-center gap-2 group"
                                            data-metode="bank_transfer">
                                        <div class="w-12 h-12 flex items-center justify-center">
                                            <img
                                                src="{{ asset('img/bank.jpg') }}"
                                                alt="TRANSFER-BANK"
                                                class="max-w-full max-h-full object-contain"
                                            >
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-700">Bank Transfer</span>
                                        <span class="text-xs text-gray-400">BCA, BNI, Mandiri</span>
                                    </button>

                                </div>

                                <!-- Info Biaya -->
                                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600">Biaya Pendaftaran:</span>
                                        <span class="font-semibold">Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mb-2" id="biayaAdminRow" style="display: none;">
                                        <span class="text-gray-600">Biaya Admin:</span>
                                        <span class="font-semibold text-orange-600" id="biayaAdminText">Rp 0</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold text-gray-800">Total Pembayaran:</span>
                                        <span class="text-xl font-bold text-blue-700" id="totalBayarText">Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            
                                <!-- Loading Indicator -->
                                <div class="mt-4 hidden text-center" id="loadingPayment">
                                    <div class="inline-block animate-spin border-4 border-blue-600 border-t-transparent rounded-full w-10 h-10"></div>
                                    <p class="text-gray-600 mt-2 text-sm">Memproses pembayaran...</p>
                                </div>

                                <!-- Error Message -->
                                <div class="mt-4 hidden p-4 bg-red-50 border border-red-200 rounded-lg" id="errorPayment">
                                    <p class="text-red-600 text-sm" id="errorMessage"></p>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: OFFLINE PAYMENT -->
                        <div id="offlineTab" class="tab-content-bayar hidden">
                            <div class="text-center py-10">
                                <div class="text-orange-600 text-6xl mb-4">🏢</div>
                                <h3 class="text-xl font-semibold mb-2">Pembayaran Tunai di Kampus</h3>
                                <p class="text-gray-500 mb-6">Lakukan pembayaran langsung di Kantor Kampus</p>
                                
                                <!-- Info Box -->
                                <div class="bg-orange-50 border-l-4 border-orange-400 rounded-lg p-4 mb-6 text-left">
                                    <p class="font-semibold text-orange-800 mb-2">📍 Informasi Pembayaran:</p>
                                    <ul class="text-sm text-orange-700 space-y-1">
                                        <li>• Datang ke Kantor Kampus</li>
                                        <li>• Tunjukkan Nomor Registrasi Anda</li>
                                        <li>• Lakukan pembayaran di Kasir</li>
                                        <li>• Status akan diverifikasi oleh Admin</li>
                                    </ul>
                                </div>

                                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                                    <div class="text-sm text-gray-600 mb-2">Total Pembayaran:</div>
                                    <div class="text-2xl font-bold text-blue-700">
                                        Rp {{ number_format($biaya_pendaftaran, 0, ',', '.') }}
                                    </div>
                                </div>

                                <button type="button" id="btnBayarOffline" 
                                        class="px-8 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition font-semibold flex items-center justify-center gap-2 mx-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pilih Pembayaran Tunai
                                </button>

                                <!-- Loading Offline -->
                                <div class="mt-4 hidden" id="loadingOffline">
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

<!-- Success Popup -->
<div id="paymentSuccessPopup" class="hidden fixed inset-0 z-[10000]">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative mx-auto mt-10 w-[95%] max-w-md bg-white rounded-2xl shadow-2xl p-6">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
            <p class="text-gray-600 mb-4">Pembayaran pendaftaran Anda telah berhasil diverifikasi.</p>
            <button onclick="closeSuccessPopup()" class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold">
                Tutup dan Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- Offline Success Popup -->
<div id="offlineSuccessPopup" class="hidden fixed inset-0 z-[10000]">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative mx-auto mt-10 w-[95%] max-w-md bg-white rounded-2xl shadow-2xl p-6">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Tunai Terdaftar!</h3>
            <p class="text-gray-600 mb-4">Silakan datang ke kampus untuk melakukan pembayaran. Status akan diverifikasi setelah pembayaran diterima.</p>
            <button onclick="closeSuccessPopup()" class="w-full py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition font-semibold">
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
    console.log('✅ Modal script loaded');
    
    let isProcessingPayment = false;
    
    const biayaPokok = {{ $biaya_pendaftaran }};
    
    const biayaAdminMapping = {
        'qris': Math.round(biayaPokok * 0.007 * 1.12), // 0.7%
        // 'gopay': Math.round(biayaPokok * 0.02),  // 2%
        // 'shopeepay': Math.round(biayaPokok * 0.02),  // 2%
        // 'dana': Math.round(biayaPokok * 0.015),  // 1.5% 
        'bank_transfer': 4500,
        // 'alfamart': 5000,
        'all': 0
    };

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function updateBiayaTampilan(metode) {
        const biayaAdmin = biayaAdminMapping[metode] || 0;
        const total = biayaPokok + biayaAdmin;
        
        const biayaAdminRow = document.getElementById('biayaAdminRow');
        const biayaAdminText = document.getElementById('biayaAdminText');
        const totalBayarText = document.getElementById('totalBayarText');
        
        if (biayaAdmin > 0) {
            biayaAdminRow.style.display = 'flex';
            biayaAdminText.textContent = formatRupiah(biayaAdmin);
        } else {
            biayaAdminRow.style.display = 'none';
        }
        
        totalBayarText.textContent = formatRupiah(total);
    }
    
    // Tab switching
    document.querySelectorAll(".tab-btn-bayar").forEach(btn => {
        btn.addEventListener("click", () => {
            document.querySelectorAll(".tab-btn-bayar").forEach(b => {
                b.classList.remove("bg-blue-600", "text-white");
                b.classList.add("bg-gray-100", "text-gray-700");
            });

            btn.classList.add("bg-blue-600", "text-white");
            btn.classList.remove("bg-gray-100", "text-gray-700");

            document.querySelectorAll(".tab-content-bayar").forEach(tab => tab.classList.add("hidden"));
            document.querySelector(btn.dataset.target).classList.remove("hidden");
        });
    });

document.querySelectorAll('.btn-metode-bayar').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        if (isProcessingPayment) {
            console.warn('sedang di proses, bentar yaa');
            return;
        }
        isProcessingPayment = true;

        const metode = this.dataset.metode;
        console.log(' Metode dipilih:', metode);

        updateBiayaTampilan(metode);

            document.querySelectorAll('.btn-metode-bayar').forEach(b => {
                b.classList.remove('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-300');
                b.classList.remove('border-green-500', 'bg-green-50');
                b.classList.remove('border-orange-500', 'bg-orange-50');
                b.classList.remove('border-purple-500', 'bg-purple-50');
            });
            this.classList.add('ring-2', 'ring-blue-300');

            prosesPayment(metode);
        });
    });

    function prosesPayment(metode) {
        const loadingDiv = document.getElementById('loadingPayment');
        const errorDiv = document.getElementById('errorPayment');
        const errorMsg = document.getElementById('errorMessage');

        loadingDiv.classList.remove('hidden');
        errorDiv.classList.add('hidden');

        // Disable semua tombol
        document.querySelectorAll('.btn-metode-bayar').forEach(b => {
            b.disabled = true;
            b.classList.add('opacity-50', 'cursor-not-allowed');
        });

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route("bayar.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                metode_pembayaran: metode
            })
        })
        .then(response => response.json())
        .then(data => {
            loadingDiv.classList.add('hidden');

            // Enable semua tombol
            document.querySelectorAll('.btn-metode-bayar').forEach(b => {
                b.disabled = false;
                b.classList.remove('opacity-50', 'cursor-not-allowed');
            });

            if (data.success && data.snap_token) {
                if (data.order_id) {
                    localStorage.setItem('pending_order_id', data.order_id);
                    localStorage.setItem('pending_payment_type', 'pendaftaran');
                }

                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=settlement';
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=pending';
                    },
                    onError: function(result) {
                        isProcessingPayment = false;
                        alert('Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        // ✅ JANGAN reload — biarkan user pilih metode lain / klik lagi
                        // Order_id & snap_token sudah di-cache di DB, akan di-reuse
                        isProcessingPayment = false;
                        console.log('⚠️ User closed popup, snap token tetap valid 15 menit');
                    }
                });
                } else {
                    isProcessingPayment = false; 
                    errorMsg.textContent = data.message || 'Gagal membuat transaksi.';
                    errorDiv.classList.remove('hidden');
                }
        })
      .catch(error => {
            console.error('Fetch error:', error);
            loadingDiv.classList.add('hidden');
            
            isProcessingPayment = false;

            document.querySelectorAll('.btn-metode-bayar').forEach(b => {
                b.disabled = false;
                b.classList.remove('opacity-50', 'cursor-not-allowed');
            });

            errorMsg.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            errorDiv.classList.remove('hidden');
        });
    }

    // OFFLINE PAYMENT HANDLER
    const btnBayarOffline = document.getElementById('btnBayarOffline');
    if (btnBayarOffline) {
        console.log('✅ Offline button found');
        
        btnBayarOffline.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🟠 Offline button clicked');
            
            const loadingDiv = document.getElementById('loadingOffline');
            
            if (!loadingDiv) {
                console.error('❌ Loading div not found');
                alert('Error: Element loading tidak ditemukan');
                return;
            }
            
            btnBayarOffline.disabled = true;
            btnBayarOffline.classList.add('opacity-50', 'cursor-not-allowed');
            loadingDiv.classList.remove('hidden');
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('❌ CSRF token not found');
                alert('Error: CSRF token tidak ditemukan');
                loadingDiv.classList.add('hidden');
                btnBayarOffline.disabled = false;
                btnBayarOffline.classList.remove('opacity-50', 'cursor-not-allowed');
                return;
            }
            
            console.log('📤 Sending request to:', '{{ route("bayar.store.offline") }}');
            
            fetch('{{ route("bayar.store.offline") }}', {
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
                console.log(' Response text:', text);
                
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('❌ Failed to parse JSON:', e);
                    throw new Error('Server response bukan JSON: ' + text.substring(0, 100));
                }
                
                loadingDiv.classList.add('hidden');
                
                if (data.success === true) {
                    console.log('✅ Payment offline successful!');
                    showOfflineSuccessPopup();
                } else {
                    console.error('❌ Payment failed:', data.message);
                    alert(data.message || 'Gagal membuat transaksi offline.');
                    btnBayarOffline.disabled = false;
                    btnBayarOffline.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('❌ Fetch error:', error);
                loadingDiv.classList.add('hidden');
                btnBayarOffline.disabled = false;
                btnBayarOffline.classList.remove('opacity-50', 'cursor-not-allowed');
                alert('Terjadi kesalahan: ' + error.message);
            });
        });
    } else {
        console.warn('⚠️ Offline button NOT found');
    }

    // Check for pending payment on page load
    const pendingOrderId = localStorage.getItem('pending_order_id');
    const pendingType = localStorage.getItem('pending_payment_type');
    if (pendingOrderId && pendingType === 'pendaftaran') {
        startPaymentPolling(pendingOrderId);
    }
});

// Polling function
function startPaymentPolling(orderId) {
    let attempts = 0;
    const maxAttempts = 30;
    
    const poll = setInterval(() => {
        attempts++;
        
        fetch(`/payment/poll-status?order_id=${orderId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'settlement') {
                clearInterval(poll);
                localStorage.removeItem('pending_order_id');
                localStorage.removeItem('pending_payment_type');
                showSuccessPopup();
            } else if (data.status === 'pending' && attempts >= maxAttempts) {
                clearInterval(poll);
                alert('Pembayaran masih diproses. Status akan diperbarui secara otomatis.');
            } else if (['cancel', 'expire', 'deny'].includes(data.status)) {
                clearInterval(poll);
                localStorage.removeItem('pending_order_id');
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

function closeSuccessPopup() {
    document.getElementById('paymentSuccessPopup')?.classList.add('hidden');
    document.getElementById('offlineSuccessPopup')?.classList.add('hidden');
    document.body.style.overflow = 'auto';
    closeModalBayarPendaftaran();
}

function showSuccessPopup() {
    const popup = document.getElementById('paymentSuccessPopup');
    if (popup) {
        popup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function showOfflineSuccessPopup() {
    const popup = document.getElementById('offlineSuccessPopup');
    if (popup) {
        popup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // setTimeout(() => {
        //     closeOfflinePopupAndReload();
        // }, 3000);
    } else {
        console.error(' Popup not found, using fallback');
        alert('Pembayaran offline berhasil didaftarkan!');
        closeModalBayarPendaftaran();
    }
}

function closeSuccessPopupAndReload() {
    const popup = document.getElementById('paymentSuccessPopup');
    if (popup) popup.classList.add('hidden');
    closeModalBayarPendaftaran();
    window.location.reload();
}

function closeOfflinePopupAndReload() {
    const popup = document.getElementById('offlineSuccessPopup');
    if (popup) popup.classList.add('hidden');
    closeModalBayarPendaftaran();
    window.location.reload();
}

function openModalBayarPendaftaran() {
    const modal = document.getElementById('modalBayarPendaftaran');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModalBayarPendaftaran() {
    const modal = document.getElementById('modalBayarPendaftaran');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}
</script>