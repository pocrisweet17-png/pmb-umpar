<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPageContent;
use Illuminate\Support\Facades\Storage;

class LandingPageContentController extends Controller
{
    public function index()
    {
        $sections = [
            'site_settings' => LandingPageContent::getSection('site_settings'),
            'hero' => LandingPageContent::getSection('hero'),
            'stats' => LandingPageContent::getSection('stats'),
            'features' => LandingPageContent::getSection('features'),
            'programs' => LandingPageContent::getSection('programs'),
            'timeline' => LandingPageContent::getSection('timeline'),
            'testimonials' => LandingPageContent::getSection('testimonials'),
            'news' => LandingPageContent::getSection('news'),
            'cta' => LandingPageContent::getSection('cta'),
            'footer' => LandingPageContent::getSection('footer'),
        ];

        return view('admin.landing-page.index', compact('sections'));
    }

public function update(Request $request)
{
    $request->validate([
        'section' => 'required|string',
        'updates' => 'required|array',
    ]);

    // Validasi file secara manual
    if ($request->hasFile('updates')) {
        foreach ($request->file('updates') as $key => $file) {
            if (strpos($key, 'video') !== false) {
                $request->validate([
                    "updates.{$key}" => 'mimes:mp4,mov,avi,wmv|max:51200'
                ]);
            } else {
                $request->validate([
                    "updates.{$key}" => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
                ]);
            }
        }
    }

    foreach ($request->updates as $key => $value) {
        // Handle file upload untuk gambar dan video
        if ($request->hasFile("updates.{$key}")) {
            $file = $request->file("updates.{$key}");
            
            // Hapus file lama jika ada
            $this->deleteOldFile($request->section, $key);
            
            // Upload file baru
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('landing-page', $filename, 'public');
            $value = $path;
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

    /**
     * Validasi file berdasarkan key
     */
    private function validateFile($file, $key)
    {
        // Validasi untuk video
        if (strpos($key, 'video') !== false) {
            $file->validate([
                'mimes:mp4,mov,avi,wmv',
                'max:51200' // 50MB
            ]);
        } 
        // Validasi untuk gambar
        else {
            $file->validate([
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120' // 5MB
            ]);
        }
    }

    /**
     * Hapus file lama dari storage
     */
    private function deleteOldFile($section, $key)
    {
        $oldContent = LandingPageContent::where('section', $section)
                                       ->where('key', $key)
                                       ->first();
        
        if ($oldContent && in_array($oldContent->type, ['image', 'video'])) {
            // Cek apakah file ada di storage
            if (Storage::disk('public')->exists($oldContent->value)) {
                Storage::disk('public')->delete($oldContent->value);
            }
        }
    }

    /**
     * Deteksi tipe konten
     */
    private function detectType($value)
    {
        if (is_array($value) || (is_string($value) && $this->isJson($value))) {
            return 'json';
        }
        
        // Cek apakah path file
        if (is_string($value) && strpos($value, 'landing-page/') === 0) {
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            
            // Video extensions
            if (in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'wmv', 'webm'])) {
                return 'video';
            }
            
            // Image extensions
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                return 'image';
            }
        }

        return 'text';
    }

    /**
     * Cek apakah string adalah JSON
     */
    private function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }
        
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Upload gambar via AJAX (optional - untuk future use)
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'section' => 'required|string',
            'key' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            $this->deleteOldFile($request->section, $request->key);

            // Upload gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('landing-page', $filename, 'public');

            // Simpan ke database
            LandingPageContent::setContent(
                $request->section,
                $request->key,
                $path,
                'image'
            );

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diupload',
                'path' => Storage::url($path)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Upload gagal'
        ], 400);
    }

    /**
     * Delete specific content
     */
    public function deleteContent(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'key' => 'required|string',
        ]);

        $content = LandingPageContent::where('section', $request->section)
                                     ->where('key', $request->key)
                                     ->first();

        if ($content) {
            // Hapus file jika ada
            if (in_array($content->type, ['image', 'video']) && Storage::disk('public')->exists($content->value)) {
                Storage::disk('public')->delete($content->value);
            }

            $content->delete();

            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil dihapus'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Konten tidak ditemukan'
        ], 404);
    }
}