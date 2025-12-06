@extends('admin.layouts.app')

@section('title', 'Edit Soal')
@section('page-title', 'Edit Soal')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

        <!-- Header -->
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 sm:px-8 py-6">
            <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Formulir Edit Soal
            </h3>
            <p class="text-orange-100 mt-1 text-sm">ID Soal: <span class="font-semibold">{{ $soal->idSoal }}</span></p>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Error Notification -->
            @if ($errors->any())
                <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 sm:p-5 rounded-lg shadow-sm" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold text-red-800 mb-2">Terdapat kesalahan:</p>
                            <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-600 ml-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.soal.update', $soal->idSoal) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Question Text -->
                <div>
                    <label class="flex items-center text-gray-800 font-semibold mb-3 text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pertanyaan Soal
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <textarea name="textSoal" required rows="5"
                              placeholder="Masukkan pertanyaan soal di sini..."
                              class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all hover:border-gray-300 resize-none text-sm sm:text-base">{{ old('textSoal', $soal->textSoal) }}</textarea>
                    <p class="text-xs text-gray-500 mt-2">Tuliskan pertanyaan dengan jelas dan mudah dipahami</p>
                </div>

                <!-- Options Grid -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Pilihan Jawaban
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Option A -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Opsi A <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-amber-600">A.</span>
                                <input type="text" name="opsi_a" required value="{{ old('opsi_a', $soal->opsi_a) }}"
                                       placeholder="Isi opsi A"
                                       class="w-full border-2 border-gray-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                            </div>
                        </div>

                        <!-- Option B -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Opsi B <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-amber-600">B.</span>
                                <input type="text" name="opsi_b" required value="{{ old('opsi_b', $soal->opsi_b) }}"
                                       placeholder="Isi opsi B"
                                       class="w-full border-2 border-gray-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                            </div>
                        </div>

                        <!-- Option C -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Opsi C <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-amber-600">C.</span>
                                <input type="text" name="opsi_c" required value="{{ old('opsi_c', $soal->opsi_c) }}"
                                       placeholder="Isi opsi C"
                                       class="w-full border-2 border-gray-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                            </div>
                        </div>

                        <!-- Option D -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2 text-sm">
                                Opsi D <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-amber-600">D.</span>
                                <input type="text" name="opsi_d" required value="{{ old('opsi_d', $soal->opsi_d) }}"
                                       placeholder="Isi opsi D"
                                       class="w-full border-2 border-gray-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all hover:border-gray-300 text-sm sm:text-base">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Correct Answer -->
                <div class="bg-green-50 rounded-xl p-4 sm:p-6 border-2 border-green-200">
                    <label class="flex items-center text-gray-800 font-semibold mb-3 text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jawaban Benar
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <select name="jawabanBenar" required
                            class="w-full border-2 border-green-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white font-medium text-sm sm:text-base">
                        <option value="a" {{ old('jawabanBenar', $soal->jawabanBenar) == 'a' ? 'selected' : '' }}>A</option>
                        <option value="b" {{ old('jawabanBenar', $soal->jawabanBenar) == 'b' ? 'selected' : '' }}>B</option>
                        <option value="c" {{ old('jawabanBenar', $soal->jawabanBenar) == 'c' ? 'selected' : '' }}>C</option>
                        <option value="d" {{ old('jawabanBenar', $soal->jawabanBenar) == 'd' ? 'selected' : '' }}>D</option>
                    </select>
                    <p class="text-xs text-green-700 mt-2 flex items-start">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pastikan memilih opsi yang benar sesuai dengan kunci jawaban
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-amber-500/30 hover:shadow-xl hover:shadow-amber-500/40 hover:from-amber-600 hover:to-orange-700 transition-all duration-200 flex items-center justify-center group text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Update Soal
                    </button>
                    <a href="{{ route('admin.soal.index') }}"
                       class="flex-1 bg-gray-500 text-white font-semibold py-3.5 rounded-xl shadow-lg hover:bg-gray-600 hover:shadow-xl transition-all duration-200 flex items-center justify-center group text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
