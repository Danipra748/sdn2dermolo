<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Support\Facades\Schema;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Schema::hasTable('prestasis')
            ? Prestasi::latest()->get()
            : collect();

        return view('prestasi.index', compact('prestasi'));
    }
}
