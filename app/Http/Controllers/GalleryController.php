<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Schema;

class GalleryController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('galleries')) {
            return redirect()->route('home')
                ->with('status', 'Tabel galeri belum tersedia.');
        }

        $galleries = Gallery::latest()->get();

        return view('gallery.index', compact('galleries'));
    }
}
