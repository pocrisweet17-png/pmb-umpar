@extends('admin.layouts.app')

@section('title', 'Edit Pertanyaan Wawancara')
@section('page-title', 'Edit Pertanyaan Wawancara')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.wawancara.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Edit Pertanyaan</h3>
        </div>

        <form action="{{ route('admin.wawancara.update', $pertanyaan->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Pertanyaan -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea name="pertanyaan" 
                          rows="3" 
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                          placeholder="Masukkan pertanyaan wawancara...">{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>
                @error('pertanyaan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Opsi Jawaban -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Opsi A -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Opsi A <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="opsi_a" 
                           value="{{ old('opsi_a', $pertanyaan->opsi_a) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Jawaban A">
                    @error('opsi_a')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opsi B -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Opsi B <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="opsi_b" 
                           value="{{ old('opsi_b', $pertanyaan->opsi_b) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Jawaban B">
                    @error('opsi_b')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opsi C -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Opsi C <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="opsi_c" 
                           value="{{ old('opsi_c', $pertanyaan->opsi_c) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Jawaban C">
                    @error('opsi_c')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opsi D -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Opsi D <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="opsi_d" 
                           value="{{ old('opsi_d', $pertanyaan->opsi_d) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Jawaban D">
                    @error('opsi_d')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

  

            <!-- Status -->
            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $pertanyaan->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm font-bold text-gray-700">Aktifkan pertanyaan ini</span>
                </label>
                <p class="mt-1 ml-8 text-xs text-gray-500">Pertanyaan yang aktif akan ditampilkan saat wawancara</p>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Pertanyaan
                </button>
                
                <a href="{{ route('admin.wawancara.index') }}" 
                   class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection