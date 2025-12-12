<div id="modalBayarUkt" class="fixed inset-0 hidden z-[9999]">
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
                <h2 class="text-2xl font-semibold">Pembayaran Biaya Semester</h2>
                <p class="text-blue-100 text-sm">Step 7 dari 8 — Selesaikan pembayaran untuk melanjutkan</p>
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
                            <td class="font-medium">{{ $user->name }}</td>
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

                    @if($user->namaProdi_1)
                        <div class="bg-blue-50 p-3 rounded-lg border text-sm">
                            <p class="text-gray-500">Pilihan 1</p>
                            <p class="font-semibold">{{ $user->pilihan_1 }}</p>
                        </div>
                    @endif

                    @if($user->namaProdi_2)
                        <div class="bg-blue-50 p-3 rounded-lg border mt-2 text-sm">
                            <p class="text-gray-500">Pilihan 2</p>
                            <p class="font-semibold">{{ $user->pilihan_2 }}</p>
                        </div>
                    @endif
                </div>

                <!-- Ringkasan biaya -->
                <div class="bg-white border rounded-xl shadow p-6">
                    <h3 class="font-semibold text-green-700 mb-4">Ringkasan Biaya</h3>

                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Biaya Semester</span>
                        <span class="font-semibold">Rp {{ number_format($biaya_ukt,0,',','.') }}</span>
                    </div>

                    <div class="flex justify-between text-sm mb-4">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="font-bold text-green-600">GRATIS</span>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between">
                        <span class="font-semibold text-lg">Total</span>
                        <span class="text-blue-700 font-bold text-2xl">
                            Rp {{ number_format($biaya_ukt,0,',','.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- PEMBAYARAN -->
            <div class="lg:col-span-2">
                <div class="bg-white border rounded-xl shadow">

                    <div class="border-b p-6">
                        <h3 class="font-semibold text-blue-700">Pilih Metode Pembayaran UKT</h3>
                    </div>

                    <div class="p-6">

                        @if($user->is_ukt_paid)
                            <!-- SUDAH BAYAR UKT -->
                            <div class="p-6 bg-green-100 border border-green-300 rounded-xl text-center">
                                <div class="text-green-600 text-5xl mb-3">✓</div>
                                <p class="font-semibold text-green-700 text-lg mb-2">
                                    Pembayaran UKT Sudah Diverifikasi
                                </p>
                                <p class="text-green-600 text-sm mb-4">
                                    Pembayaran UKT Semester 1 Anda sudah terverifikasi.
                                </p>
                                <button onclick="closeModalBayarUkt()"
                                    class="mt-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Tutup Modal
                                </button>
                            </div>
                        @else
                        
                        <!-- Tabs -->
                        <div class="flex gap-3 mb-6">
                            <button id="tabMidtransUkt" class="tab-btn-ukt active px-4 py-2 bg-blue-600 text-white rounded-lg font-medium transition"
                                data-target="midtransTabUkt">
                                💳 Online (Midtrans)
                            </button>

                            <button id="tabManualUkt" class="tab-btn-ukt px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium transition hover:bg-gray-200"
                                data-target="manualTabUkt">
                                🏦 Transfer Manual
                            </button>
                        </div>

                        <!-- TAB: MIDTRANS UNTUK UKT -->
                        <div id="midtransTabUkt" class="tab-content-ukt block">
                            <div class="text-center py-10">
                                <div class="text-blue-600 text-6xl mb-4">💳</div>
                                <h3 class="text-xl font-semibold mb-2">Pembayaran UKT Online Otomatis</h3>
                                <p class="text-gray-500 mb-2">Bayar UKT dengan mudah menggunakan:</p>
                                
                                <!-- Metode Pembayaran -->
                                <div class="flex flex-wrap justify-center gap-2 mb-6">
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">Transfer Bank</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">GoPay</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">ShopeePay</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">QRIS</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full">Kartu Kredit</span>
                                </div>

                                <div id="paymentButtonContainer">
                                    <button type="button" id="btnBayarUktOnline"
                                        class="px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center gap-2 mx-auto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        Bayar UKT Rp {{ number_format($biaya_ukt,0,',','.') }}
                                    </button>
                                </div>

                                <!-- Loading Indicator UKT -->
                                <div class="mt-4 hidden" id="loadingPaymentUkt">
                                    <div class="inline-block animate-spin border-4 border-blue-600 border-t-transparent rounded-full w-10 h-10"></div>
                                    <p class="text-gray-600 mt-2 text-sm">Memproses pembayaran UKT...</p>
                                </div>
                                
                                <!-- Status Info -->
                                <div class="mt-6 hidden" id="paymentStatusUkt">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <p id="statusTextUkt" class="text-blue-700 text-sm"></p>
                                        <p id="orderIdTextUkt" class="font-mono text-xs mt-1 text-gray-600"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: MANUAL TRANSFER UNTUK UKT -->
                        <div id="manualTabUkt" class="tab-content-ukt hidden">

                            <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg text-sm mb-6">
                                <p class="font-semibold text-yellow-800 mb-1">⚠️ Perhatian</p>
                                <p class="text-yellow-700">Transfer sesuai <strong>nominal UKT yang tertera</strong>, lalu upload bukti transfer. Admin akan memverifikasi dalam 1x24 jam.</p>
                            </div>

                            <!-- Info Rekening untuk UKT -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <h4 class="font-semibold text-blue-800 mb-3">Rekening Tujuan Transfer UKT</h4>
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
                                        <span class="text-gray-600">Nominal Transfer UKT</span>
                                        <span class="font-bold text-blue-700 text-lg">Rp {{ number_format($biaya_ukt,0,',','.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('ukt.upload') }}" method="POST" enctype="multipart/form-data" id="formUploadManualUkt">
                                @csrf
                                <input type="hidden" name="jumlah" value="{{ $biaya_ukt }}">

                                <div class="mb-4">
                                    <label class="block font-semibold text-gray-700 mb-2">
                                        Upload Bukti Transfer UKT <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="bukti_bayar"
                                        class="block w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        accept="image/jpeg,image/png,image/jpg,application/pdf"
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau PDF. Max 2MB</p>
                                </div>

                                <button type="submit" id="btnUploadBuktiUkt"
                                    class="w-full py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    Upload Bukti Transfer UKT
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

<!-- Midtrans Snap Script -->
<script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<!-- Popup Success untuk UKT -->
<div id="uktSuccessPopup" class="hidden fixed inset-0 z-[10000]">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative mx-auto mt-10 w-[95%] max-w-md bg-white rounded-2xl shadow-2xl p-6">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran UKT Berhasil!</h3>
            <p class="text-gray-600 mb-4">Pembayaran UKT Semester 1 Anda telah berhasil diverifikasi.</p>
            <div class="bg-gray-50 rounded-lg p-4 mb-4 text-left">
                <p class="text-sm text-gray-500">Status saat ini:</p>
                <p class="font-semibold text-green-600">✓ Sudah Membayar UKT</p>
                <p class="text-sm text-gray-500 mt-2">Anda dapat melanjutkan ke tahap berikutnya.</p>
            </div>
            <button onclick="closeUktSuccessPopup()" class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold">
                Tutup dan Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- ==================== SCRIPT UKT YANG SIMPLE & PASTI WORK ==================== -->
<script>
// ========== 1. VARIABLES & ELEMENTS ==========
let uktPaymentPolling = null;

// ========== 2. FUNGSI MODAL ==========
function openModalBayarUkt() {
    console.log('🚀 openModalBayarUkt() called');
    document.getElementById('modalBayarUkt').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Initialize UKT tab system
    initUktTabs();
    
    // Check pending payment
    checkPendingUktPayment();
}

function closeModalBayarUkt() {
    console.log('🔒 closeModalBayarUkt() called');
    document.getElementById('modalBayarUkt').classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Stop polling jika ada
    if (uktPaymentPolling) {
        clearInterval(uktPaymentPolling);
        uktPaymentPolling = null;
    }
}

function showUktSuccessPopup() {
    console.log('🎉 showUktSuccessPopup() called');
    document.getElementById('uktSuccessPopup').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeUktSuccessPopup() {
    console.log('📪 closeUktSuccessPopup() called');
    document.getElementById('uktSuccessPopup').classList.add('hidden');
    closeModalBayarUkt();
    
    // Refresh halaman
    setTimeout(() => {
        window.location.reload();
    }, 800);
}

// ========== 3. INITIALIZE TABS ==========
function initUktTabs() {
    console.log('🔧 Initializing UKT tabs...');
    
    const tabButtons = document.querySelectorAll('.tab-btn-ukt');
    const tabContents = document.querySelectorAll('.tab-content-ukt');
    
    tabButtons.forEach(button => {
        // Remove existing listeners
        button.replaceWith(button.cloneNode(true));
    });
    
    // Re-select after clone
    document.querySelectorAll('.tab-btn-ukt').forEach(button => {
        button.addEventListener('click', function() {
            console.log('Tab clicked:', this.dataset.target);
            
            // Update active button
            tabButtons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            
            this.classList.remove('bg-gray-100', 'text-gray-700');
            this.classList.add('bg-blue-600', 'text-white');
            
            // Show target tab
            const targetId = this.dataset.target;
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(targetId).classList.remove('hidden');
        });
    });
    
    console.log('UKT tabs initialized');
}

// ========== 4. SETUP PAYMENT BUTTON ==========
function setupUktPaymentButton() {
    console.log('🔄 Setting up UKT payment button...');
    
    const btnBayarUkt = document.getElementById('btnBayarUktOnline');
    if (!btnBayarUkt) {
        console.error('❌ btnBayarUktOnline not found!');
        return;
    }
    
    console.log('✅ UKT payment button found, adding event listener...');
    
    // Remove existing listeners
    btnBayarUkt.replaceWith(btnBayarUkt.cloneNode(true));
    
    // Re-select after clone
    const newBtn = document.getElementById('btnBayarUktOnline');
    
    newBtn.addEventListener('click', async function(e) {
        e.preventDefault();
        console.log('🤑 UKT Payment button clicked!');
        
        await processUktPayment();
    });
    
    console.log('✅ UKT payment button setup complete');
}

// ========== 5. PROCESS PAYMENT ==========
async function processUktPayment() {
    console.log('💰 Starting UKT payment process...');
    
    const btn = document.getElementById('btnBayarUktOnline');
    const loading = document.getElementById('loadingPaymentUkt');
    const statusDiv = document.getElementById('paymentStatusUkt');
    const statusText = document.getElementById('statusTextUkt');
    const orderIdText = document.getElementById('orderIdTextUkt');
    
    // Show loading
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    
    if (loading) loading.classList.remove('hidden');
    if (statusDiv) statusDiv.classList.add('hidden');
    
    try {
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log('CSRF Token:', csrfToken ? 'Found' : 'Not found');
        
        // Make request
        console.log('📤 Sending request to ukt.store...');
        const response = await fetch('{{ route("ukt.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            credentials: 'include'
        });
        // Cek jika redirect (session habis)
if (response.redirected) {
    const redirectUrl = response.url;
    console.error('⚠️ Redirected to:', redirectUrl);
    
    // Jika redirect ke login page
    if (redirectUrl.includes('/login')) {
        alert('Session habis! Silakan login ulang.');
        window.location.href = '/login';
        return;
    }
}
        
        console.log('📥 Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('📊 Response data:', data);
        
        // Reset button
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar UKT Rp {{ number_format($biaya_ukt,0,",",".") }}';
        if (loading) loading.classList.add('hidden');
        
        if (data.success && data.snap_token) {
            console.log('✅ Snap token received!');
            
            // Save order ID
            if (data.order_id) {
                localStorage.setItem('pending_ukt_order_id', data.order_id);
                console.log('💾 Saved order ID:', data.order_id);
            }
            
            // Show status
            if (statusDiv) {
                statusText.textContent = 'Membuka gateway pembayaran...';
                orderIdText.textContent = `Order ID: ${data.order_id}`;
                statusDiv.classList.remove('hidden');
            }
            
            // Open Midtrans payment
            console.log('🚪 Opening Midtrans payment popup...');
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('🎊 Payment success:', result);
                    if (statusDiv) {
                        statusText.textContent = 'Pembayaran berhasil! Memverifikasi...';
                        statusText.className = 'text-green-600 font-semibold';
                        statusDiv.classList.remove('hidden');
                    }
                    startUktPaymentPolling(data.order_id);
                },
                onPending: function(result) {
                    console.log('⏳ Payment pending:', result);
                    if (statusDiv) {
                        statusText.textContent = 'Pembayaran pending. Selesaikan pembayaran Anda.';
                        statusText.className = 'text-yellow-600 font-semibold';
                        statusDiv.classList.remove('hidden');
                    }
                    startUktPaymentPolling(data.order_id);
                },
                onError: function(result) {
                    console.error('❌ Payment error:', result);
                    if (statusDiv) {
                        statusText.textContent = 'Pembayaran gagal. Coba lagi.';
                        statusText.className = 'text-red-600 font-semibold';
                        statusDiv.classList.remove('hidden');
                    }
                    localStorage.removeItem('pending_ukt_order_id');
                },
                onClose: function() {
                    console.log('🔒 Payment popup closed');
                    if (statusDiv) {
                        statusText.textContent = 'Popup ditutup. Jika sudah bayar, status akan update otomatis.';
                        statusText.className = 'text-blue-600';
                        statusDiv.classList.remove('hidden');
                    }
                    if (data.order_id) {
                        startUktPaymentPolling(data.order_id);
                    }
                }
            });
            
        } else {
            console.error('❌ Failed to get snap token:', data);
            let errorMsg = data.message || 'Gagal membuat transaksi UKT';
            
            if (statusDiv) {
                statusText.textContent = errorMsg;
                statusText.className = 'text-red-600 font-semibold';
                statusDiv.classList.remove('hidden');
            }
            
            alert('Error: ' + errorMsg);
        }
        
    } catch (error) {
        console.error('🔥 UKT Payment error:', error);
        
        // Reset button
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar UKT Rp {{ number_format($biaya_ukt,0,",",".") }}';
        if (loading) loading.classList.add('hidden');
        
        if (statusDiv) {
            statusText.textContent = 'Error: ' + error.message;
            statusText.className = 'text-red-600 font-semibold';
            statusDiv.classList.remove('hidden');
        }
        
        alert('Terjadi kesalahan:\n' + error.message);
    }
}

// ========== 6. POLLING FUNCTIONS ==========
async function checkUktPaymentStatus(orderId) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const response = await fetch(`/payment/check-status?order_id=${orderId}&type=ukt`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) return { status: 'error' };
        
        const data = await response.json();
        console.log('Polling status:', data.status);
        
        if (data.status === 'settlement') {
            return { status: 'settlement', success: true };
        }
        
        return { status: data.status, success: false };
        
    } catch (error) {
        console.error('Polling error:', error);
        return { status: 'error', success: false };
    }
}

function startUktPaymentPolling(orderId) {
    console.log('🔁 Starting polling for order:', orderId);
    
    // Clear existing polling
    if (uktPaymentPolling) {
        clearInterval(uktPaymentPolling);
    }
    
    let attempts = 0;
    const maxAttempts = 60; // 60 detik
    
    uktPaymentPolling = setInterval(async () => {
        attempts++;
        
        if (attempts > maxAttempts) {
            clearInterval(uktPaymentPolling);
            console.log('⏰ Polling timeout after', maxAttempts, 'attempts');
            return;
        }
        
        const result = await checkUktPaymentStatus(orderId);
        
        if (result.success) {
            clearInterval(uktPaymentPolling);
            localStorage.removeItem('pending_ukt_order_id');
            showUktSuccessPopup();
        }
        
    }, 1000); // Poll setiap 1 detik
}

function checkPendingUktPayment() {
    const pendingOrderId = localStorage.getItem('pending_ukt_order_id');
    if (pendingOrderId) {
        console.log('🔄 Found pending UKT order:', pendingOrderId);
        startUktPaymentPolling(pendingOrderId);
    }
}

// ========== 7. SETUP FORM UPLOAD ==========
function setupUktUploadForm() {
    const form = document.getElementById('formUploadManualUkt');
    if (!form) return;
    
    form.addEventListener('submit', function() {
        const btn = document.getElementById('btnUploadBuktiUkt');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengupload...';
        }
    });
}

// ========== 8. INITIALIZE EVERYTHING ==========
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM loaded, initializing UKT system...');
    
    // Setup payment button
    setupUktPaymentButton();
    
    // Setup upload form
    setupUktUploadForm();
    
    // Check for pending payments every 30 seconds
    setInterval(() => {
        const pendingId = localStorage.getItem('pending_ukt_order_id');
        if (pendingId) {
            console.log('🕐 Periodic check for pending order:', pendingId);
            checkUktPaymentStatus(pendingId).then(result => {
                if (result.success) {
                    localStorage.removeItem('pending_ukt_order_id');
                    if (document.getElementById('modalBayarUkt').classList.contains('hidden')) {
                        // Modal tidak terbuka, refresh page
                        window.location.reload();
                    } else {
                        // Modal terbuka, show success popup
                        showUktSuccessPopup();
                    }
                }
            });
        }
    }, 30000);
    
    console.log('✅ UKT system initialized successfully');
});

// ========== 9. GLOBAL FUNCTIONS (bisa dipanggil dari mana saja) ==========
window.openModalBayarUkt = openModalBayarUkt;
window.closeModalBayarUkt = closeModalBayarUkt;
window.closeUktSuccessPopup = closeUktSuccessPopup;
</script>