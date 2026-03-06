@extends('layouts.app')

@section('title', 'Pendaftaran Mahasiswa Baru - PMB UMpar')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8 text-center">
        <h1 class="text-3xl font-bold">FORMULIR PENDAFTARAN MAHASISWA BARU</h1>
        <p class="mt-2 text-blue-100">Tahun Akademik 2025/2026</p>
    </div>

    <div class="p-8">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- 1. DATA PRIBADI -->
            <div class="bg-gray-50 p-6 rounded-lg border">
                <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                    <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">1</span>
                    Data Pribadi
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" value="{{ old('namaLengkap') }}">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="namaLengkap" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Nama anda">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenisKelamin" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" name="tempatLahir" required class="w-full px-4 py-3 border rounded-lg" placeholder="cth: Parepare">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggalLahir" required class="w-full px-4 py-3 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Agama <span class="text-red-500">*</span></label>
                        <select name="agama" required class="w-full px-4 py-3 border rounded-lg">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="noHP" required class="w-full px-4 py-3 border rounded-lg" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="3" required class="w-full px-4 py-3 border rounded-lg" placeholder="Jalan, Kelurahan, Kecamatan, Kota"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="w-full px-4 py-3 border rounded-lg" placeholder="email@contoh.com">
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg border">
                <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                    <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">2</span>
                    Asal Sekolah
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Asal Sekolah <span class="text-red-500">*</span></label>
                        <input type="text" name="asalSekolah" required class="w-full px-4 py-3 border rounded-lg" placeholder="SMA Negeri 1 Parepare">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan <span class="text-red-500">*</span></label>
                        <select name="jurusan" required class="w-full px-4 py-3 border rounded-lg">
                            <option value="">Pilih Jurusan</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="Bahasa">Bahasa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Lulus <span class="text-red-500">*</span></label>
                        <input type="number" name="tahunLulus" required min="2000" max="{{ date('Y')+1 }}" class="w-full px-4 py-3 border rounded-lg" value="{{ date('Y') }}">
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg border">
                <h2 class="text-xl font-semibold text-gray-800 mb-5 flex items-center">
                    <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">3</span>
                    Pilihan Program Studi
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Fakultas <span class="text-red-500">*</span></label>
                        <select id="fakultas" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach(\App\Models\ProgramStudy::select('fakultas')->distinct()->orderBy('fakultas')->get() as $f)
                                <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi <span class="text-red-500">*</span></label>
                        <select name="programStudiPilihan" id="prodi" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Fakultas Dulu --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-center pt-8">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold text-xl py-4 px-16 rounded-full shadow-lg transform hover:scale-105 transition duration-200">
                    DAFTAR SEKARANG
                </button>
                <p class="mt-4 text-sm text-gray-600">
                    Dengan mendaftar, Anda menyetujui syarat dan ketentuan yang berlaku.
                </p>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fakultasSelect = document.getElementById('fakultas');
    const prodiSelect = document.getElementById('prodi');

    fakultasSelect.addEventListener('change', function () {
        const fakultas = this.value;

        if (!fakultas) {
            prodiSelect.innerHTML = '<option value="">-- Pilih Prodi --</option>';
            return;
        }

        fetch(`/api/prodi-by-fakultas/${encodeURIComponent(fakultas)}`)
            .then(response => response.json())
            .then(data => {
                prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
                data.forEach(prodi => {
                    prodiSelect.innerHTML += `<option value="${prodi.kodeProdi}">${prodi.namaProdi} - ${prodi.jenjang}</option>`;
                });
            })
            .catch(() => {
                prodiSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    });
});
</script>
@endsection
