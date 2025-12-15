<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex lg:flex-col lg:w-72 bg-gradient-to-b from-gray-900 via-gray-900 to-gray-800 text-white shadow-2xl">

            <div class="flex items-center justify-center h-20 bg-gradient-to-r from-blue-600 to-blue-700 px-6 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <img src="/img/umpar.png" alt="" class="w-8 h-8 object-contain">
                    </div>
                    <h2 class="text-xl font-bold tracking-tight">Admin Panel</h2>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center px-4 py-3.5 text-gray-300 hover:bg-gray-800/50 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' : '' }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-gray-800/50 group-hover:bg-gray-700/50' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.soal.index') }}"
                   class="group flex items-center px-4 py-3.5 text-gray-300 hover:bg-gray-800/50 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.soal.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' : '' }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.soal.*') ? 'bg-white/20' : 'bg-gray-800/50 group-hover:bg-gray-700/50' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Kelola Soal</span>
                </a>

                <a href="{{ route('admin.user.index') }}"
                   class="group flex items-center px-4 py-3.5 text-gray-300 hover:bg-gray-800/50 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.user.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' : '' }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.user.*') ? 'bg-white/20' : 'bg-gray-800/50 group-hover:bg-gray-700/50' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Kelola User</span>
                </a>
            </nav>

            <div class="p-6 border-t border-gray-800/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-red-500/10 hover:text-red-400 transition-all rounded-xl group">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-gray-800/50 group-hover:bg-red-500/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <span class="ml-3 font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"
             style="display: none;">
        </div>

        <!-- Mobile Sidebar -->
        <aside x-show="sidebarOpen"
               @click.away="sidebarOpen = false"
               x-transition:enter="transition ease-in-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-gray-900 via-gray-900 to-gray-800 text-white lg:hidden flex flex-col shadow-2xl"
               style="display: none;">

            <div class="flex items-center justify-between h-20 px-6 bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <img src="/img/umpar.png" alt="" class="w-8 h-8 object-contain">
                    </div>
                    <h2 class="text-xl font-bold">Admin Panel</h2>
                </div>
                <button @click="sidebarOpen = false" class="text-white/80 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center px-4 py-3.5 text-gray-300 hover:bg-gray-800/50 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' : '' }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-gray-800/50 group-hover:bg-gray-700/50' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.soal.index') }}"
                   class="group flex items-center px-4 py-3.5 text-gray-300 hover:bg-gray-800/50 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.soal.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' : '' }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.soal.*') ? 'bg-white/20' : 'bg-gray-800/50 group-hover:bg-gray-700/50' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Kelola Soal</span>
                </a>

                <a href="{{ route('admin.user.index') }}"
                   class="group flex items-center px-4 py-3.5 text-gray-300 hover:bg-gray-800/50 hover:text-white transition-all rounded-xl {{ request()->routeIs('admin.user.*') ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg shadow-green-500/30' : '' }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.user.*') ? 'bg-white/20' : 'bg-gray-800/50 group-hover:bg-gray-700/50' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Kelola User</span>
                </a>
            </nav>

            <div class="p-6 border-t border-gray-800/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-red-500/10 hover:text-red-400 transition-all rounded-xl group">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-gray-800/50 group-hover:bg-red-500/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <span class="ml-3 font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Navbar -->
            <header class="bg-white/80 backdrop-blur-xl shadow-sm h-20 flex items-center px-4 sm:px-6 lg:px-8 z-10 border-b border-gray-200/50">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4 w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex-1">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5 hidden sm:block">Welcome back, {{ Auth::user()->name }}!</p>
                </div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <span class="text-sm text-gray-600 hidden md:block font-medium">{{ Auth::user()->name }}</span>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center text-white font-bold text-base sm:text-lg shadow-lg shadow-blue-500/30 ring-2 ring-blue-100">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>
