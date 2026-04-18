<?php

namespace App\Http\Controllers;

use App\Models\HomepageSection;
use App\Support\SchoolConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminHomepageController extends Controller
{
    /**
     * Show homepage settings dashboard - Read-only static info
     */
    public function index()
    {
        // Get hero section from database (if table exists)
        $hero = null;
        if (Schema::hasTable('homepage_sections')) {
            $hero = HomepageSection::getHero();
        }

        // Get static config data
        $staticHero = SchoolConfig::hero();

        return view('admin.homepage.index', compact('hero', 'staticHero'));
    }

    /**
     * Update homepage section.
     */
    public function update(Request $request, string $sectionKey)
    {
        if (! Schema::hasTable('homepage_sections')) {
            return back()->with('error', 'Tabel homepage_sections belum tersedia. Jalankan migrasi.');
        }

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cta_text' => 'nullable|string|max:100',
            'cta_link' => 'nullable|string|max:255',
        ]);

        $section = HomepageSection::where('section_key', $sectionKey)->first();

        if (! $section) {
            // Create new section if doesn't exist
            $section = new HomepageSection;
            $section->section_key = $sectionKey;
            $section->section_name = ucwords(str_replace('-', ' ', $sectionKey));
            $section->is_active = true;
        }

        // Update fields
        $section->title = $validated['title'] ?? $section->title;
        $section->subtitle = $validated['subtitle'] ?? $section->subtitle;
        $section->description = $validated['description'] ?? $section->description;

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($section->background_image) {
                $oldPath = storage_path('app/public/'.$section->background_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $path = $request->file('background_image')->store('public/homepage');
            $section->background_image = basename($path);
        }

        $section->save();

        return back()->with('success', 'Bagian homepage berhasil diperbarui.');
    }
}
