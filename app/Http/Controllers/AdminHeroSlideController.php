<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHeroSlideController extends Controller
{
    /**
     * Display hero slides management page
     */
    public function index()
    {
        $slides = HeroSlide::orderBy('display_order')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    /**
     * Store a new hero slide
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:3072',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $maxOrder = HeroSlide::getMaxOrder();

            // Upload image first to get the path
            $imagePath = $request->file('image')->store('hero-slides', 'public');

            // Create slide with image path
            HeroSlide::create([
                'image_path' => $imagePath,
                'title' => $validated['title'] ?? null,
                'subtitle' => $validated['subtitle'] ?? null,
                'description' => $validated['description'] ?? null,
                'display_order' => $maxOrder + 1,
                'is_active' => true,
            ]);

            return back()->with('success', 'Slide baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Hero slide upload failed: ' . $e->getMessage(), [
                'file' => $request->file('image')->getClientOriginalName(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Gagal mengunggah slide. Silakan coba lagi.');
        }
    }

    /**
     * Update hero slide
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Upload new image if provided
        if ($request->hasFile('image')) {
            $heroSlide->uploadImage($request->file('image'));
        }

        // Update other fields
        $heroSlide->update([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Slide berhasil diperbarui.');
    }

    /**
     * Delete hero slide
     */
    public function destroy(HeroSlide $heroSlide)
    {
        $heroSlide->deleteWithImage();
        return back()->with('success', 'Slide berhasil dihapus.');
    }

    /**
     * Update slide order via drag and drop
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ordered_ids' => 'required|array',
            'ordered_ids.*' => 'exists:hero_slides,id',
        ]);

        HeroSlide::reorder($validated['ordered_ids']);

        return response()->json([
            'success' => true,
            'message' => 'Urutan slide berhasil diperbarui.',
        ]);
    }

    /**
     * Move slide up
     */
    public function moveUp(HeroSlide $heroSlide)
    {
        $heroSlide->moveUp();
        return back()->with('success', 'Slide dipindahkan ke atas.');
    }

    /**
     * Move slide down
     */
    public function moveDown(HeroSlide $heroSlide)
    {
        $heroSlide->moveDown();
        return back()->with('success', 'Slide dipindahkan ke bawah.');
    }

    /**
     * Toggle slide active status
     */
    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => !$heroSlide->is_active]);
        return back()->with('success', 'Status slide berhasil diubah.');
    }
}
