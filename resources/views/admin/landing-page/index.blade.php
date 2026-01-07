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
                    Testimoni
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
                <form action="{{ route('admin.landing-page.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="programs">
                    
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Program Studi Populer</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                                <input type="text" name="updates[section_title]" 
                                       value="{{ $sections['programs']['section_title'] ?? 'Program Studi Populer' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Program 1 -->
                        <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                            <h4 class="font-medium text-green-800 mb-3">Program 1 - Teknik Informatika</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[program1_title]" 
                                       value="{{ $sections['programs']['program1_title'] ?? 'Teknik Informatika' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[program1_category]" 
                                       value="{{ $sections['programs']['program1_category'] ?? 'Teknologi' }}"
                                       placeholder="Kategori"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[program1_desc]" rows="2" placeholder="Deskripsi"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['programs']['program1_desc'] ?? 'Kurikulum terkini, laboratorium lengkap, dan dosen berpengalaman di industri IT.' }}
                                </textarea>
                                <!-- Upload Gambar Program 1 -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Program</label>
                                    @if(isset($sections['programs']['program1_image']) && $sections['programs']['program1_image'])
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($sections['programs']['program1_image']) }}" alt="Program 1" class="h-24 w-auto rounded-lg object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                    </div>
                                    @endif
                                    <input type="file" name="updates[program1_image]" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 5MB. Ukuran ideal: 800x400px</p>
                                </div>
                            </div>
                        </div>

                        <!-- Program 2 -->
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="font-medium text-blue-800 mb-3">Program 2 - Bisnis & Manajemen</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[program2_title]" 
                                       value="{{ $sections['programs']['program2_title'] ?? 'Bisnis & Manajemen' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[program2_category]" 
                                       value="{{ $sections['programs']['program2_category'] ?? 'Bisnis' }}"
                                       placeholder="Kategori"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[program2_desc]" rows="2" placeholder="Deskripsi"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['programs']['program2_desc'] ?? 'Fokus pada kewirausahaan, manajemen, dan keterampilan bisnis modern.' }}
                                </textarea>
                                <!-- Upload Gambar Program 2 -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Program</label>
                                    @if(isset($sections['programs']['program2_image']) && $sections['programs']['program2_image'])
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($sections['programs']['program2_image']) }}" alt="Program 2" class="h-24 w-auto rounded-lg object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                    </div>
                                    @endif
                                    <input type="file" name="updates[program2_image]" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 5MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Program 3 -->
                        <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="font-medium text-yellow-800 mb-3">Program 3 - Pendidikan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[program3_title]" 
                                       value="{{ $sections['programs']['program3_title'] ?? 'Pendidikan & Keguruan' }}"
                                       placeholder="Judul"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[program3_category]" 
                                       value="{{ $sections['programs']['program3_category'] ?? 'Pendidikan' }}"
                                       placeholder="Kategori"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[program3_desc]" rows="2" placeholder="Deskripsi"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['programs']['program3_desc'] ?? 'Mencetak guru profesional dengan nilai-nilai Islam Muhammadiyah.' }}
                                </textarea>
                                <!-- Upload Gambar Program 3 -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Program</label>
                                        @if(isset($sections['programs']['program3_image']) && $sections['programs']['program3_image'])
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($sections['programs']['program3_image']) }}" alt="Program 3" class="h-24 w-auto rounded-lg object-cover">
                                            <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                        </div>
                                        @endif
                                        <input type="file" name="updates[program3_image]" accept="image/*"
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

            <!-- TESTIMONIALS SECTION -->
            <div x-show="activeTab === 'testimonials'" x-cloak>
                <form action="{{ route('admin.landing-page.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="testimonials">
                    
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Testimoni Alumni</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                                <input type="text" name="updates[section_title]" 
                                       value="{{ $sections['testimonials']['section_title'] ?? 'Apa Kata Alumni?' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Section Subtitle</label>
                                <input type="text" name="updates[section_subtitle]" 
                                       value="{{ $sections['testimonials']['section_subtitle'] ?? 'Dengarkan pengalaman dari para alumni dan mahasiswa kami.' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Testimonial 1 -->
                        <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                            <h4 class="font-medium text-green-800 mb-3">Testimoni 1</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[testi1_name]" 
                                       value="{{ $sections['testimonials']['testi1_name'] ?? 'Aulia Rahma' }}"
                                       placeholder="Nama"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[testi1_title]" 
                                       value="{{ $sections['testimonials']['testi1_title'] ?? 'Lulusan TI 2022' }}"
                                       placeholder="Jabatan/Angkatan"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[testi1_content]" rows="2" placeholder="Isi Testimoni"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['testimonials']['testi1_content'] ?? 'UMPAR memberikan pengalaman belajar yang luar biasa dengan nilai-nilai Islami yang kuat. Dosen sangat supportif!' }}
                                </textarea>
                                <!-- Upload Foto Testimoni 1 -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Alumni</label>
                                    @if(isset($sections['testimonials']['testi1_image']) && $sections['testimonials']['testi1_image'])
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($sections['testimonials']['testi1_image']) }}" alt="Foto Alumni 1" class="h-16 w-16 rounded-xl object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                                    </div>
                                    @endif
                                    <input type="file" name="updates[testi1_image]" accept="image/*"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 5MB. Ukuran ideal: 100x100px</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="font-medium text-blue-800 mb-3">Testimoni 2</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[testi2_name]" 
                                       value="{{ $sections['testimonials']['testi2_name'] ?? 'Budi Santoso' }}"
                                       placeholder="Nama"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[testi2_title]" 
                                       value="{{ $sections['testimonials']['testi2_title'] ?? 'Lulusan Bisnis 2021' }}"
                                       placeholder="Jabatan/Angkatan"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[testi2_content]" rows="2" placeholder="Isi Testimoni"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['testimonials']['testi2_content'] ?? 'Program magang membuka kesempatan kerja yang luas. Jaringan alumni Muhammadiyah sangat membantu karier saya.' }}
                                </textarea>
                                <!-- Upload Foto Testimoni 2 -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Alumni</label>
                                        @if(isset($sections['testimonials']['testi2_image']) && $sections['testimonials']['testi2_image'])
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($sections['testimonials']['testi2_image']) }}" alt="Foto Alumni 2" class="h-16 w-16 rounded-xl object-cover">
                                            <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                                        </div>
                                        @endif
                                        <input type="file" name="updates[testi2_image]" accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 5MB</p>
                                    </div>
                            </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="font-medium text-yellow-800 mb-3">Testimoni 3</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="updates[testi3_name]" 
                                       value="{{ $sections['testimonials']['testi3_name'] ?? 'Citra Dewi' }}"
                                       placeholder="Nama"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="updates[testi3_title]" 
                                       value="{{ $sections['testimonials']['testi3_title'] ?? 'Lulusan PGSD 2020' }}"
                                       placeholder="Jabatan/Angkatan"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <textarea name="updates[testi3_content]" rows="2" placeholder="Isi Testimoni"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm md:col-span-2">{{ $sections['testimonials']['testi3_content'] ?? 'Lingkungan kampus yang Islami dan modern membuat saya berkembang pesat sebagai pendidik profesional.' }}
                                </textarea>
                                <!-- Upload Foto Testimoni 3 -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Alumni</label>
                                    @if(isset($sections['testimonials']['testi3_image']) && $sections['testimonials']['testi3_image'])
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($sections['testimonials']['testi3_image']) }}" alt="Foto Alumni 3" class="h-16 w-16 rounded-xl object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                                    </div>
                                    @endif
                                    <input type="file" name="updates[testi3_image]" accept="image/*"
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