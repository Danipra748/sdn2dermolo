<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AdminProgramController;
use App\Http\Controllers\AdminPrestasiController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\AdminSambutanController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProgramPhotoController;
use App\Http\Controllers\NewsController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/program', [PageController::class, 'programIndex'])->name('program.index');
Route::get('/fasilitas', [PageController::class, 'fasilitasIndex'])->name('fasilitas.index');
Route::get('/guru-pendidik', [PageController::class, 'guruIndex'])->name('guru.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ── FASILITAS PUBLIK (halaman detail) ──
Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
    Route::get('/ruang-kelas',       [FasilitasController::class, 'ruangKelas'])->name('ruang-kelas');
    Route::get('/perpustakaan',      [FasilitasController::class, 'perpustakaan'])->name('perpustakaan');
    Route::get('/musholla',          [FasilitasController::class, 'musholla'])->name('musholla');
    Route::get('/lapangan-olahraga', [FasilitasController::class, 'lapanganOlahraga'])->name('lapangan-olahraga');
});

// ── PROGRAM ──
Route::prefix('program')->name('program.')->group(function () {
    Route::get('/pramuka',    [ProgramController::class, 'pramuka'])->name('pramuka');
    Route::get('/seni-ukir',  [ProgramController::class, 'seniUkir'])->name('seni-ukir');
    Route::get('/drumband',   [ProgramController::class, 'drumband'])->name('drumband');
});

// ── PRESTASI ──
Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');

// —— NEWS / ARTICLES ——
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/search', [NewsController::class, 'search'])->name('search');
    Route::get('/category/{category:slug}', [NewsController::class, 'category'])->name('category');
    Route::get('/{article:slug}', [NewsController::class, 'show'])->name('show');
});

// ── ADMIN (butuh login) ──
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Guru
    Route::resource('guru', GuruController::class)->except(['show']);

    // Fasilitas CRUD
    Route::resource('fasilitas', FasilitasController::class)
        ->except(['show'])
        ->parameters(['fasilitas' => 'fasilita']);

    // Program Sekolah (hanya dokumentasi)
    Route::get('program-sekolah', [AdminProgramController::class, 'index'])
        ->name('program-sekolah.index');

    Route::get('program-sekolah/{programSekolah}/photos', [AdminProgramPhotoController::class, 'index'])
        ->name('program-sekolah.photos.index');
    Route::get('program-sekolah/{programSekolah}/photos/create', [AdminProgramPhotoController::class, 'create'])
        ->name('program-sekolah.photos.create');
    Route::post('program-sekolah/{programSekolah}/photos', [AdminProgramPhotoController::class, 'store'])
        ->name('program-sekolah.photos.store');
    Route::get('program-sekolah/{programSekolah}/photos/{photo}/edit', [AdminProgramPhotoController::class, 'edit'])
        ->name('program-sekolah.photos.edit');
    Route::put('program-sekolah/{programSekolah}/photos/{photo}', [AdminProgramPhotoController::class, 'update'])
        ->name('program-sekolah.photos.update');
    Route::delete('program-sekolah/{programSekolah}/photos/{photo}', [AdminProgramPhotoController::class, 'destroy'])
        ->name('program-sekolah.photos.destroy');

    // Ringkasan Prestasi
    Route::get('prestasi-sekolah/ringkasan/edit', [AdminPrestasiController::class, 'editRingkasan'])
        ->name('prestasi-sekolah.ringkasan.edit');
    Route::put('prestasi-sekolah/ringkasan', [AdminPrestasiController::class, 'updateRingkasan'])
        ->name('prestasi-sekolah.ringkasan.update');

    // Sambutan Kepala Sekolah
    Route::get('sambutan-kepsek', [AdminSambutanController::class, 'edit'])
        ->name('sambutan-kepsek.edit');
    Route::put('sambutan-kepsek', [AdminSambutanController::class, 'update'])
        ->name('sambutan-kepsek.update');

    // Prestasi Sekolah CRUD
    Route::resource('prestasi-sekolah', AdminPrestasiController::class)
        ->except(['show'])
        ->parameters(['prestasi-sekolah' => 'prestasiSekolah']);

    // Artikel & News
    Route::post('articles/ai-generate', [AdminArticleController::class, 'generateAi'])
        ->name('articles.ai-generate');
    Route::resource('articles', AdminArticleController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
});
