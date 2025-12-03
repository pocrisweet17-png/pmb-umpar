<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Soal</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Soal</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Soal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi A</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi B</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi C</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi D</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jawaban Benar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($soals as $soal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $soal->idSoal }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $soal->textSoal }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $soal->opsi_a }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $soal->opsi_b }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $soal->opsi_c }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $soal->opsi_d }}</td>
                            <td class="px-4 py-2 text-sm font-semibold text-green-600">{{ $soal->jawabanBenar }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.soal.create') }}"
               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md shadow hover:bg-blue-700 transition">
               Tambah Soal Baru
            </a>
        </div>
    </div>

</body>
</html>
