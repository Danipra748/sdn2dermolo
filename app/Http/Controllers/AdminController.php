<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Support\SchoolData;
use App\Models\Guru;
use App\Models\Program;
use App\Models\Article;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        $fasilitas = Schema::hasTable('fasilitas')
            ? Fasilitas::latest()->get()
            : collect(SchoolData::fasilitas());

        $guru = Guru::orderBy('no')->get();

        $program = Schema::hasTable('programs')
            ? Program::orderBy('id')->get()
            : collect(SchoolData::program());

        $stats = [
            'total_fasilitas' => count($fasilitas),
            'total_guru' => $guru->count(),
            'total_program' => count($program),
            'status' => 'Aktif',
        ];

        if (Schema::hasTable('articles')) {
            $stats['total_articles'] = Article::count();
            $stats['published_articles'] = Article::where('status', 'published')->count();
        }

        return view('admin.dashboard', compact('fasilitas', 'guru', 'program', 'stats'));
    }
}
