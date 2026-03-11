@extends('admin.layouts.app')

@section('title', 'Kelola Landing Page')
@section('page-title', 'Kelola Landing Page')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Tab Navigation -->
    <div x-data="{ activeTab: 'hero' }" class="bg-white rounded-2xl shadow-lg border border-gray-100">
        
        <!-- Tab Headers -->
        <div class="border-b border-gray-200">
            <nav class="flex flex-wrap gap-2 p-4" aria-label="Tabs">
                <button @click="activeTab = 'hero'" 
                        :class="activeTab === 'hero' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all">
                    Hero Section
                </button>
                <button @click="activeTab = 'stats'" 
                        :class="activeTab === 'stats' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all">
                    Statistik
                </button>
                <button @click="activeTab = 'features'" 
                        :class="activeTab === 'features' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all">
                    Keunggulan
                </button>
                <button @click="activeTab = 'programs'" 
                        :class="activeTab === 'programs' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all">
                    Program Studi
                </button>
                <button @click="activeTab = 'testimonials'" 
                        :class="activeTab === 'testimonials' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all">
                    Brosur
                </button>
                <button @click="activeTab = 'news'" 
                        :class="activeTab === 'news' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all">
                    Berita
                </button>
                <button @click="activeTab = 'footer'" 
                        :class="activeTab === 'footer' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all">
                    Footer
                </button>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div class="p-6">

            <!-- HERO SECTION -->
            <div x-show="activeTab === 'hero'" x-cloak>
                <form action="{{ route('admin.landing-page.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="hero">
                    
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Hero Section</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                                <input type="text" name="updates[badge_text]" 
                                       value="{{ $sections['hero']['badge_text'] ?? 'Pendaftaran Gelombang 1 Dibuka' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Utama Baris 1</label>
                                <input type="text" name="updates[title_line1]" 
                                       value="{{ $sections['hero']['title_line1'] ?? 'Wujudkan' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Utama Baris 2</label>
                                <input type="text" name="updates[title_line2]" 
                                       value="{{ $sections['hero']['title_line2'] ?? 'Masa Depanmu' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Utama Baris 3 (Gradient)</label>
                                <input type="text" name="updates[title_line3]" 
                                       value="{{ $sections['hero']['title_line3'] ?? 'Bersama UMPAR' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Hero</label>
                            <textarea name="updates[description]" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $sections['hero']['description'] ?? 'Universitas Muhammadiyah Parepare - Kampus dengan akreditasi unggulan, nilai-nilai Islami, dan jaringan industri terluas di Sulawesi Selatan.' }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tombol CTA Utama</label>
                                <input type="text" name="updates[cta_button_text]" 
                                       value="{{ $sections['hero']['cta_button_text'] ?? 'DAFTAR SEKARANG' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tombol CTA Sekunder</label>
                                <input type="text" name="updates[cta_secondary_text]" 
                                       value="{{ $sections['hero']['cta_secondary_text'] ?? 'INFO LEBIH LANJUT' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Card Title</label>
                                <input type="text" name="updates[card_title]" 
                                       value="{{ $sections['hero']['card_title'] ?? 'Pendaftaran Mahasiswa Baru' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Card Subtitle</label>
                                <input type="text" name="updates[card_subtitle]" 
                                       value="{{ $sections['hero']['card_subtitle'] ?? 'Gelombang 1 • 2025/2026' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hero Card Description</label>
                            <textarea name="updates[card_description]" rows="2"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $sections['hero']['card_description'] ?? 'Bergabunglah dengan keluarga besar Muhammadiyah dan raih masa depan gemilang.' }}</textarea>
                        </div>

                        <!-- Hero Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Hero Card</label>
                            @if(isset($sections['hero']['card_image']) && $sections['hero']['card_image'])
                            <div class="mb-2">
                                <img src="{{ Storage::url($sections['hero']['card_image']) }}" alt="Current Hero Image" class="h-32 w-auto rounded-lg object-cover">
                                <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                            </div>
                            @endif
                            <input type="file" name="updates[card_image]" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WebP. Max: 5MB</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- STATS SECTION -->
            <div x-show="activeTab === 'stats'" x-cloak>
                <form action="{{ route('admin.landing-page.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="stats">
                    
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Statistik (Hero)</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3">Stat 1</h4>
                                <div class="space-y-3">
                                    <input type="text" name="updates[stat1_value]" 
                                           value="{{ $sections['stats']['stat1_value'] ?? 'A' }}"
                                           placeholder="Nilai (contoh: A)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <input type="text" name="updates[stat1_label]" 
                                           value="{{ $sections['stats']['stat1_label'] ?? 'Akreditasi' }}"
                                           placeholder="Label"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3">Stat 2</h4>
                                <div class="space-y-3">
                                    <input type="text" name="updates[stat2_value]" 
                                           value="{{ $sections['stats']['stat2_value'] ?? '20+' }}"
                                           placeholder="Nilai (contoh: 20+)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <input type="text" name="updates[stat2_label]" 
                                           value="{{ $sections['stats']['stat2_label'] ?? 'Prodi' }}"
                                           placeholder="Label"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3">Stat 3</h4>
                                <div class="space-y-3">
                                    <input type="text" name="updates[stat3_value]" 
                                           value="{{ $sections['stats']['stat3_value'] ?? '5K+' }}"
                                           placeholder="Nilai (contoh: 5K+)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <input type="text" name="updates[stat3_label]" 
                                           value="{{ $sections['stats']['stat3_label'] ?? 'Alumni' }}"
                                           placeholder="Label"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- FEATURES SECTION -->
            <div x-show="activeTab === 'features'" x-cloak>
                <form action="{{ route('admin.landing-page.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="features">
                    
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Keunggulan UMPAR</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                                <input type="text" name="updates[section_title]" 
                                       value="{{ $sections['features']['section_title'] ?? 'Keunggulan UMPAR' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Section Subtitle</label>
                                <input type="text" name="updates[section_subtitle]" 
                                       value="{{ $sections['features']['section_subtitle'] ?? 'Dengan nilai-nilai Islami dan komitmen pada kualitas, kami siap mencetak generasi unggul.' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Feature 1 -->
                        <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                            <h4 class="font-medium text-green-800 mb-3">Keunggulan 1 - Akreditasi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[feature1_title]" 
                                       value="{{ $sections['features']['feature1_title'] ?? 'Akreditasi Unggul' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[feature1_desc]" 
                                       value="{{ $sections['features']['feature1_desc'] ?? 'Program studi terakreditasi BAN-PT dengan kurikulum terstandar industri.' }}"
                                       placeholder="Deskripsi"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="font-medium text-blue-800 mb-3">Keunggulan 2 - Beasiswa</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[feature2_title]" 
                                       value="{{ $sections['features']['feature2_title'] ?? 'Beasiswa Lengkap' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[feature2_desc]" 
                                       value="{{ $sections['features']['feature2_desc'] ?? 'Berbagai skema beasiswa untuk mahasiswa berprestasi dan kurang mampu.' }}"
                                       placeholder="Deskripsi"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="font-medium text-yellow-800 mb-3">Keunggulan 3 - Islami</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[feature3_title]" 
                                       value="{{ $sections['features']['feature3_title'] ?? 'Nilai Islami' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[feature3_desc]" 
                                       value="{{ $sections['features']['feature3_desc'] ?? 'Pendidikan berbasis nilai-nilai Islam ala Muhammadiyah yang moderat.' }}"
                                       placeholder="Deskripsi"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>

                        <!-- Feature 4 -->
                        <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                            <h4 class="font-medium text-indigo-800 mb-3">Keunggulan 4 - Karir</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[feature4_title]" 
                                       value="{{ $sections['features']['feature4_title'] ?? 'Siap Kerja' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[feature4_desc]" 
                                       value="{{ $sections['features']['feature4_desc'] ?? 'Program magang dan kerja sama industri untuk karier profesional.' }}"
                                       placeholder="Deskripsi"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- PROGRAMS SECTION -->
            <div x-show="activeTab === 'programs'" x-cloak>
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Program Studi Populer</h3>
                        <p class="text-sm text-gray-600 mt-1">Kelola program studi yang ditampilkan di landing page</p>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-500 hover:text-green-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                <!-- Section Title Form -->
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                    <form action="{{ route('admin.landing-page.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="section" value="programs">
                        
                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    Judul Section
                                </label>
                                <input type="text" name="updates[section_title]" 
                                    value="{{ $sections['programs']['section_title'] ?? 'Program Studi' }}"
                                    placeholder="Contoh: Program Studi Unggulan"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            </div>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update
                            </button>
                        </div>
                    </form>
                </div>

                <hr class="border-gray-300">

                <!-- Add New Program Form -->
                <div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 p-6 rounded-2xl border-2 border-green-300 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-green-900">Tambah Program Baru</h4>
                            <p class="text-sm text-green-700">Tambahkan program studi ke landing page</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.landing-page.programs.add') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pilih Program Studi -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    <span class="text-red-500">*</span> Pilih Program Studi
                                </label>
                                <select name="kode_prodi" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white">
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($allProdi as $prodi)
                                        <option value="{{ $prodi->kodeProdi }}">
                                            {{ $prodi->namaProdi }} ({{ $prodi->kodeProdi }}) - {{ $prodi->fakultas }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-600 mt-1">Pilih program studi dari database</p>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    <span class="text-red-500">*</span> Kategori
                                </label>
                                <input type="text" name="category" required 
                                    placeholder="Contoh: Teknologi, Bisnis, Pendidikan"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                <p class="text-xs text-gray-600 mt-1">Badge kategori yang ditampilkan</p>
                            </div>

                            <!-- Link Info -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Link Website Prodi
                                </label>
                                <input type="url" name="info_url" 
                                    placeholder="https://prodi.example.com"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                <p class="text-xs text-gray-600 mt-1">Opsional - Link tombol "Info Lengkap"</p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    <span class="text-red-500">*</span> Deskripsi Singkat
                                </label>
                                <textarea name="description" required rows="3" 
                                        placeholder="Tuliskan deskripsi menarik tentang program studi... (Max 200 karakter)"
                                        maxlength="200"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none"></textarea>
                                <p class="text-xs text-gray-600 mt-1">Deskripsi yang ditampilkan di card program</p>
                            </div>

                            <!-- Upload Gambar -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    <span class="text-red-500">*</span> Gambar Program
                                </label>
                                <div class="flex items-center gap-4">
                                    <div class="flex-1">
                                        <input type="file" name="image" required accept="image/*" id="program-image"
                                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    </div>
                                </div>
                                <div class="flex items-start gap-2 mt-2">
                                    <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="text-xs text-gray-600">
                                        <p><strong>Format:</strong> JPG, PNG, GIF, WebP</p>
                                        <p><strong>Ukuran Maksimal:</strong> 5MB</p>
                                        <p><strong>Dimensi Ideal:</strong> 800x400px (Landscape)</p>
                                    </div>
                                </div>
                                
                                <!-- Image Preview -->
                                <div id="image-preview" class="mt-3 hidden">
                                    <img id="preview-img" class="h-32 w-auto rounded-lg border-2 border-gray-300 shadow-md" alt="Preview">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="md:col-span-2">
                                <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Program ke Landing Page
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <hr class="border-gray-300">

                <!-- Existing Programs List -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xl font-bold text-gray-900">Program yang Sudah Ditambahkan</h4>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                            @php
                                $programCount = 0;
                                foreach($sections['programs'] as $key => $value) {
                                    if (preg_match('/program(\d+)_title/', $key)) {
                                        $programCount++;
                                    }
                                }
                            @endphp
                            {{ $programCount }} Program
                        </span>
                    </div>
                    
                    @php
                        $programs = [];
                        foreach($sections['programs'] as $key => $value) {
                            if (preg_match('/program(\d+)_title/', $key, $matches)) {
                                $index = $matches[1];
                                $programs[$index]['title'] = $value;
                            } elseif (preg_match('/program(\d+)_(.+)/', $key, $matches)) {
                                $index = $matches[1];
                                $field = $matches[2];
                                $programs[$index][$field] = $value;
                            }
                        }
                        ksort($programs);
                    @endphp

                    @if(count($programs) > 0)
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($programs as $index => $program)
                            <div class="bg-white p-5 rounded-xl border-2 border-gray-200 hover:border-blue-400 hover:shadow-lg transition-all">
                                <div class="flex flex-col md:flex-row gap-5">
                                    <!-- Image Preview -->
                                    <div class="flex-shrink-0">
                                        @if(isset($program['image']))
                                        <img src="{{ Storage::url($program['image']) }}" 
                                            alt="{{ $program['title'] ?? 'Program' }}" 
                                            class="w-full md:w-48 h-32 object-cover rounded-lg border-2 border-gray-300 shadow-md">
                                        @else
                                        <div class="w-full md:w-48 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center border-2 border-gray-300">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                                        #{{ $index }}
                                                    </span>
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                                                        {{ $program['category'] ?? 'Kategori' }}
                                                    </span>
                                                </div>
                                                <h5 class="text-xl font-bold text-gray-900 mb-1">
                                                    {{ $program['title'] ?? 'Program ' . $index }}
                                                </h5>
                                                <p class="text-sm text-gray-600 mb-2">
                                                    {{ $program['desc'] ?? '-' }}
                                                </p>
                                                
                                                @if(isset($program['info_url']) && $program['info_url'] !== '#')
                                                <a href="{{ $program['info_url'] }}" target="_blank" 
                                                class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                    </svg>
                                                    {{ Str::limit($program['info_url'], 40) }}
                                                </a>
                                                @else
                                                <span class="text-xs text-gray-400 italic">Tidak ada link website</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.landing-page.programs.delete', $index) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('❌ Yakin ingin menghapus program ini?\n\n{{ $program['title'] ?? 'Program ' . $index }}\n\nData tidak dapat dikembalikan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Edit Form (Collapsible) -->
                                        <div class="mt-4 pt-4 border-t border-gray-200" x-data="{ open: false }">
                                            <button @click="open = !open" 
                                                    class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-semibold">
                                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                                <span x-text="open ? 'Tutup Editor' : 'Edit Program'"></span>
                                            </button>

                                            <form x-show="open" 
                                                x-cloak 
                                                x-transition
                                                action="{{ route('admin.landing-page.update') }}" 
                                                method="POST" 
                                                enctype="multipart/form-data" 
                                                class="mt-4 p-4 bg-gray-50 rounded-lg">
                                                @csrf
                                                <input type="hidden" name="section" value="programs">
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori</label>
                                                        <input type="text" name="updates[program{{ $index }}_category]" 
                                                            value="{{ $program['category'] ?? '' }}"
                                                            placeholder="Teknologi, Bisnis, dll"
                                                            class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Link Website Prodi</label>
                                                        <input type="url" name="updates[program{{ $index }}_info_url]" 
                                                            value="{{ $program['info_url'] ?? '' }}"
                                                            placeholder="https://prodi.example.com"
                                                            class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                    
                                                    <div class="md:col-span-2">
                                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
                                                        <textarea name="updates[program{{ $index }}_desc]" rows="2" 
                                                                placeholder="Deskripsi singkat program..."
                                                                class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none">{{ $program['desc'] ?? '' }}</textarea>
                                                    </div>
                                                    
                                                    <div class="md:col-span-2">
                                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Ganti Gambar (Opsional)</label>
                                                        <input type="file" name="updates[program{{ $index }}_image]" accept="image/*"
                                                            class="w-full px-3 py-2 border-2 border-dashed border-gray-300 rounded-lg text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar</p>
                                                    </div>

                                                    <div class="md:col-span-2 flex gap-2">
                                                        <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm transition-all shadow-md hover:shadow-lg">
                                                            💾 Simpan Perubahan
                                                        </button>
                                                        <button type="button" @click="open = false" class="px-4 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold text-sm transition-all">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-300">
                            <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-lg font-bold text-gray-700 mb-2">Belum ada program yang ditambahkan</p>
                            <p class="text-sm text-gray-500">Gunakan form di atas untuk menambahkan program studi ke landing page</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <script>
        // Image Preview
        document.getElementById('program-image')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
        </script>

            <!-- BROWSUR -->
            <div x-show="activeTab === 'testimonials'" x-cloak>
    <div class="space-y-6">

        {{-- ── Header ──────────────────────────────────────────────── --}}
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Brosur PMB</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Upload foto brosur (ukuran feed IG, 1:1) yang bisa dilihat & didownload calon mahasiswa
                </p>
            </div>
        </div>

        {{-- ── Flash Message ───────────────────────────────────────── --}}
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg"
             x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-500 text-xl leading-none">×</button>
            </div>
        </div>
        @endif

        @php
            $brosurSection  = $sections['brosur'] ?? [];
            $brosurImages   = isset($brosurSection['brosur_images'])
                                ? json_decode($brosurSection['brosur_images'], true)
                                : [];
            $brosurTitle    = $brosurSection['brosur_title']       ?? 'Brosur PMB';
            $brosurDesc     = $brosurSection['brosur_description']  ?? '';
            $uploadedAt     = $brosurSection['brosur_uploaded_at']  ?? null;
            $hasImages      = !empty($brosurImages);
        @endphp

        {{-- ── Current Images Grid ─────────────────────────────────── --}}
        @if($hasImages)
        <div class="bg-white p-6 rounded-2xl border-2 border-blue-200 shadow-sm"
             x-data="{ showAll: false, lightbox: null }">

            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-lg font-bold text-gray-900">{{ $brosurTitle }}</h4>
                    @if($brosurDesc)
                        <p class="text-sm text-gray-500">{{ $brosurDesc }}</p>
                    @endif
                    @if($uploadedAt)
                        <p class="text-xs text-gray-400 mt-1">
                            Terakhir diupload: {{ \Carbon\Carbon::parse($uploadedAt)->format('d M Y, H:i') }}
                        </p>
                    @endif
                </div>

                {{-- Hapus semua --}}
                <form action="{{ route('admin.landing-page.brosur.delete') }}"
                      method="POST"
                      onsubmit="return confirm('Hapus SEMUA gambar brosur?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 border border-red-200
                                   rounded-lg hover:bg-red-100 text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5
                                     4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Semua
                    </button>
                </form>
            </div>

            {{-- Grid gambar --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($brosurImages as $i => $imgPath)
                <div class="relative group {{ $i >= 4 ? 'hidden' : '' }}"
                     :class="{ 'hidden': {{ $i >= 4 ? 'true' : 'false' }} && !showAll }"
                     x-show="{{ $i < 4 ? 'true' : 'showAll' }}">

                    {{-- Square image --}}
                    <div class="relative aspect-square rounded-xl overflow-hidden bg-gray-100 cursor-pointer shadow-sm
                                ring-2 ring-transparent group-hover:ring-blue-400 transition-all"
                         @click="lightbox = '{{ Storage::url($imgPath) }}'">
                        <img src="{{ Storage::url($imgPath) }}"
                             alt="Brosur {{ $i + 1 }}"
                             class="w-full h-full object-cover">

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0
                                         0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>

                        {{-- Badge nomor --}}
                        <span class="absolute top-2 left-2 bg-black/50 text-white text-xs font-bold
                                     px-2 py-0.5 rounded-full">{{ $i + 1 }}</span>
                    </div>

                    {{-- Action bar --}}
                    <div class="flex gap-1 mt-1.5">
                        {{-- Download --}}
                        <a href="{{ route('brosur.download', $i) }}"
                           class="flex-1 flex items-center justify-center gap-1 py-1.5 bg-blue-50 text-blue-600
                                  rounded-lg text-xs font-medium hover:bg-blue-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </a>

                        {{-- Hapus --}}
                        <form action="{{ route('admin.landing-page.brosur.delete-image', $i) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus gambar ini?')"
                              class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-2.5 py-1.5 bg-red-50 text-red-500 rounded-lg hover:bg-red-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Tombol Tampilkan Lebih / Sembunyikan --}}
            @if(count($brosurImages) > 4)
            <div class="mt-4 text-center">
                <button @click="showAll = !showAll"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-700 rounded-lg
                               hover:bg-gray-200 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 transition-transform" :class="showAll ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <span x-text="showAll ? 'Sembunyikan' : 'Tampilkan semua ({{ count($brosurImages) }} gambar)'"></span>
                </button>
            </div>
            @endif

            {{-- Lightbox --}}
            <div x-show="lightbox"
                 x-cloak
                 @click.self="lightbox = null"
                 @keydown.escape.window="lightbox = null"
                 class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="relative max-w-2xl max-h-full">
                    <img :src="lightbox" class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl">
                    <button @click="lightbox = null"
                            class="absolute -top-3 -right-3 w-8 h-8 bg-white rounded-full flex items-center
                                   justify-center text-gray-800 hover:bg-gray-100 shadow-lg text-lg font-bold">
                        ×
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- ── Upload Form ──────────────────────────────────────────── --}}
        <div class="bg-white p-6 rounded-xl border-2 {{ $hasImages ? 'border-gray-200' : 'border-green-300 bg-gradient-to-br from-green-50 to-emerald-50' }}">
            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-{{ $hasImages ? 'gray' : 'green' }}-600"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                {{ $hasImages ? 'Tambah Gambar Brosur' : 'Upload Gambar Brosur' }}
            </h4>

            <form action="{{ route('admin.landing-page.brosur.upload') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  x-data="brosurUpload()">
                @csrf

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">
                                <span class="text-red-500">*</span> Judul Brosur
                            </label>
                            <input type="text" name="brosur_title" required
                                   value="{{ old('brosur_title', $brosurTitle) }}"
                                   placeholder="Contoh: Brosur PMB 2025/2026"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl
                                          focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">
                                Deskripsi (Opsional)
                            </label>
                            <input type="text" name="brosur_description"
                                   value="{{ old('brosur_description', $brosurDesc) }}"
                                   placeholder="Informasi lengkap pendaftaran mahasiswa baru"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl
                                          focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    {{-- Drop zone --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">
                            <span class="text-red-500">*</span> Gambar Brosur
                            <span class="font-normal text-gray-500">(JPG / PNG / WebP, maks 5MB/gambar)</span>
                        </label>

                        <label for="brosur-images-input"
                               class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed
                                      border-gray-300 rounded-xl cursor-pointer hover:border-green-400
                                      hover:bg-green-50 transition-colors bg-white"
                               :class="previews.length ? 'border-green-400 bg-green-50' : ''">
                            <template x-if="previews.length === 0">
                                <div class="text-center">
                                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-2"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586
                                                 a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2
                                                 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm text-gray-600">
                                        Klik atau drag & drop gambar di sini
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">Bisa pilih banyak sekaligus</p>
                                </div>
                            </template>

                            <template x-if="previews.length > 0">
                                <div class="flex items-center gap-2 flex-wrap justify-center p-2">
                                    <template x-for="(src, idx) in previews" :key="idx">
                                        <div class="relative">
                                            <img :src="src" class="w-16 h-16 object-cover rounded-lg shadow">
                                        </div>
                                    </template>
                                    <span class="text-xs text-green-700 font-medium"
                                          x-text="previews.length + ' gambar dipilih'"></span>
                                </div>
                            </template>
                        </label>

                        <input type="file" name="brosur_images[]" id="brosur-images-input"
                               accept="image/jpeg,image/png,image/webp"
                               multiple
                               class="hidden"
                               @change="handleFiles($event)">
                    </div>

                    <button type="submit"
                            class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white
                                   font-bold rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all
                                   shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        {{ $hasImages ? 'Tambah Gambar' : 'Upload Gambar Brosur' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Info Cards ───────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2
                                     0 012.828 0L20 14m-6-6h.01"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-blue-900 text-sm">Format Gambar</p>
                        <p class="text-xs text-blue-700 mt-1">JPG, PNG, atau WebP – ukuran ideal 1:1 (feed IG)</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-green-900 text-sm">Download Publik</p>
                        <p class="text-xs text-green-700 mt-1">Tiap gambar bisa didownload oleh calon mahasiswa</p>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-purple-900 text-sm">Multi Gambar</p>
                        <p class="text-xs text-purple-700 mt-1">Upload banyak gambar sekaligus, hapus per gambar</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function brosurUpload() {
    return {
        previews: [],
        handleFiles(event) {
            const files = Array.from(event.target.files);
            this.previews = [];
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => this.previews.push(e.target.result);
                reader.readAsDataURL(file);
            });
        }
    }
}
</script>

            <!-- NEWS SECTION -->
            <div x-show="activeTab === 'news'" x-cloak>
                <form action="{{ route('admin.landing-page.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="news">
                    
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Berita & Kegiatan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                                <input type="text" name="updates[section_title]" 
                                       value="{{ $sections['news']['section_title'] ?? 'Berita & Kegiatan' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- News 1 -->
                        <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                            <h4 class="font-medium text-green-800 mb-3">Berita 1</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[news1_title]" 
                                       value="{{ $sections['news']['news1_title'] ?? 'Workshop Kewirausahaan Mahasiswa' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[news1_category]" 
                                       value="{{ $sections['news']['news1_category'] ?? 'Kegiatan' }}"
                                       placeholder="Kategori"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[news1_date]" 
                                       value="{{ $sections['news']['news1_date'] ?? '12 November 2025' }}"
                                       placeholder="Tanggal"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[news1_desc]" rows="2" placeholder="Deskripsi"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['news']['news1_desc'] ?? 'Mahasiswa belajar strategi bisnis modern dari praktisi industri.' }}
                                </textarea>
                                <!-- Upload Gambar Berita 1 -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Berita</label>
                                    @if(isset($sections['news']['news1_image']) && $sections['news']['news1_image'])
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($sections['news']['news1_image']) }}" alt="Berita 1" class="h-24 w-auto rounded-lg object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                    </div>
                                    @endif
                                    <input type="file" name="updates[news1_image]" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 5MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- News 2 -->
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="font-medium text-blue-800 mb-3">Berita 2</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[news2_title]" 
                                       value="{{ $sections['news']['news2_title'] ?? 'Penandatanganan MoU Industri' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[news2_category]" 
                                       value="{{ $sections['news']['news2_category'] ?? 'Kerjasama' }}"
                                       placeholder="Kategori"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[news2_date]" 
                                       value="{{ $sections['news']['news2_date'] ?? '2 Oktober 2025' }}"
                                       placeholder="Tanggal"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[news2_desc]" rows="2" placeholder="Deskripsi"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['news']['news2_desc'] ?? 'Penguatan kerja sama riset dan program magang mahasiswa.' }}
                                </textarea>
                                <!-- Upload Gambar Berita 2 -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Berita</label>
                                    @if(isset($sections['news']['news2_image']) && $sections['news']['news2_image'])
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($sections['news']['news2_image']) }}" alt="Berita 2" class="h-24 w-auto rounded-lg object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                    </div>
                                    @endif
                                    <input type="file" name="updates[news2_image]" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 5MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- News 3 -->
                        <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="font-medium text-yellow-800 mb-3">Berita 3</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[news3_title]" 
                                       value="{{ $sections['news']['news3_title'] ?? 'Milad Muhammadiyah ke-113' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[news3_category]" 
                                       value="{{ $sections['news']['news3_category'] ?? 'Milad' }}"
                                       placeholder="Kategori"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[news3_date]" 
                                       value="{{ $sections['news']['news3_date'] ?? '25 September 2025' }}"
                                       placeholder="Tanggal"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[news3_desc]" rows="2" placeholder="Deskripsi"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['news']['news3_desc'] ?? 'Perayaan milad dengan berbagai kegiatan sosial dan keagamaan.' }}
                                </textarea>
                                <!-- Upload Gambar Berita 3 -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Berita</label>
                                    @if(isset($sections['news']['news3_image']) && $sections['news']['news3_image'])
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($sections['news']['news3_image']) }}" alt="Berita 3" class="h-24 w-auto rounded-lg object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                    </div>
                                    @endif
                                    <input type="file" name="updates[news3_image]" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 5MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- FOOTER SECTION -->
            <div x-show="activeTab === 'footer'" x-cloak>
                <form action="{{ route('admin.landing-page.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="footer">
                    
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Informasi Footer</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Footer</label>
                            <textarea name="updates[description]" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $sections['footer']['description'] ?? 'Kampus Muhammadiyah dengan nilai-nilai Islam moderat dan komitmen mencetak generasi unggul.' }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea name="updates[address]" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $sections['footer']['address'] ?? 'Jl. Jenderal Ahmad Yani KM 6, Parepare, Sulawesi Selatan' }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="updates[phone]" 
                                       value="{{ $sections['footer']['phone'] ?? '(0421) 2912 2xxx' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="updates[email]" 
                                       value="{{ $sections['footer']['email'] ?? 'info@umpar.ac.id' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <h4 class="font-medium text-gray-700 pt-4 border-t">Social Media Links</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                                <input type="url" name="updates[facebook_url]" 
                                       value="{{ $sections['footer']['facebook_url'] ?? '#' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                                <input type="url" name="updates[instagram_url]" 
                                       value="{{ $sections['footer']['instagram_url'] ?? '#' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                                <input type="url" name="updates[youtube_url]" 
                                       value="{{ $sections['footer']['youtube_url'] ?? '#' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection