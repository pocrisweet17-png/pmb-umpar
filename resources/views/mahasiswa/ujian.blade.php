<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ujian Seleksi - UMPAR</title>

    <!-- Tailwind CSS 4 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-scaleIn {
            animation: scaleIn 0.5s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.5s ease-out;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        /* Gradient background animation */
        .bg-gradient-animated {
            background: linear-gradient(-45deg, #3b82f6, #8b5cf6, #ec4899, #f59e0b);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Custom radio button */
        input[type="radio"]:checked + span {
            background-color: #eff6ff;
            border-color: #3b82f6;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gradient-animated min-h-screen">

    <div class="container mx-auto px-4 py-8 md:py-12">

        <!-- Header -->
        <div class="text-center mb-8 md:mb-12 animate-fadeInUp">
            <div class="inline-block mb-4">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-white rounded-full shadow-2xl flex items-center justify-center mx-auto mb-4 transform hover:scale-110 transition-transform duration-300">
                    <span class="text-4xl md:text-5xl">📝</span>
                </div>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-3 drop-shadow-lg">Ujian Seleksi Mahasiswa Baru</h1>
            <p class="text-white text-lg md:text-xl font-medium drop-shadow">Universitas Muhammadiyah Parepare</p>
        </div>

        @if(session('success'))
        <div class="mb-6 max-w-2xl mx-auto glass border-2 border-green-400 text-green-700 px-4 md:px-6 py-4 rounded-2xl shadow-xl animate-scaleIn">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 max-w-2xl mx-auto glass border-2 border-red-400 text-red-700 px-4 md:px-6 py-4 rounded-2xl shadow-xl animate-scaleIn">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Jika Sudah Ujian -->
        @if($sudahUjian)
        <div class="max-w-3xl mx-auto glass rounded-3xl shadow-2xl p-6 md:p-10 border-4 border-red-500 animate-scaleIn">
            <div class="text-center">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-red-500 rounded-full blur-xl opacity-50 animate-pulse"></div>
                    <svg class="w-20 h-20 md:w-28 md:h-28 relative text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4">⚠️ Ujian Sudah Diselesaikan</h2>
                <p class="text-gray-600 text-base md:text-lg mb-8 max-w-xl mx-auto">Anda sudah pernah mengikuti ujian ini. Setiap peserta hanya dapat mengikuti ujian <strong>satu kali</strong>.</p>

                @if($ujian)
                <div class="glass rounded-2xl p-6 md:p-8 mb-8 shadow-inner">
                    <div class="grid grid-cols-2 gap-4 md:gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 md:p-6 transform hover:scale-105 transition-transform">
                            <p class="text-xs md:text-sm text-gray-600 mb-2">Nilai Akhir</p>
                            <p class="text-3xl md:text-4xl font-bold text-blue-600">{{ number_format($ujian->nilaiAkhir, 0) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-{{ $ujian->nilaiAkhir >= 70 ? 'green' : 'red' }}-50 to-{{ $ujian->nilaiAkhir >= 70 ? 'green' : 'red' }}-100 rounded-xl p-4 md:p-6 transform hover:scale-105 transition-transform">
                            <p class="text-xs md:text-sm text-gray-600 mb-2">Status</p>
                            <p class="text-2xl md:text-3xl font-bold {{ $ujian->nilaiAkhir >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $ujian->nilaiAkhir >= 70 ? '✓ LULUS' : '✗ TIDAK LULUS' }}
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-4 md:p-6 transform hover:scale-105 transition-transform">
                            <p class="text-xs md:text-sm text-gray-600 mb-2">Jawaban Benar</p>
                            <p class="text-2xl md:text-3xl font-bold text-green-600">{{ $ujian->jumlahBenar }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-xl p-4 md:p-6 transform hover:scale-105 transition-transform">
                            <p class="text-xs md:text-sm text-gray-600 mb-2">Jawaban Salah</p>
                            <p class="text-2xl md:text-3xl font-bold text-red-600">{{ $ujian->jumlahSalah }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <a href="{{ route('mahasiswa.dashboard') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 md:px-10 py-3 md:py-4 rounded-xl font-semibold text-base md:text-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-xl hover:shadow-2xl transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
        @else
        <!-- Jika Belum Ujian - Tampilkan Info & Tombol -->
        <div class="max-w-3xl mx-auto glass rounded-3xl shadow-2xl p-6 md:p-10 mb-8 animate-fadeInUp">
            <div class="text-center mb-8">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-blue-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                    <div class="relative inline-flex items-center justify-center w-20 h-20 md:w-28 md:h-28 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 shadow-2xl transform hover:rotate-12 transition-transform duration-300">
                        <svg class="w-10 h-10 md:w-14 md:h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">Petunjuk Ujian</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto rounded-full"></div>
            </div>

            <div class="space-y-4 mb-10 bg-gradient-to-br from-blue-50 to-purple-50 p-6 md:p-8 rounded-2xl shadow-inner">
                <div class="flex items-start gap-4 animate-slideInRight delay-100">
                    <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">1</div>
                    <p class="text-gray-700 text-sm md:text-base pt-1">Total soal: <strong class="text-blue-600">{{ count($soals) }} soal pilihan ganda</strong></p>
                </div>
                <div class="flex items-start gap-4 animate-slideInRight delay-200">
                    <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">2</div>
                    <p class="text-gray-700 text-sm md:text-base pt-1">Anda harus menjawab <strong class="text-purple-600">SEMUA soal</strong> sebelum menyelesaikan ujian</p>
                </div>
                <div class="flex items-start gap-4 animate-slideInRight delay-300">
                    <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">3</div>
                    <p class="text-gray-700 text-sm md:text-base pt-1">Nilai kelulusan: <strong class="text-pink-600">≥ 70</strong></p>
                </div>
                <div class="flex items-start gap-4 animate-slideInRight delay-400">
                    <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">4</div>
                    <p class="text-gray-700 text-sm md:text-base pt-1">Ujian hanya dapat dilakukan <strong class="text-orange-600">SATU KALI</strong></p>
                </div>
                <div class="flex items-start gap-4 animate-slideInRight delay-500">
                    <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">5</div>
                    <p class="text-gray-700 text-sm md:text-base pt-1">Pastikan koneksi internet Anda <strong class="text-teal-600">stabil</strong></p>
                </div>
            </div>

            <div class="text-center">
                <button onclick="openModal()"
                        class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white px-8 md:px-12 py-4 md:py-5 rounded-2xl font-bold text-base md:text-xl hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 transition-all shadow-2xl hover:shadow-3xl transform hover:scale-105">
                    <span class="text-2xl">🚀</span>
                    <span>Mulai Ujian Sekarang</span>
                    <svg class="w-5 h-5 md:w-6 md:h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

    </div>

    <!-- MODAL UJIAN (Full Screen Scrollable) -->
    @if(!$sudahUjian && count($soals) > 0)
    <div id="modalUjian" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-2 md:p-4">
        <div class="glass rounded-2xl md:rounded-3xl shadow-2xl w-full max-w-5xl max-h-[95vh] md:max-h-[90vh] flex flex-col animate-scaleIn">

            <!-- Header Modal (Fixed) -->
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white p-4 md:p-6 rounded-t-2xl md:rounded-t-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-3 md:gap-0">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                        <span>📝</span>
                        <span>Soal Ujian Seleksi</span>
                    </h2>
                    <p class="text-xs md:text-sm text-blue-100 mt-1">Total: {{ count($soals) }} soal</p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-xs md:text-sm opacity-90">Peserta:</p>
                    <p class="font-bold text-sm md:text-base">{{ Auth::user()->nama_lengkap }}</p>
                </div>
            </div>

            <!-- Body Modal (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-4 md:p-6">
                <form id="formUjian" action="{{ route('mahasiswa.ujian.submit') }}" method="POST">
                    @csrf

<div class="space-y-4 md:space-y-6">
    @foreach($soals as $index => $soal)
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border-2 border-gray-200 hover:border-blue-400 hover:shadow-xl transition-all">

        <!-- Nomor & Pertanyaan -->
        <div class="mb-4">
            <div class="flex items-start gap-3">
                <span class="inline-flex items-center justify-center w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 text-white font-bold text-sm md:text-base flex-shrink-0 shadow-lg">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1">
                    <p class="text-gray-800 font-medium leading-relaxed text-sm md:text-base">
                        {{ $soal->textSoal }}
                    </p>
                    <!-- Gambar Soal -->
                    @if($soal->gambar_soal)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $soal->gambar_soal) }}" 
                                 alt="Gambar Soal {{ $index + 1 }}" 
                                 class="rounded-lg shadow-md border-2 border-gray-200 max-w-full h-auto md:max-w-sm lg:max-w-md hover:shadow-lg transition-shadow cursor-pointer"
                                 onclick="openImageModal(this.src)">
                        </div>
                    @endif
                            <!-- Pilihan Jawaban -->
                            <div class="space-y-2 md:space-y-3 ml-0 md:ml-13">
                                @foreach(['a' => $soal->opsi_a, 'b' => $soal->opsi_b, 'c' => $soal->opsi_c, 'd' => $soal->opsi_d] as $key => $opsi)
                                <label class="flex items-start gap-3 p-3 md:p-4 rounded-lg hover:bg-blue-50 cursor-pointer transition-all border-2 border-transparent hover:border-blue-300 group">
                                    <input type="radio"
                                           name="jawaban[{{ $soal->idSoal }}]"
                                           value="{{ $key }}"
                                           class="w-5 h-5 md:w-6 md:h-6 text-blue-600 focus:ring-blue-500 cursor-pointer mt-0.5 flex-shrink-0"
                                           required>
                                    <span class="text-gray-700 text-sm md:text-base flex-1 group-hover:text-blue-700 transition-colors">
                                        <strong class="text-blue-600 uppercase">{{ $key }}.</strong> {{ $opsi }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                        </div>
                        @endforeach
                    </div>

                    <!-- Footer Modal (Fixed) -->
                    <div class="sticky bottom-0 glass pt-4 md:pt-6 mt-4 md:mt-6 border-t-2 border-gray-300 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                        <button type="button"
                                onclick="closeModal()"
                                class="bg-gray-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-600 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Batal</span>
                        </button>

                        <button type="button"
                                onclick="submitUjian()"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 md:px-8 py-3 rounded-xl font-bold hover:from-green-700 hover:to-emerald-700 transition-all shadow-xl hover:shadow-2xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Selesaikan Ujian</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
    @endif

    <script>
        function openModal() {
            document.getElementById('modalUjian').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent body scroll
        }

        function closeModal() {
            if (confirm('⚠️ Apakah Anda yakin ingin membatalkan ujian? Semua jawaban akan hilang.')) {
                document.getElementById('modalUjian').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        function submitUjian() {
            const form = document.getElementById('formUjian');
            const totalSoal = {{ count($soals) }};
            const radios = form.querySelectorAll('input[type="radio"]:checked');

            // Validasi: pastikan semua soal terjawab
            if (radios.length < totalSoal) {
                alert('⚠️ Harap jawab SEMUA soal sebelum menyelesaikan ujian!\n\nAnda baru menjawab ' + radios.length + ' dari ' + totalSoal + ' soal.');
                return false;
            }

            // Konfirmasi final
            if (confirm('✅ Apakah Anda yakin sudah menjawab semua soal dengan benar?\n\n⚠️ Setelah dikirim, jawaban TIDAK DAPAT DIUBAH!')) {
                form.submit();
            }
        }

        // Prevent accidental page leave
        window.addEventListener('beforeunload', function (e) {
            const modal = document.getElementById('modalUjian');
            if (modal && !modal.classList.contains('hidden')) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modalUjian');
                if (modal && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            }
        });
    </script>

</body>
</html>
