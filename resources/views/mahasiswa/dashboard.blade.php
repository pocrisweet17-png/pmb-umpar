@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">

    {{-- Header --}}
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-10 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">Dashboard PMB</h1>
                        <p class="text-blue-100 text-lg">Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span></p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Card --}}
    <div class="mb-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Progress Pendaftaran</h2>
                    <div class="flex items-center gap-2">
                        @php
                            $completedSteps = collect($steps)->where('completed', true)->count();
                            $totalSteps = count($steps);
                        @endphp
                        <span class="text-sm font-medium text-gray-600">{{ $completedSteps }}/{{ $totalSteps }} Selesai</span>
                    </div>
                </div>

                {{-- Progress Steps Visualization --}}
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        @foreach($steps as $index => $step)
                        <div class="flex flex-col items-center relative z-10" style="flex: 1;">
                            {{-- Circle Indicator --}}
                            <div class="mb-3">
                                @if($step['completed'])
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg transform transition-all duration-300 hover:scale-110">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @elseif($step['enabled'])
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg animate-pulse">
                                        <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center shadow-md">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Step Label --}}
                            <div class="text-center hidden lg:block">
                                <p class="text-xs font-semibold {{ $step['completed'] ? 'text-green-600' : ($step['enabled'] ? 'text-orange-600' : 'text-gray-400') }}">
                                    Step {{ $index + 1 }}
                                </p>
                            </div>
                        </div>

                        {{-- Connecting Line --}}
                        @if($index < count($steps) - 1)
                        <div class="flex-1 h-1 mx-2 relative" style="top: -18px;">
                            <div class="absolute inset-0 bg-gray-200 rounded-full"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 rounded-full transition-all duration-500"
                                 style="width: {{ $steps[$index]['completed'] && $steps[$index + 1]['completed'] ? '100' : ($steps[$index]['completed'] ? '50' : '0') }}%">
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                @if($nextStep)
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600">Langkah Selanjutnya</p>
                            <p class="text-base font-bold text-gray-800">{{ $nextStep['name'] }}</p>
                        </div>
                    </div>
                    @if($nextStep['key'] === 'is_prodi_selected')
                        <button onclick="openModalProdi()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md flex items-center gap-2">
                            Lanjutkan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @else
                        <a href="{{ route($nextStep['route']) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md flex items-center gap-2">
                            Lanjutkan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Steps Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($steps as $index => $step)
        <div class="bg-white rounded-xl shadow-lg border {{ $step['completed'] ? 'border-green-200' : 'border-gray-200' }} overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        @if($step['completed'])
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        @else
                            <div class="w-14 h-14 rounded-xl {{ $step['enabled'] ? 'bg-gradient-to-br from-yellow-400 to-orange-500' : 'bg-gray-300' }} flex items-center justify-center shadow-md">
                                @if($step['enabled'])
                                    <span class="text-white font-bold text-xl">{{ $index + 1 }}</span>
                                @else
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-lg font-bold text-gray-800">{{ $step['name'] }}</h3>
                            @if($step['completed'])
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Selesai
                                </span>
                            @elseif($step['enabled'])
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    In Progress
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terkunci
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-4">
                            @if($step['completed'])
                                Langkah ini sudah selesai. Anda dapat melanjutkan ke langkah berikutnya.
                            @elseif($step['enabled'])
                                Silakan selesaikan langkah ini untuk melanjutkan.
                            @else
                                Selesaikan langkah sebelumnya terlebih dahulu.
                            @endif
                        </p>

                        <div class="flex gap-2">
                            @if($step['completed'])
                                @if($step['key'] === 'is_prodi_selected')
                                    <button onclick="openModalProdi()" class="inline-flex items-center px-4 py-2 bg-white border-2 border-green-500 text-green-700 rounded-lg font-semibold text-sm hover:bg-green-50 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Ubah Pilihan
                                    </button>
                                @else
                                    <a href="{{ route($step['route']) }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-green-500 text-green-700 rounded-lg font-semibold text-sm hover:bg-green-50 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                @endif
                            @elseif($step['enabled'])
                                @if($step['key'] === 'is_prodi_selected')
                                    <button onclick="openModalProdi()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold text-sm hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Pilih Prodi
                                    </button>
                                @else
                                    <a href="{{ route($step['route']) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold text-sm hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105"
                                       onclick="console.log('Navigating to: {{ route($step['route']) }}')">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Lanjutkan
                                    </a>
                                @endif
                            @else
                                <button class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg font-semibold text-sm cursor-not-allowed" disabled>
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terkunci
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Info Footer --}}
    @if($percent == 100)
    <div class="mt-8">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">🎉 Selamat!</h3>
                    <p class="text-gray-700">Anda telah menyelesaikan semua langkah pendaftaran. Selamat bergabung!</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- DEBUG PANEL (only in development) --}}
    @if(config('app.debug'))
    <div class="mt-8">
        <div class="bg-yellow-50 border-2 border-yellow-400 rounded-xl overflow-hidden">
            <div class="bg-yellow-400 px-6 py-3">
                <h3 class="text-lg font-bold text-gray-800">🔧 DEBUG PANEL</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-bold text-gray-800 mb-3">User Status:</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2">
                                <span class="text-gray-600">User ID:</span>
                                <code class="px-2 py-1 bg-gray-200 rounded text-sm">{{ $user->id }}</code>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-gray-600">Prodi Selected:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_prodi_selected ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_prodi_selected ? 'YES' : 'NO' }}
                                </span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-gray-600">Bayar Pendaftaran:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_bayar_pendaftaran ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_bayar_pendaftaran ? 'YES' : 'NO' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 mb-3">Direct Access Test:</h4>
                        <div class="space-y-2">
                            <a href="{{ route('bayar.index') }}" class="block w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-center transition-colors duration-200">
                                Test Bayar Route
                            </a>
                            <a href="{{ route('prodi.view') }}" class="block w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-center transition-colors duration-200">
                                Test Prodi Route
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TEST BUTTON (sementara) --}}
    <div class="mt-6 bg-orange-50 border-l-4 border-orange-400 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="font-bold text-gray-800 mb-1">🔧 TEST NAVIGATION:</h4>
            </div>
            <a href="{{ route('bayar.index') }}" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-sm transition-colors duration-200">
                Direct Link ke Bayar Pendaftaran
            </a>
        </div>
    </div>

</div>

@push('scripts')
<script>
// Debug: Log all step routes
console.group('📍 Route Debug Info');
@foreach($steps as $index => $step)
console.log('Step {{ $index + 1 }}: {{ $step['name'] }}', {
    route: '{{ route($step['route']) }}',
    enabled: {{ $step['enabled'] ? 'true' : 'false' }},
    completed: {{ $step['completed'] ? 'true' : 'false' }}
});
@endforeach
console.groupEnd();

// Debug: User status
console.log('👤 User Status:', {
    id: {{ $user->id }},
    prodi_selected: {{ $user->is_prodi_selected ? 'true' : 'false' }},
    bayar_pendaftaran: {{ $user->is_bayar_pendaftaran ? 'true' : 'false' }}
});
</script>
@endpush
@endsection

{{-- Include Modal Prodi --}}
@include('partials.modals.modal-prodi')
