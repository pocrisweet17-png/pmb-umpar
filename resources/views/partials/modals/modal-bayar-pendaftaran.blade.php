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
                            <p class="text-gray-500">Pilihan 1</p>
                            <p class="font-semibold">{{ $user->namaProdiPilihan1 ?? $user->pilihan_1 }}</p>
                        </div>
                    @endif

                    @if($user->pilihan_2)
                        <div class="bg-blue-50 p-3 rounded-lg border mt-2 text-sm">
                            <p class="text-gray-500">Pilihan 2</p>
                            <p class="font-semibold">{{ $user->namaProdiPilihan2 ?? $user->pilihan_2 }}</p>
                        </div>
                    @endif
                </div>

                <!-- Ringkasan biaya -->
                <div class="bg-white border rounded-xl shadow p-6">
                    <h3 class="font-semibold text-green-700 mb-4">Ringkasan Biaya</h3>

                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Biaya Pendaftaran</span>
                        <span class="font-semibold">Rp {{ number_format($biaya_pendaftaran ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-sm mb-4">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="font-bold text-green-600">GRATIS</span>
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
                                data-target="#midtransTab">
                                💳 Online (Midtrans)
                            </button>

                            <button class="tab-btn-bayar px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium transition hover:bg-gray-200"
                                data-target="#manualTab">
                                🏦 Transfer Manual
                            </button>
                        </div>

                        <!-- TAB: MIDTRANS -->
                        <div id="midtransTab" class="tab-content-bayar block">
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
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">Kartu Kredit</span>
                                </div>

                                <form id="formMidtrans">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="button" id="btnBayarOnline" 
                                        class="px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center gap-2 mx-auto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        Bayar Rp {{ number_format($biaya_pendaftaran,0,',','.') }}
                                    </button>
                                </form>

                                <!-- Loading Indicator -->
                                <div class="mt-4 hidden" id="loadingPayment">
                                    <div class="inline-block animate-spin border-4 border-blue-600 border-t-transparent rounded-full w-10 h-10"></div>
                                    <p class="text-gray-600 mt-2 text-sm">Memproses pembayaran...</p>
                                </div>
                                
                                <!-- Error Message -->
                                <div class="mt-4 hidden p-4 bg-red-50 border border-red-200 rounded-lg" id="errorPayment">
                                    <p class="text-red-600 text-sm" id="errorMessage"></p>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: MANUAL TRANSFER -->
                        <div id="manualTab" class="tab-content-bayar hidden">

                            <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg text-sm mb-6">
                                <p class="font-semibold text-yellow-800 mb-1">⚠️ Perhatian</p>
                                <p class="text-yellow-700">Transfer sesuai <strong>nominal yang tertera</strong>, lalu upload bukti transfer. Admin akan memverifikasi dalam 1x24 jam.</p>
                            </div>

                            <!-- Info Rekening -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <h4 class="font-semibold text-blue-800 mb-3">Rekening Tujuan Transfer</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Bank</span>
                                        <span class="font-semibold">BNI</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">No. Rekening</span>
                                        <span class="font-semibold">1234567890</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Atas Nama</span>
                                        <span class="font-semibold">UNIVERSITAS XYZ</span>
                                    </div>
                                    <div class="flex justify-between border-t border-blue-300 pt-2 mt-2">
                                        <span class="text-gray-600">Nominal Transfer</span>
                                        <span class="font-bold text-blue-700 text-lg">Rp {{ number_format($biaya_pendaftaran ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('bayar.upload') }}" method="POST" enctype="multipart/form-data" id="formUploadManual">
                                @csrf
                                <input type="hidden" name="jumlah" value="{{ $biaya_pendaftaran ?? 0 }}">

                                <div class="mb-4">
                                    <label class="block font-semibold text-gray-700 mb-2">
                                        Upload Bukti Transfer <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="bukti_bayar"
                                        class="block w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        accept="image/jpeg,image/png,image/jpg,application/pdf"
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau PDF. Max 2MB</p>
                                </div>

                                <button type="submit" id="btnUploadBukti"
                                    class="w-full py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    Upload Bukti Transfer
                                </button>
                            </form>

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
            <button onclick="closeSuccessPopupAndReload()" class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold">
                Tutup dan Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // MIDTRANS PAYMENT HANDLER
    const btnBayar = document.getElementById('btnBayarOnline');
    if (btnBayar) {
        btnBayar.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Bayar button clicked!');
            
            const loadingDiv = document.getElementById('loadingPayment');
            const errorDiv = document.getElementById('errorPayment');
            const errorMsg = document.getElementById('errorMessage');
            
            // Show loading, hide error
            loadingDiv.classList.remove('hidden');
            errorDiv.classList.add('hidden');
            btnBayar.disabled = true;
            
            // Ambil CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData();
            formData.append('_token', csrfToken);
            // Request snap token via AJAX
            fetch('{{ route("bayar.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (loadingDiv) loadingDiv.classList.add('hidden');
                btnBayar.disabled = false;
                
                console.log('Response from server:', data);
                
                if (data.success && data.snap_token) {
                    // Store order_id for polling
                    if (data.order_id) {
                        localStorage.setItem('pending_order_id', data.order_id);
                        localStorage.setItem('pending_payment_type', 'pendaftaran');
                    }
                    
                // Open Midtrans Snap
                snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    // Redirect ke finish dengan status settlement
                    window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=settlement';
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=pending';
                },
                onError: function(result) {
                    console.error('Payment error:', result);
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    // Optional: reload halaman untuk cek status terbaru
                    window.location.reload();
                }
                });
                } else {
                    // Show error
                    errorMsg.textContent = data.message || 'Gagal membuat transaksi. Silakan coba lagi.';
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                loadingDiv.classList.add('hidden');
                btnBayar.disabled = false;
                errorMsg.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                errorDiv.classList.remove('hidden');
            });
        });
    } else {
        console.warn('Payment button not found!');
    }

    // UPLOAD MANUAL HANDLER
    const formUpload = document.getElementById('formUploadManual');
    if (formUpload) {
        formUpload.addEventListener('submit', function() {
            const btn = document.getElementById('btnUploadBukti');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengupload...';
            }
        });
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
            console.log('Poll response:', data);
            
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
    }, 2000); // Poll every 2 seconds
}

function showSuccessPopup() {
    document.getElementById('paymentSuccessPopup').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSuccessPopupAndReload() {
    document.getElementById('paymentSuccessPopup').classList.add('hidden');
    closeModalBayarPendaftaran();
    window.location.reload();
}

function openModalBayarPendaftaran() {
    document.getElementById('modalBayarPendaftaran').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModalBayarPendaftaran() {
    document.getElementById('modalBayarPendaftaran').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
</script>
