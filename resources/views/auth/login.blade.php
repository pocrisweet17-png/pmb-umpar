<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Login & Register - PMB UMPAR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Pendaftaran Mahasiswa Baru Universitas Muhammadiyah Parepare">
    <meta name="theme-color" content="#1e40af">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite('resources/css/app.css')

    <style>
        [x-cloak] { display: none !important; }
        .smooth-transition { transition: all 0.3s ease-in-out; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-emerald-50 font-['Poppins'] text-gray-800 text-sm antialiased">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-white shadow-md">
                    <!-- Replace with your logo -->
                    <span class="text-2xl font-bold text-blue-600">UMPAR</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Portal PMB UMPAR</h1>
                <p class="text-gray-600 text-sm">Selamat datang di sistem pendaftaran mahasiswa baru</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-6xl mx-auto transform hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col lg:flex-row">
                    <!-- Sidebar -->
                    <div class="hidden lg:flex flex-col w-1/3 bg-gradient-to-br from-blue-600 to-emerald-500 p-8 text-white">
                        <div class="max-w-xs mx-auto">
                            <h2 class="text-xl font-bold mb-3">Bergabung Bersama Kami</h2>
                            <p class="text-blue-100 text-sm mb-6">Daftarkan diri Anda sekarang dan raih masa depan gemilang bersama UMPAR</p>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-6 h-6 rounded-full bg-white/20 flex-shrink-0 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm">Proses pendaftaran mudah</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-6 h-6 rounded-full bg-white/20 flex-shrink-0 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm">Fasilitas lengkap</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-6 h-6 rounded-full bg-white/20 flex-shrink-0 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm">Dosen profesional</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Forms Container -->
                    <div class="flex-1 p-6 sm:p-8 lg:p-10">
                        <!-- Mobile Tabs -->
                        <div class=" mb-6">
                            <div class="flex bg-gray-100 rounded-lg p-1">
                                <button id="mobile-login-tab" class="flex-1 py-2 px-4 rounded-md font-medium text-sm focus:outline-none transition-all duration-200" onclick="showLogin()">
                                    Masuk
                                </button>
                                <button id="mobile-register-tab" class="flex-1 py-2 px-4 rounded-md font-medium text-sm text-gray-600 focus:outline-none transition-all duration-200" onclick="showRegister()">
                                    Daftar
                                </button>
                            </div>
                        </div>

                        <!-- Login Form -->
                        <div id="loginForm" class="space-y-6">
                            <div class="text-center lg:text-left">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1.5">Masuk ke Akun</h2>
                                <p class="text-gray-500 text-sm">Silakan masukkan kredensial Anda</p>
                            </div>

                            @if(session('success'))
                                <div class="text-green-600 mb-4">{{ session('success') }}</div>
                            @endif

                            @if(session('error'))
                                <div class="text-red-600 mb-4">{{ session('error') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="text-red-600 mb-4">
                                    <ul class="list-disc pl-5">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <form action="{{ route('login.process') }}" method="POST" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username / Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" name="login" required
                                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Masukkan username atau email">
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-sm font-medium text-gray-700">Password</label>
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Lupa password?</a>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="password" name="password" required
                                            class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Masukkan password">
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 disabled:opacity-75 disabled:cursor-not-allowed"
                                            :disabled="loading">
                                        <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-show="!loading">Masuk</span>
                                        <span x-show="loading">Memproses...</span>
                                    </button>
                                </div>
                            </form>


                        </div>

                        <!-- Register Form -->
                        <div id="registerForm" class="hidden space-y-6">
                            <div class="lg:hidden mb-6">
                                <!-- <button type="button" onclick="showLogin()" class="flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Kembali ke Login
                                </button> -->
                            </div>
                            <div class="text-center lg:text-left">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1.5">Buat Akun Baru</h2>
                                <p class="text-gray-500 text-sm">Isi data diri Anda dengan lengkap</p>
                            </div>

                            <form action="{{ route('register') }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <input type="text" name="nama_lengkap" required
                                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                placeholder="Nama lengkap">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NIK (KTP/KK)</label>
                                        <input type="text" name="nik" required
                                            class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="Nomor NIK">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                        <input type="text" name="username" required
                                            class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="Username unik">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                </svg>
                                            </div>
                                            <input type="email" name="email" required
                                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                placeholder="email@contoh.com">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">No WhatsApp</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                            </div>
                                            <input type="text" name="no_whatsapp" required
                                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                placeholder="Contoh: 6281234567890">
                                        </div>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <input type="password" name="password" required
                                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                placeholder="Buat password yang kuat">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-start pt-2">
                                    <div class="flex items-center h-5 mt-0.5">
                                        <input id="terms" name="terms" type="checkbox" required
                                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    </div>
                                    <label for="terms" class="ml-3 block text-sm text-gray-700">
                                        Saya menyetujui <a href="#" class="font-medium text-blue-600 hover:text-blue-500">syarat dan ketentuan</a> yang berlaku
                                    </label>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200 disabled:opacity-75 disabled:cursor-not-allowed"
                                            :disabled="loading">
                                        <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-show="!loading">Daftar Sekarang</span>
                                        <span x-show="loading">Mendaftarkan...</span>
                                    </button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        document.addEventListener('alpine:init', () => {
            // Your Alpine.js code here if needed
        });

        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            const mobileLoginTab = document.getElementById('mobile-login-tab');
            const mobileRegisterTab = document.getElementById('mobile-register-tab');

            function isMobile() {
                return window.innerWidth < 1024; // lg breakpoint
            }

            function setActiveTab(tab) {
                // Mobile tabs
                if (mobileLoginTab && mobileRegisterTab) {
                    if (tab === 'login') {
                        mobileLoginTab.classList.remove('text-gray-600', 'bg-transparent');
                        mobileLoginTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                        mobileRegisterTab.classList.remove('bg-white', 'text-emerald-600', 'shadow-sm');
                        mobileRegisterTab.classList.add('text-gray-600', 'bg-transparent');
                    } else {
                        mobileRegisterTab.classList.remove('text-gray-600', 'bg-transparent');
                        mobileRegisterTab.classList.add('bg-white', 'text-emerald-600', 'shadow-sm');
                        mobileLoginTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                        mobileLoginTab.classList.add('text-gray-600', 'bg-transparent');
                    }
                }
            }

            function showLogin() {
                if (loginForm) loginForm.classList.remove('hidden');
                if (registerForm) registerForm.classList.add('hidden');
                setActiveTab('login');

                // Scroll to top on mobile
                if (isMobile()) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }

            function showRegister() {
                if (loginForm) loginForm.classList.add('hidden');
                if (registerForm) {
                    registerForm.classList.remove('hidden');
                    registerForm.classList.add('block');
                }
                setActiveTab('register');

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Initialize
            if (isMobile()) {
                showLogin();
            } else {
                // On desktop, show login form by default
                showLogin();
            }

            // Handle window resize with debounce
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (isMobile()) {
                        // On mobile, show the form that was previously selected
                        if (loginForm && loginForm.classList.contains('hidden') &&
                            registerForm && registerForm.classList.contains('hidden')) {
                            // If both forms are hidden (can happen when resizing from desktop)
                            showLogin();
                        }
                    } else {
                        // On desktop, always show login form by default
                        showLogin();
                    }
                }, 100);
            });

            // Add click handlers for tab buttons if they exist
            if (loginTab) loginTab.addEventListener('click', showLogin);
            if (registerTab) registerTab.addEventListener('click', showRegister);
            if (mobileLoginTab) mobileLoginTab.addEventListener('click', showLogin);
            if (mobileRegisterTab) mobileRegisterTab.addEventListener('click', showRegister);

            // Add keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!isMobile()) return;
                    if (registerForm && !registerForm.classList.contains('hidden')) {
                        showLogin();
                    }
                }
            });
        });
    </script>
</body>
</html>
