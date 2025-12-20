<div id="modalBayarUkt" class="fixed inset-0 hidden z-[9999]">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
         onclick="closeModalBayarUkt()"></div>

    <!-- Modal Card -->
    <div class="relative mx-auto mt-10 w-[95%] max-w-6xl bg-white rounded-2xl shadow-2xl overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="flex items-center gap-4 p-6 border-b bg-green-600 text-white rounded-t-2xl">
            <button onclick="closeModalBayarUkt()"
                class="p-2 bg-white/20 rounded-full hover:bg-white/30 transition">
                ✕
            </button>
            <div>
                <h2 class="text-2xl font-semibold">Pembayaran Pendaftran Ulang</h2>
                <p class="text-green-100 text-sm">Step 7 dari 8 — Selesaikan pembayaran Pendaftaran Ulang</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">

            <!-- INFORMASI MAHASISWA -->
            <div class="space-y-6">
                <div class="bg-white border rounded-xl shadow p-6">
                    <h3 class="font-semibold text-green-700 mb-4">Informasi Mahasiswa</h3>

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
                            <td class="text-gray-500 py-1">Program Studi</td>
                            <td class="font-medium">{{ $user->namaProdiPilihan1 ?? $user->pilihan_1 }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Ringkasan biaya UKT -->
                <div class="bg-white border rounded-xl shadow p-6">
                    <h3 class="font-semibold text-green-700 mb-4">Ringkasan Biaya UKT</h3>

                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">UKT Semester 1</span>
                        <span class="font-semibold">Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-sm mb-4">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="font-bold text-green-600">GRATIS</span>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between">
                        <span class="font-semibold text-lg">Total</span>
                        <span class="text-green-700 font-bold text-2xl">
                            Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- PEMBAYARAN -->
            <div class="lg:col-span-2">
                <div class="bg-white border rounded-xl shadow">

                    <div class="border-b p-6">
                        <h3 class="font-semibold text-green-700">Metode Pembayaran Online</h3>
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
                                    Anda dapat melanjutkan ke tahap berikutnya
                                </p>
                                <button onclick="closeModalBayarUkt()"
                                    class="mt-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Tutup
                                </button>
                            </div>
                        @else
                        
                        <!-- Tabs -->
                        <div class="flex gap-3 mb-6">
                            <button class="tab-btn-ukt active px-4 py-2 bg-green-600 text-white rounded-lg font-medium transition"
                                data-target="#midtransTabUkt">
                                💳 Online (Midtrans)
                            </button>

                            <!-- <button class="tab-btn-ukt px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium transition hover:bg-gray-200"
                                data-target="#manualTabUkt">
                                🏦 Transfer Manual
                            </button> -->
                        </div>

                        <!-- TAB: MIDTRANS -->
                        <div id="midtransTabUkt" class="tab-content-ukt block">
                            <div class="text-center py-10">
                                <div class="text-green-600 text-6xl mb-4">💳</div>
                                <h3 class="text-xl font-semibold mb-2">Pembayaran Pendaftaran Ulang</h3>
                                <p class="text-gray-500 mb-2">Bayar dengan mudah menggunakan:</p>
                                
                                <div class="flex flex-wrap justify-center gap-2 mb-6">
                                    <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full">Transfer Bank</span>
                                    <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full">GoPay</span>
                                    <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full">ShopeePay</span>
                                    <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full">QRIS</span>
                                    <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full">Kartu Kredit</span>
                                </div>

                                <button type="button" id="btnBayarUkt"
                                    class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold flex items-center justify-center gap-2 mx-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    Bayar UKT Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}
                                </button>

                                <!-- Loading Indicator -->
                                <div class="mt-4 hidden" id="loadingPaymentUkt">
                                    <div class="inline-block animate-spin border-4 border-green-600 border-t-transparent rounded-full w-10 h-10"></div>
                                    <p class="text-gray-600 mt-2 text-sm">Memproses pembayaran UKT...</p>
                                </div>
                                
                                <!-- Error Message -->
                                <div class="mt-4 hidden p-4 bg-red-50 border border-red-200 rounded-lg" id="errorPaymentUkt">
                                    <p class="text-red-600 text-sm" id="errorMessageUkt"></p>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: MANUAL TRANSFER -->
                        <!-- <div id="manualTabUkt" class="tab-content-ukt hidden">

                            <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg text-sm mb-6">
                                <p class="font-semibold text-yellow-800 mb-1">⚠️ Perhatian</p>
                                <p class="text-yellow-700">Transfer sesuai <strong>nominal yang tertera</strong>, lalu upload bukti transfer. Admin akan memverifikasi dalam 1x24 jam.</p>
                            </div>

                            Info Rekening
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                <h4 class="font-semibold text-green-800 mb-3">Rekening Tujuan Transfer UKT</h4>
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
                                    <div class="flex justify-between border-t border-green-300 pt-2 mt-2">
                                        <span class="text-gray-600">Nominal Transfer</span>
                                        <span class="font-bold text-green-700 text-lg">Rp {{ number_format($biaya_ukt ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('ukt.upload') }}" method="POST" enctype="multipart/form-data" id="formUploadManualUkt">
                                @csrf
                                <input type="hidden" name="jumlah" value="{{ $biaya_ukt ?? 0 }}">

                                <div class="mb-4">
                                    <label class="block font-semibold text-gray-700 mb-2">
                                        Upload Bukti Transfer <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="bukti_bayar"
                                        class="block w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        accept="image/jpeg,image/png,image/jpg,application/pdf"
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau PDF. Max 2MB</p>
                                </div>

                                <button type="submit" id="btnUploadBuktiUkt"
                                    class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    Upload Bukti Transfer UKT
                                </button>
                            </form>

                        </div> -->

                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Success Popup UKT -->
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
            <button onclick="closeUktSuccessPopupAndReload()" class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold">
                Tutup dan Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== TAB SWITCHING =====
    document.querySelectorAll(".tab-btn-ukt").forEach(btn => {
        btn.addEventListener("click", function() {
            // Reset semua tab button
            document.querySelectorAll(".tab-btn-ukt").forEach(b => {
                b.classList.remove("bg-green-600", "text-white");
                b.classList.add("bg-gray-100", "text-gray-700");
            });
            // Aktifkan tab yang diklik
            this.classList.add("bg-green-600", "text-white");
            this.classList.remove("bg-gray-100", "text-gray-700");
            // Sembunyikan semua content
            document.querySelectorAll(".tab-content-ukt").forEach(tab => tab.classList.add("hidden"));
            // Tampilkan content yang sesuai
            document.querySelector(this.dataset.target).classList.remove("hidden");
        });
    });

    // ===== UKT PAYMENT HANDLER =====
    const btnBayarUkt = document.getElementById('btnBayarUkt');
    
    if (btnBayarUkt) {
        btnBayarUkt.addEventListener('click', function(e) {
            e.preventDefault();
            
            const loadingDiv = document.getElementById('loadingPaymentUkt');
            const errorDiv = document.getElementById('errorPaymentUkt');
            const errorMsg = document.getElementById('errorMessageUkt');
            
            // Show loading
            loadingDiv.classList.remove('hidden');
            errorDiv.classList.add('hidden');
            btnBayarUkt.disabled = true;
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Fetch snap token from server
            fetch('{{ route("ukt.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                console.log('Response status:', response.status);
                
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    return response.text().then(function(text) {
                        console.error('Server returned non-JSON:', text.substring(0, 500));
                        throw new Error('Server error - Response bukan JSON');
                    });
                }
                
                return response.json();
            })
            .then(function(data) {
                // Hide loading
                loadingDiv.classList.add('hidden');
                btnBayarUkt.disabled = false;
                
                console.log('UKT Response:', data);
                
                if (data.success && data.snap_token) {
                    // Save order_id
                    if (data.order_id) {
                        localStorage.setItem('pending_order_id', data.order_id);
                        localStorage.setItem('pending_payment_type', 'ukt');
                    }
                    
                    // Open Midtrans Snap
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('UKT Payment success:', result);
                            window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=settlement&type=ukt';
                        },
                        onPending: function(result) {
                            console.log('UKT Payment pending:', result);
                            window.location.href = '{{ route("payment.finish") }}?order_id=' + data.order_id + '&transaction_status=pending&type=ukt';
                        },
                        onError: function(result) {
                            console.error('UKT Payment error:', result);
                            errorMsg.textContent = 'Pembayaran UKT gagal. Silakan coba lagi.';
                            errorDiv.classList.remove('hidden');
                        },
                        onClose: function() {
                            console.log('UKT Payment popup closed');
                        }
                    });
                } else {
                    // Show error message
                    errorMsg.textContent = data.message || 'Gagal membuat transaksi UKT.';
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(function(error) {
                console.error('UKT Fetch error:', error);
                loadingDiv.classList.add('hidden');
                btnBayarUkt.disabled = false;
                errorMsg.textContent = error.message || 'Terjadi kesalahan.';
                errorDiv.classList.remove('hidden');
            });
        });
    }

    // ===== UPLOAD MANUAL HANDLER =====
    const formUploadUkt = document.getElementById('formUploadManualUkt');
    if (formUploadUkt) {
        formUploadUkt.addEventListener('submit', function() {
            const btn = document.getElementById('btnUploadBuktiUkt');
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengupload...';
        });
    }
});

// ===== MODAL FUNCTIONS =====
function openModalBayarUkt() {
    document.getElementById('modalBayarUkt').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModalBayarUkt() {
    document.getElementById('modalBayarUkt').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showUktSuccessPopup() {
    document.getElementById('uktSuccessPopup').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeUktSuccessPopupAndReload() {
    document.getElementById('uktSuccessPopup').classList.add('hidden');
    closeModalBayarUkt();
    window.location.reload();
}
</script>