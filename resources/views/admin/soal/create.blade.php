@extends('admin.layouts.app')

@section('title', 'Tambah Soal')
@section('page-title', 'Tambah Soal Baru')

@section('content')
<div class="max-w-3xl">

    <div class="bg-white shadow rounded-lg p-8">
        <!-- Notifikasi error -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                <p class="font-medium mb-2">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form tambah soal -->
        <form action="{{ route('admin.soal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Soal <span class="text-red-500">*</span></label>
                <textarea name="textSoal" required rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('textSoal') }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Gambar Soal (Opsional)</label>
                <input type="file" name="gambar_soal" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       onchange="previewImage(event)">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
                
                <!-- Preview Image -->
                <div id="imagePreview" class="mt-3 hidden">
                    <img id="preview" class="max-w-xs rounded-lg shadow-md" alt="Preview">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Opsi A <span class="text-red-500">*</span></label>
                    <input type="text" name="opsi_a" required value="{{ old('opsi_a') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Opsi B <span class="text-red-500">*</span></label>
                    <input type="text" name="opsi_b" required value="{{ old('opsi_b') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Opsi C <span class="text-red-500">*</span></label>
                    <input type="text" name="opsi_c" required value="{{ old('opsi_c') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Opsi D <span class="text-red-500">*</span></label>
                    <input type="text" name="opsi_d" required value="{{ old('opsi_d') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Jawaban Benar <span class="text-red-500">*</span></label>
                <select name="jawabanBenar" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Pilih Jawaban --</option>
                    <option value="a" {{ old('jawabanBenar') == 'a' ? 'selected' : '' }}>A</option>
                    <option value="b" {{ old('jawabanBenar') == 'b' ? 'selected' : '' }}>B</option>
                    <option value="c" {{ old('jawabanBenar') == 'c' ? 'selected' : '' }}>C</option>
                    <option value="d" {{ old('jawabanBenar') == 'd' ? 'selected' : '' }}>D</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-blue-700 transition">
                    Simpan Soal
                </button>
                <a href="{{ route('admin.soal.index') }}"
                   class="flex-1 bg-gray-500 text-white font-semibold py-3 rounded-lg shadow hover:bg-gray-600 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
    @push('scripts')
    <script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
        }
    }
    </script>
    @endpush
@endsection
