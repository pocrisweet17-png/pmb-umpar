{{-- Sidebar User Dashboard --}}
{{-- File: resources/views/partials/sidebar-user.blade.php --}}
{{-- ENHANCED VERSION - Animations, Micro-interactions, Responsive --}}

<style>
    /* Sidebar Animations */
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes pulse-ring {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.3); opacity: 0; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    
    .sidebar-item {
        animation: slideIn 0.3s ease-out forwards;
        opacity: 0;
    }
    
    .sidebar-item:nth-child(1) { animation-delay: 0.05s; }
    .sidebar-item:nth-child(2) { animation-delay: 0.1s; }
    .sidebar-item:nth-child(3) { animation-delay: 0.15s; }
    .sidebar-item:nth-child(4) { animation-delay: 0.2s; }
    .sidebar-item:nth-child(5) { animation-delay: 0.25s; }
    
    .menu-item-hover {
        position: relative;
        overflow: hidden;
    }
    
    .menu-item-hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .menu-item-hover:hover::before {
        left: 100%;
    }
    
    .avatar-ring {
        position: relative;
    }
    
    .avatar-ring::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.3);
        animation: pulse-ring 2s ease-out infinite;
    }
    
    .logo-float:hover {
        animation: float 1s ease-in-out infinite;
    }
    
    /* Custom Scrollbar for Sidebar */
    .sidebar-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 2px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.3);
    }
</style>

<aside id="sidebarUser" class="fixed inset-y-0 left-0 z-40 w-[272px] bg-gradient-to-b from-blue-600 via-blue-700 to-blue-800 shadow-2xl shadow-blue-900/30 transform transition-all duration-500 ease-out lg:translate-x-0 -translate-x-full flex flex-col">
    
    {{-- Decorative Background Pattern --}}
    <div class="absolute inset-0 opacity-5 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-white rounded-full"></div>
        <div class="absolute top-1/3 -left-12 w-24 h-24 bg-white rounded-full"></div>
        <div class="absolute bottom-1/4 -right-8 w-32 h-32 bg-white rounded-full"></div>
    </div>
    
    {{-- Sidebar Header / Logo --}}
    <div class="relative flex items-center justify-between h-[72px] px-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            {{-- Logo Icon --}}
            <div class="logo-float w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20 transition-transform duration-300 hover:scale-105 cursor-pointer">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg tracking-tight">PMB Online</h1>
                <p class="text-blue-200/70 text-xs font-medium">Portal Mahasiswa Baru</p>
            </div>
        </div>
        
        {{-- Mobile Close Button --}}
        <button onclick="toggleSidebar()" class="lg:hidden text-white/70 hover:text-white p-2 rounded-xl hover:bg-white/10 active:scale-95 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    {{-- User Info Card --}}
    <div class="relative px-4 py-5 sidebar-item">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10 hover:bg-white/15 transition-all duration-300 cursor-pointer group">
            <div class="flex items-center gap-3">
                <div class="avatar-ring flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-white to-blue-100 rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <span class="text-blue-600 font-bold text-lg">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-semibold text-sm truncate group-hover:text-blue-100 transition-colors">{{ $user->name ?? 'User' }}</p>
                    <p class="text-blue-200/60 text-xs truncate">{{ $user->nim ?? '-' }}</p>
                </div>
                <div class="w-2 h-2 bg-green-400 rounded-full shadow-lg shadow-green-400/50 animate-pulse"></div>
            </div>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-4 overflow-y-auto sidebar-scroll">
        
        {{-- Menu Label --}}
        <p class="sidebar-item px-3 text-[11px] font-semibold text-blue-300/50 uppercase tracking-widest mb-3">Menu Utama</p>
        
        {{-- Dashboard Link - Active State --}}
        <a href="{{ route('mahasiswa.dashboard') }}" 
           class="sidebar-item menu-item-hover group flex items-center gap-3 px-4 py-3.5 rounded-xl bg-white text-blue-700 font-semibold shadow-lg shadow-blue-900/20 mb-2 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <span class="text-sm">Dashboard</span>
            <div class="ml-auto flex items-center gap-1">
                <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
            </div>
        </a>

        {{-- Profile Link - Memanggil Modal --}}
        <button onclick="openModalLihatDataPribadi()" 
                class="sidebar-item menu-item-hover w-full group flex items-center gap-3 px-4 py-3.5 rounded-xl text-white/90 hover:bg-white/10 hover:text-white mb-2 transition-all duration-300 active:scale-[0.98]">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-all duration-300">
                <svg class="w-5 h-5 text-blue-200 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium">Data Pribadi</span>
            <svg class="w-4 h-4 ml-auto text-blue-300/50 group-hover:text-white/70 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        {{-- Divider --}}
        {{-- <div class="sidebar-item my-5 mx-3 border-t border-white/10"></div> --}}

        {{-- Menu Label --}}
        {{-- <p class="sidebar-item px-3 text-[11px] font-semibold text-blue-300/50 uppercase tracking-widest mb-3">Lainnya</p> --}}

        {{-- Help/Info Link --}}
        {{-- <a href="#" 
           class="sidebar-item menu-item-hover group flex items-center gap-3 px-4 py-3.5 rounded-xl text-white/90 hover:bg-white/10 hover:text-white mb-2 transition-all duration-300 active:scale-[0.98]">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-all duration-300">
                <svg class="w-5 h-5 text-blue-200 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-sm font-medium">Bantuan</span>
            <svg class="w-4 h-4 ml-auto text-blue-300/50 group-hover:text-white/70 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a> --}}

        {{-- Notifications Link --}}
        {{-- <a href="#" 
           class="sidebar-item menu-item-hover group flex items-center gap-3 px-4 py-3.5 rounded-xl text-white/90 hover:bg-white/10 hover:text-white mb-2 transition-all duration-300 active:scale-[0.98]">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-all duration-300 relative">
                <svg class="w-5 h-5 text-blue-200 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-[10px] text-white flex items-center justify-center font-bold shadow-lg">3</span>
            </div>
            <span class="text-sm font-medium">Notifikasi</span>
            <span class="ml-auto px-2 py-0.5 bg-red-500/20 text-red-300 text-xs font-medium rounded-full">Baru</span>
        </a> --}}

    </nav>

    {{-- Logout Button - Fixed at Bottom --}}
    <div class="relative p-4 border-t border-white/10 bg-gradient-to-t from-blue-900/50 to-transparent">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full group flex items-center justify-center gap-3 px-4 py-3.5 rounded-xl bg-white/10 hover:bg-red-500 text-white/90 hover:text-white font-medium transition-all duration-300 hover:shadow-lg hover:shadow-red-500/25 active:scale-[0.98]">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="text-sm">Keluar</span>
            </button>
        </form>
    </div>

</aside>

{{-- Mobile Overlay --}}
<div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm z-30 lg:hidden hidden transition-all duration-300 opacity-0"></div>

{{-- Sidebar Toggle Script --}}
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebarUser');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.remove('opacity-0'), 10);
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 300);
    }
}
</script>