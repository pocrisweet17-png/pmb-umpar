<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    {{-- Tambahkan setelah opening <body> atau di bagian atas content --}}
@if(session('success'))
<div class="fixed top-4 right-4 z-50 animate-slide-in-right">
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-lg max-w-md">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed top-4 right-4 z-50 animate-slide-in-right">
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-lg max-w-md">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<script>
// Auto hide flash messages after 5 seconds
setTimeout(() => {
    document.querySelectorAll('.animate-slide-in-right').forEach(el => {
        el.style.opacity = '0';
        el.style.transition = 'opacity 0.5s';
        setTimeout(() => el.remove(), 500);
    });
}, 5000);
</script>

    @yield('content')

    @stack('scripts')

</body>
</html>
