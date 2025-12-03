<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-xl bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Soal Baru</h1>

        <!-- Notifikasi sukses -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form tambah soal -->
        <form action="{{ route('admin.soal.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-1">Soal:</label>
                <textarea name="textSoal" required
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Opsi A:</label>
                <input type="text" name="opsi_a" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Opsi B:</label>
                <input type="text" name="opsi_b" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Opsi C:</label>
                <input type="text" name="opsi_c" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Opsi D:</label>
                <input type="text" name="opsi_d" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Jawaban Benar:</label>
                <select name="jawabanBenar" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-2 rounded shadow hover:bg-blue-700 transition">
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>

</body>
</html>
