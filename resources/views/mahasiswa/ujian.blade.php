<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ujian</title>
     @vite('resources/css/app.css')
</head>
<body>
<div class="container mx-auto p-4 my-6">
    <h2 class="text-lg font-bold text-center mb-10">Ujian</h2>
    <form class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-300">
        <!-- Header / Judul Soal -->
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Soal 1: Contoh Judul Soal</h2>

        <!-- Pertanyaan -->
        <p class="text-gray-700 mb-4">
            Ini adalah contoh pertanyaan. Silakan diganti dengan pertanyaan asli dari database.
        </p>

        <!-- Pilihan jawaban (radio) -->
        <div class="space-y-3 mb-4">
            <label class="flex items-center space-x-3">
                <input type="radio" name="jawaban1" value="A" class="form-radio text-indigo-600">
                <span class="text-gray-700">Pilihan A</span>
            </label>
            <label class="flex items-center space-x-3">
                <input type="radio" name="jawaban1" value="B" class="form-radio text-indigo-600">
                <span class="text-gray-700">Pilihan B</span>
            </label>
            <label class="flex items-center space-x-3">
                <input type="radio" name="jawaban1" value="C" class="form-radio text-indigo-600">
                <span class="text-gray-700">Pilihan C</span>
            </label>
            <label class="flex items-center space-x-3">
                <input type="radio" name="jawaban1" value="D" class="form-radio text-indigo-600">
                <span class="text-gray-700">Pilihan D</span>
            </label>
        </div>

        <!-- Button submit untuk soal ini -->
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors">
            Jawab Soal
        </button>
    </form>
</div>



</body>
</html>
