<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - PMB UMpar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-3xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header Success -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-8 text-center">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-green-500 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold mb-2">PENDAFTARAN BERHASIL!</h1>
            <p class="text-green-100 text-lg">Selamat, pendaftaran Anda telah berhasil disimpan</p>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Informasi Pendaftar -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                    Informasi Pendaftar
                </h2>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama Lengkap</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $data['nama_lengkap'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nomor Pendaftaran</p>
                        <p class="text-lg font-semibold text-blue-600">{{ $data['nomor_pendaftaran'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Program Studi</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $data['program_studi'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Pendaftaran</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $data['tanggal_daftar'] }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Kode Akses</p>
                        <p class="text-lg font-semibold text-green-600 bg-green-50 p-3 rounded-lg">
                            {{ $data['kode_akses'] }}
                        </p>
                        <p class="text-sm text-gray-500 mt-2">Simpan kode ini untuk mengakses dashboard pendaftaran</p>
                    </div>
                </div>
            </div>

            <!-- Langkah Selanjutnya -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-lg mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-arrow-right text-amber-500 mr-3"></i>
                    Langkah Selanjutnya
                </h2>
                
                <p class="text-gray-700 mb-4">
                    Silakan lengkapi proses pendaftaran dengan mengunggah dokumen-dokumen yang diperlukan. 
                    Dokumen harus diunggah <span class="font-bold text-amber-700">sebelum 7 hari</span> dari tanggal pendaftaran.
                </p>
                
                <div class="space-y-4 mt-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center text-white font-bold mr-4">1</div>
                        <p class="text-gray-700">Unggah dokumen persyaratan</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold mr-4">2</div>
                        <p class="text-gray-500">Verifikasi dokumen oleh panitia (2-3 hari kerja)</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold mr-4">3</div>
                        <p class="text-gray-500">Pembayaran biaya pendaftaran</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold mr-4">4</div>
                        <p class="text-gray-500">Pengumuman hasil seleksi</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col md:flex-row gap-4 mt-10">
                <a href="{{ url('/')}}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-4 px-6 rounded-xl text-center transition duration-200 flex items-center justify-center">
                    <i class="fas fa-home mr-3"></i> Kembali ke Beranda
                </a>
                <a href="{{ route('dokumen.form') }}" class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl text-center transition duration-200 transform hover:scale-105 flex items-center justify-center shadow-lg">
                    <i class="fas fa-upload mr-3"></i> Lanjutkan Upload Dokumen
                </a>
            </div>
            
            <!-- Catatan -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-sm text-blue-800 flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                    <span>
                        <strong>Catatan:</strong> Simpan nomor pendaftaran dan kode akses Anda dengan baik. 
                        Data ini akan digunakan untuk semua proses selanjutnya. Jika mengalami kendala, 
                        hubungi panitia PMB di <span class="font-semibold">0812-3456-7890</span>.
                    </span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>