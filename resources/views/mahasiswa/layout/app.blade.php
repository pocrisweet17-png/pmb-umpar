<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PMB Online')</title>
    
    <!-- ============================================================== -->
    <!-- CRITICAL: CSS ini HARUS di paling atas untuk block rendering   -->
    <!-- ============================================================== -->
    <style>
        /* Sembunyikan SEMUA konten kecuali loading screen */
        body > *:not(#loading-screen) {
            visibility: hidden !important;
            opacity: 0 !important;
        }
        body.ready > *:not(#loading-screen) {
            visibility: visible !important;
            opacity: 1 !important;
            transition: opacity 0.3s ease;
        }
        /* Loading screen styles */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #6366f1 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 2147483647;
        }
        #loading-screen.hide {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        .loader-spinner {
            width: 56px;
            height: 56px;
            border: 4px solid rgba(255,255,255,0.2);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        .loader-text {
            margin-top: 20px;
            color: #fff;
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 15px;
            font-weight: 500;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    @stack('styles')
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

<!-- Loading Screen -->
<div id="loading-screen">
    <div class="loader-spinner"></div>
    <div class="loader-text">Memuat halaman...</div>
</div>

<!-- Navigation -->
@auth
<nav class="bg-white shadow-lg border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">PMB Online</span>
                </a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ Auth::user()->nama_lengkap }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors text-sm font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
@endauth

<!-- Main Content -->
<main>
    @yield('content')
</main>

<!-- Scripts -->
@stack('scripts')

<!-- Hide loading when ready -->
<script>
(function(){
    function showPage() {
        document.body.classList.add('ready');
        var loader = document.getElementById('loading-screen');
        if (loader) {
            loader.classList.add('hide');
            setTimeout(function() {
                if (loader.parentNode) loader.parentNode.removeChild(loader);
            }, 400);
        }
    }
    
    if (document.readyState === 'complete') {
        showPage();
    } else {
        window.addEventListener('load', showPage);
    }
    
    // Fallback
    setTimeout(showPage, 6000);
})();
</script>
</body>
</html>