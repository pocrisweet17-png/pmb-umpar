<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageContent;
use App\Models\ProgramStudy;
use Illuminate\Support\Facades\Storage;

class LandingPageContentController extends Controller
{
    public function index()
    {
        $sections = [
            'site_settings' => LandingPageContent::getSection('site_settings'),
            'hero'          => LandingPageContent::getSection('hero'),
            'stats'         => LandingPageContent::getSection('stats'),
            'features'      => LandingPageContent::getSection('features'),
            'programs'      => LandingPageContent::getSection('programs'),
            'timeline'      => LandingPageContent::getSection('timeline'),
            'testimonials'  => LandingPageContent::getSection('testimonials'),
            'news'          => LandingPageContent::getSection('news'),
            'cta'           => LandingPageContent::getSection('cta'),
            'footer'        => LandingPageContent::getSection('footer'),
        ];

        $allProdi = ProgramStudy::all();

        // Parse news section menjadi list yang dinamis
        $newsList = [];
        foreach ($sections['news'] as $key => $value) {
            if (preg_match('/^news(\d+)_title$/', $key, $matches)) {
                $newsList[(int)$matches[1]]['title'] = $value;
            } elseif (preg_match('/^news(\d+)_(.+)$/', $key, $matches)) {
                $newsList[(int)$matches[1]][$matches[2]] = $value;
            }
        }
        ksort($newsList);

        return view('admin.landing-page.index', compact('sections', 'allProdi', 'newsList'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'updates' => 'required|array',
        ]);

        if ($request->hasFile('updates')) {
            foreach ($request->file('updates') as $key => $file) {
                if (strpos($key, 'video') !== false) {
                    $request->validate(["updates.{$key}" => 'mimes:mp4,mov,avi,wmv|max:51200']);
                } else {
                    $request->validate(["updates.{$key}" => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120']);
                }
            }
        }

        foreach ($request->updates as $key => $value) {
            if ($request->hasFile("updates.{$key}")) {
                $file = $request->file("updates.{$key}");
                $this->deleteOldFile($request->section, $key);
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path     = $file->storeAs('landing-page', $filename, 'public');
                $value    = $path;
            }

            LandingPageContent::setContent(
                $request->section,
                $key,
                $value,
                $this->detectType($value)
            );
        }

        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', 'Konten berhasil diperbarui!');
    }

    // =========================================================
    //  PROGRAM CARDS
    // =========================================================

    public function addProgramCard(Request $request)
    {
        $request->validate([
            'kode_prodi'  => 'required|exists:program_studis,kodeProdi',
            'category'    => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'info_url'    => 'nullable|url',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $prodi    = ProgramStudy::where('kodeProdi', $request->kode_prodi)->first();
        $filename = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
        $imagePath = $request->file('image')->storeAs('landing-page/programs', $filename, 'public');

        $existingIndexes = LandingPageContent::where('section', 'programs')
            ->where('key', 'LIKE', 'program%_title')
            ->pluck('key')
            ->map(fn($k) => (int) preg_replace('/\D/', '', $k))
            ->toArray();

        $newIndex = empty($existingIndexes) ? 1 : (max($existingIndexes) + 1);

        LandingPageContent::setContent('programs', "program{$newIndex}_title",     $prodi->namaProdi,           'text');
        LandingPageContent::setContent('programs', "program{$newIndex}_kode_prodi",$prodi->kodeProdi,           'text');
        LandingPageContent::setContent('programs', "program{$newIndex}_category",  $request->category,          'text');
        LandingPageContent::setContent('programs', "program{$newIndex}_desc",      $request->description,       'text');
        LandingPageContent::setContent('programs', "program{$newIndex}_image",     $imagePath,                  'image');
        LandingPageContent::setContent('programs', "program{$newIndex}_info_url",  $request->info_url ?? '#',   'text');

        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', 'Program berhasil ditambahkan!');
    }

    public function deleteProgramCard($index)
    {
        $keys = [
            "program{$index}_title",
            "program{$index}_kode_prodi",
            "program{$index}_category",
            "program{$index}_desc",
            "program{$index}_image",
            "program{$index}_info_url",
        ];

        foreach ($keys as $key) {
            $content = LandingPageContent::where('section', 'programs')->where('key', $key)->first();
            if ($content) {
                if ($content->type === 'image' && Storage::disk('public')->exists($content->value)) {
                    Storage::disk('public')->delete($content->value);
                }
                $content->delete();
            }
        }

        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', 'Program berhasil dihapus!');
    }

    // =========================================================
    //  NEWS CARDS  (dinamis, bisa lebih dari 3)
    // =========================================================

    public function addNewsCard(Request $request)
    {
        $request->validate([
            'news_title'    => 'required|string|max:255',
            'news_category' => 'required|string|max:100',
            'news_date'     => 'required|string|max:100',
            'news_desc'     => 'required|string|max:1000',
            'news_content'  => 'nullable|string',          // ← baru: konten lengkap
            'news_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
     
        // Cari index tertinggi supaya tidak bentrok
        $existingIndexes = LandingPageContent::where('section', 'news')
            ->where('key', 'LIKE', 'news%_title')
            ->pluck('key')
            ->map(function ($key) {
                preg_match('/^news(\d+)_title$/', $key, $m);
                return isset($m[1]) ? (int) $m[1] : 0;
            })
            ->filter()
            ->toArray();
     
        $newIndex = empty($existingIndexes) ? 1 : (max($existingIndexes) + 1);
     
        // Upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('news_image')) {
            $filename  = time() . '_' . uniqid() . '.' . $request->file('news_image')->getClientOriginalExtension();
            $imagePath = $request->file('news_image')->storeAs('landing-page/news', $filename, 'public');
        }
     
        LandingPageContent::setContent('news', "news{$newIndex}_title",    $request->news_title,              'text');
        LandingPageContent::setContent('news', "news{$newIndex}_category", $request->news_category,            'text');
        LandingPageContent::setContent('news', "news{$newIndex}_date",     $request->news_date,                'text');
        LandingPageContent::setContent('news', "news{$newIndex}_desc",     $request->news_desc,                'text');
        LandingPageContent::setContent('news', "news{$newIndex}_content",  $request->news_content ?? '',       'text'); // ← baru
     
        if ($imagePath) {
            LandingPageContent::setContent('news', "news{$newIndex}_image", $imagePath, 'image');
        }
     
        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }
     
    // ── updateNewsCard() ──────────────────────────────────────
    public function updateNewsCard(Request $request, $index)
    {
        $request->validate([
            'news_title'    => 'required|string|max:255',
            'news_category' => 'required|string|max:100',
            'news_date'     => 'required|string|max:100',
            'news_desc'     => 'required|string|max:1000',
            'news_content'  => 'nullable|string',          // ← baru: konten lengkap
            'news_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
     
        LandingPageContent::setContent('news', "news{$index}_title",    $request->news_title,        'text');
        LandingPageContent::setContent('news', "news{$index}_category", $request->news_category,      'text');
        LandingPageContent::setContent('news', "news{$index}_date",     $request->news_date,          'text');
        LandingPageContent::setContent('news', "news{$index}_desc",     $request->news_desc,          'text');
        LandingPageContent::setContent('news', "news{$index}_content",  $request->news_content ?? '', 'text'); // ← baru
     
        if ($request->hasFile('news_image')) {
            $this->deleteOldFile('news', "news{$index}_image");
            $filename  = time() . '_' . uniqid() . '.' . $request->file('news_image')->getClientOriginalExtension();
            $imagePath = $request->file('news_image')->storeAs('landing-page/news', $filename, 'public');
            LandingPageContent::setContent('news', "news{$index}_image", $imagePath, 'image');
        }
     
        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }
     
    // ── deleteNewsCard() — tidak berubah, tapi sekarang juga hapus _content ──
    public function deleteNewsCard($index)
    {
        $keys = [
            "news{$index}_title",
            "news{$index}_category",
            "news{$index}_date",
            "news{$index}_desc",
            "news{$index}_content",   // ← baru: ikut dihapus
            "news{$index}_image",
        ];
     
        foreach ($keys as $key) {
            $content = LandingPageContent::where('section', 'news')->where('key', $key)->first();
            if ($content) {
                if ($content->type === 'image' && Storage::disk('public')->exists($content->value)) {
                    Storage::disk('public')->delete($content->value);
                }
                $content->delete();
            }
        }
     
        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
     
    // ── showNews() — update untuk ambil news_content ──────────
    public function showNews($index)
    {
        $index = (int) $index;
     
        $title    = LandingPageContent::getContent('news', "news{$index}_title");
        $category = LandingPageContent::getContent('news', "news{$index}_category");
        $date     = LandingPageContent::getContent('news', "news{$index}_date");
        $desc     = LandingPageContent::getContent('news', "news{$index}_desc");
        $content  = LandingPageContent::getContent('news', "news{$index}_content"); // ← baru
        $image    = LandingPageContent::getContent('news', "news{$index}_image");
     
        if (empty($title)) {
            abort(404, 'Berita tidak ditemukan.');
        }
     
        $newsItem = [
            'index'   => $index,
            'title'   => $title,
            'category'=> $category,
            'date'    => $date,
            'desc'    => $desc,
            'content' => $content,  // ← baru
            'image'   => $image,
        ];
     
        // Sidebar — semua berita kecuali yang sedang dibuka
        $allNews  = LandingPageContent::getSection('news');
        $newsList = [];
        foreach ($allNews as $key => $value) {
            if (preg_match('/^news(\d+)_title$/', $key, $m)) {
                $newsList[(int)$m[1]]['title'] = $value;
            } elseif (preg_match('/^news(\d+)_(.+)$/', $key, $m)) {
                $newsList[(int)$m[1]][$m[2]] = $value;
            }
        }
        ksort($newsList);
        unset($newsList[$index]);
     
        $siteSettings = LandingPageContent::getSection('site_settings');
     
        return view('news.show', compact('newsItem', 'newsList', 'siteSettings'));
    }

    // =========================================================
    //  IMAGE / MEDIA HELPERS
    // =========================================================

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'section' => 'required|string',
            'key'     => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteOldFile($request->section, $request->key);
            $file     = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('landing-page', $filename, 'public');

            LandingPageContent::setContent($request->section, $request->key, $path, 'image');

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diupload',
                'path'    => Storage::url($path),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Upload gagal'], 400);
    }

    public function deleteContent(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'key'     => 'required|string',
        ]);

        $content = LandingPageContent::where('section', $request->section)
            ->where('key', $request->key)
            ->first();

        if ($content) {
            if (in_array($content->type, ['image', 'video']) && Storage::disk('public')->exists($content->value)) {
                Storage::disk('public')->delete($content->value);
            }
            $content->delete();

            return response()->json(['success' => true, 'message' => 'Konten berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan'], 404);
    }

    // =========================================================
    //  BROSUR
    // =========================================================

    public function uploadBrosur(Request $request)
    {
        $request->validate([
            'brosur_images'      => 'required|array|min:1',
            'brosur_images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'brosur_title'       => 'required|string|max:255',
            'brosur_description' => 'nullable|string|max:500',
        ], [
            'brosur_images.required'  => 'Pilih minimal 1 gambar brosur.',
            'brosur_images.*.image'   => 'File harus berupa gambar.',
            'brosur_images.*.mimes'   => 'Format gambar harus JPG, PNG, atau WebP.',
            'brosur_images.*.max'     => 'Ukuran setiap gambar maksimal 5MB.',
        ]);

        $existing = LandingPageContent::where('section', 'brosur')
            ->where('key', 'brosur_images')->first();
        $existingImages = ($existing && $existing->value) ? json_decode($existing->value, true) : [];

        $newImages = [];
        foreach ($request->file('brosur_images') as $file) {
            $filename    = 'brosur_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path        = $file->storeAs('landing-page/brosur', $filename, 'public');
            $newImages[] = $path;
        }

        $allImages = array_merge($existingImages, $newImages);

        LandingPageContent::setContent('brosur', 'brosur_images',     json_encode($allImages),            'json');
        LandingPageContent::setContent('brosur', 'brosur_title',      $request->brosur_title,             'text');
        LandingPageContent::setContent('brosur', 'brosur_description',$request->brosur_description ?? '', 'text');
        LandingPageContent::setContent('brosur', 'brosur_uploaded_at',now()->toDateTimeString(),           'text');

        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', count($newImages) . ' gambar brosur berhasil diupload!');
    }

    public function deleteBrosurImage(Request $request, $index)
    {
        $existing = LandingPageContent::where('section', 'brosur')
            ->where('key', 'brosur_images')->first();

        if (!$existing) {
            return redirect()->route('admin.landing-page.index')->with('error', 'Data brosur tidak ditemukan.');
        }

        $images = json_decode($existing->value, true) ?? [];
        if (!isset($images[$index])) {
            return redirect()->route('admin.landing-page.index')->with('error', 'Gambar tidak ditemukan.');
        }

        if (Storage::disk('public')->exists($images[$index])) {
            Storage::disk('public')->delete($images[$index]);
        }

        array_splice($images, $index, 1);

        if (empty($images)) {
            LandingPageContent::where('section', 'brosur')->delete();
        } else {
            $existing->value = json_encode(array_values($images));
            $existing->save();
        }

        return redirect()->route('admin.landing-page.index')->with('success', 'Gambar brosur berhasil dihapus!');
    }

    public function deleteBrosur()
    {
        $existing = LandingPageContent::where('section', 'brosur')
            ->where('key', 'brosur_images')->first();

        if ($existing) {
            $images = json_decode($existing->value, true) ?? [];
            foreach ($images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        LandingPageContent::where('section', 'brosur')->delete();

        return redirect()->route('admin.landing-page.index')->with('success', 'Semua gambar brosur berhasil dihapus!');
    }

    public function downloadBrosur(Request $request, $index = 0)
    {
        $existing = LandingPageContent::where('section', 'brosur')
            ->where('key', 'brosur_images')->first();

        if (!$existing) abort(404, 'Brosur tidak ditemukan');

        $images = json_decode($existing->value, true) ?? [];
        if (!isset($images[$index])) abort(404, 'Gambar tidak ditemukan');

        $path = $images[$index];
        if (!Storage::disk('public')->exists($path)) abort(404, 'File tidak ditemukan');

        $titleRow  = LandingPageContent::where('section', 'brosur')->where('key', 'brosur_title')->first();
        $titleSlug = $titleRow ? \Str::slug($titleRow->value) : 'brosur-pmb';
        $ext       = pathinfo($path, PATHINFO_EXTENSION);
        $filename  = $titleSlug . '-' . ($index + 1) . '.' . $ext;

        return Storage::disk('public')->download($path, $filename);
    }

    // =========================================================
    //  PRIVATE HELPERS
    // =========================================================

    private function deleteOldFile($section, $key)
    {
        $oldContent = LandingPageContent::where('section', $section)->where('key', $key)->first();
        if ($oldContent && in_array($oldContent->type, ['image', 'video'])) {
            if (Storage::disk('public')->exists($oldContent->value)) {
                Storage::disk('public')->delete($oldContent->value);
            }
        }
    }

    private function detectType($value)
    {
        if (is_array($value) || (is_string($value) && $this->isJson($value))) {
            return 'json';
        }

        if (is_string($value) && strpos($value, 'landing-page/') === 0) {
            $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
            if (in_array($ext, ['mp4', 'mov', 'avi', 'wmv', 'webm'])) return 'video';
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) return 'image';
        }

        return 'text';
    }

    private function isJson($string)
    {
        if (!is_string($string)) return false;
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}