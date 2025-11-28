<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>PMB UMPAR</title>

</head>
<body>
<div class="max-w-3xl mx-auto bg-white p-8 shadow-lg rounded-lg mt-10">

    <h2 class="text-2xl font-bold mb-6">Upload Dokumen Pendaftaran</h2>

    @if(session('success'))
        <div class="p-4 bg-green-200 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-200 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h3 class="font-semibold mb-3">Dokumen yang Diunggah</h3>

        <div class="mb-4">
            <label class="font-semibold">Fotokopi Ijazah SMA/SMK/MA (PDF)</label>
            <input type="file" name="dokumen[ijazah]" accept="application/pdf" class="mt-1 w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Fotokopi Nilai UN (PDF)</label>
            <input type="file" name="dokumen[nilai_un]" accept="application/pdf" class="mt-1 w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Fotokopi Akta Kelahiran (PDF)</label>
            <input type="file" name="dokumen[akta]" accept="application/pdf" class="mt-1 w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Fotokopi Kartu Keluarga (PDF)</label>
            <input type="file" name="dokumen[kk]" accept="application/pdf" class="mt-1 w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Pas Foto (JPEG)</label>
            <input type="file" name="dokumen[pas_foto]" accept="image/jpeg" class="mt-1 w-full border rounded p-2">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700">
            Upload Dokumen
        </button>
    </form>
</div>
</body>
</html>