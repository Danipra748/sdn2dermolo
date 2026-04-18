<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProgramController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

// Load migration routes (development only)
if (file_exists(__DIR__.'/migration.php')) {
    require __DIR__.'/migration.php';
}
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminContactMessageController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\AdminHeroImageController;
use App\Http\Controllers\AdminHeroSlideController;
use App\Http\Controllers\AdminHomepageController;
use App\Http\Controllers\AdminKontakController;
use App\Http\Controllers\AdminPpdbController;
use App\Http\Controllers\AdminPrestasiController;
use App\Http\Controllers\AdminProgramPhotoController;
use App\Http\Controllers\AdminSambutanController;
use App\Http\Controllers\AdminSchoolProfileController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\SpaController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/program', [PageController::class, 'programIndex'])->name('program.index');
Route::get('/guru-pendidik', [PageController::class, 'guruIndex'])->name('guru.index');
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [PageController::class, 'contactIndex'])->name('contact');
Route::get('/ppdb', [PageController::class, 'ppdbIndex'])->name('ppdb');
Route::get('/ppdb/daftar', [PageController::class, 'ppdbRegister'])->name('ppdb.daftar');

// SPA Routes - Dynamic content loading
Route::prefix('spa')->name('spa.')->group(function () {
    Route::get('/home', [SpaController::class, 'getHomeContent'])->name('home');
    Route::get('/sarana-prasarana', [SpaController::class, 'getSaranaPrasaranaContent'])->name('sarana-prasarana');
    Route::get('/data-guru', [SpaController::class, 'getDataGuruContent'])->name('data-guru');
    Route::get('/prestasi', [SpaController::class, 'getPrestasiContent'])->name('prestasi');
    Route::get('/gallery', [SpaController::class, 'getGalleryContent'])->name('gallery');
    Route::get('/about', [SpaController::class, 'getAboutContent'])->name('about');
    Route::get('/berita', [SpaController::class, 'getBeritaContent'])->name('berita');
    Route::get('/program', [SpaController::class, 'getProgramContent'])->name('program');
    Route::get('/contact', [SpaController::class, 'getContactContent'])->name('contact');
    Route::get('/ppdb', [SpaController::class, 'getPpdbContent'])->name('ppdb');
    Route::get('/ppdb/daftar', [SpaController::class, 'getPpdbRegistrationContent'])->name('ppdb.registration');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ── FASILITAS PUBLIK (halaman detail) ──
Route::get('/fasilitas/ruang-kelas', [FasilitasController::class, 'ruangKelas'])->name('fasilitas.ruang-kelas');
Route::get('/fasilitas/perpustakaan', [FasilitasController::class, 'perpustakaan'])->name('fasilitas.perpustakaan');
Route::get('/fasilitas/musholla', [FasilitasController::class, 'musholla'])->name('fasilitas.musholla');
Route::get('/fasilitas/lapangan-olahraga', [FasilitasController::class, 'lapanganOlahraga'])->name('fasilitas.lapangan-olahraga');

// ── PROGRAM ──
Route::prefix('program')->name('program.')->group(function () {
    Route::get('/pramuka', [ProgramController::class, 'pramuka'])->name('pramuka');
    Route::get('/seni-ukir', [ProgramController::class, 'seniUkir'])->name('seni-ukir');
    Route::get('/drumband', [ProgramController::class, 'drumband'])->name('drumband');
});

// ── PRESTASI ──
Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');

// ── FASILITAS ──
Route::get('/fasilitas', [PageController::class, 'fasilitasIndex'])->name('public.fasilitas.index');

// ── GALLERY ──
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');

// Pesan Kontak
Route::post('/kirim-pesan', [ContactMessageController::class, 'store'])->name('contact-messages.store');

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

    Route::put('fasilitas/hero-background', [FasilitasController::class, 'updateHeroBackground'])
        ->name('fasilitas.hero-background.update');
    // Fasilitas CRUD
    Route::resource('fasilitas', FasilitasController::class)
        ->except(['show'])
        ->parameters(['fasilitas' => 'fasilita']);

    // Program Sekolah CRUD
    Route::resource('program-sekolah', AdminProgramController::class)
        ->except(['show'])
        ->parameters(['program-sekolah' => 'programSekolah']);

    // Custom routes for file handling etc. if still needed
    Route::put('program-sekolah/{programSekolah}/hero-background', [AdminProgramController::class, 'updateHeroBackground'])
        ->name('program-sekolah.hero-background.update');
    Route::get('program-sekolah/{programSekolah}/highlights/edit', [AdminProgramController::class, 'editHighlights'])
        ->name('program-sekolah.highlights.edit');
    Route::put('program-sekolah/{programSekolah}/highlights', [AdminProgramController::class, 'updateHighlights'])
        ->name('program-sekolah.highlights.update');

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

    // Program file deletion routes
    Route::delete('program-sekolah/{programSekolah}/card-bg', [AdminProgramController::class, 'deleteCardBg'])
        ->name('program-sekolah.card-bg.delete');
    Route::delete('program-sekolah/{programSekolah}/foto', [AdminProgramController::class, 'deleteFoto'])
        ->name('program-sekolah.foto.delete');
    Route::delete('program-sekolah/{programSekolah}/logo', [AdminProgramController::class, 'deleteLogo'])
        ->name('program-sekolah.logo.delete');

    // Ringkasan Prestasi
    Route::get('prestasi-sekolah/ringkasan/edit', [AdminPrestasiController::class, 'editRingkasan'])
        ->name('prestasi-sekolah.ringkasan.edit');
    Route::put('prestasi-sekolah/ringkasan', [AdminPrestasiController::class, 'updateRingkasan'])
        ->name('prestasi-sekolah.ringkasan.update');

    // Halaman khusus tersembunyi untuk backup form admin.
    // Di sini lokasi penyimpanan path logonya.
    // Di sini variabel sambutan kepala sekolah diproses.
    Route::get('hidden-settings', [AdminSettingsController::class, 'hiddenSettings'])
        ->name('hidden-settings');

    // Sambutan Kepala Sekolah
    Route::get('sambutan-kepsek', [AdminSambutanController::class, 'edit'])
        ->name('sambutan-kepsek.edit');
    Route::put('sambutan-kepsek', [AdminSambutanController::class, 'update'])
        ->name('sambutan-kepsek.update');

    // Kontak Sekolah
    Route::get('kontak', [AdminKontakController::class, 'edit'])
        ->name('kontak.edit');
    Route::put('kontak', [AdminKontakController::class, 'update'])
        ->name('kontak.update');

    // Pesan Masuk
    Route::get('pesan-masuk', [AdminContactMessageController::class, 'index'])
        ->name('messages.index');
    Route::get('pesan-masuk/{message}', [AdminContactMessageController::class, 'show'])
        ->name('messages.show');
    Route::delete('pesan-masuk/{message}', [AdminContactMessageController::class, 'destroy'])
        ->name('messages.destroy');

    // Hero Slides Management (Multi-Slide System)
    Route::prefix('hero-slides')->name('hero-slides.')->group(function () {
        Route::get('/', [AdminHeroSlideController::class, 'index'])->name('index');
        Route::get('/create', [AdminHeroSlideController::class, 'create'])->name('create');
        Route::post('/', [AdminHeroSlideController::class, 'store'])->name('store');
        Route::get('/{heroSlide}/edit', [AdminHeroSlideController::class, 'edit'])->name('edit');
        Route::put('/{heroSlide}', [AdminHeroSlideController::class, 'update'])->name('update');
        Route::delete('/{heroSlide}', [AdminHeroSlideController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [AdminHeroSlideController::class, 'reorder'])->name('reorder');
        Route::post('/{heroSlide}/move-up', [AdminHeroSlideController::class, 'moveUp'])->name('move-up');
        Route::post('/{heroSlide}/move-down', [AdminHeroSlideController::class, 'moveDown'])->name('move-down');
        Route::post('/{heroSlide}/toggle-active', [AdminHeroSlideController::class, 'toggleActive'])->name('toggle-active');
    });

    // School Profile Management (includes Logo)
    Route::prefix('school-profile')->name('school-profile.')->group(function () {
        Route::get('/', [AdminSchoolProfileController::class, 'edit'])->name('edit');
        Route::put('/', [AdminSchoolProfileController::class, 'update'])->name('update');
        Route::delete('/logo', [AdminSchoolProfileController::class, 'deleteLogo'])->name('delete-logo');
    });

    // Settings (foto-kepsek & logo)
    Route::prefix('settings')->name('settings.')->group(function () {
        // Original routes (foto kepsek)
        Route::post('/foto-kepsek/upload', [AdminSettingsController::class, 'uploadFotoKepsek'])->name('upload-foto-kepsek');
        Route::delete('/foto-kepsek/delete', [AdminSettingsController::class, 'deleteFotoKepsek'])->name('delete-foto-kepsek');
        // New route (logo)
        Route::post('/upload-logo', [AdminSettingsController::class, 'uploadLogo'])->name('upload-logo');
    });

    // Hero Image Management
    Route::put('hero-image', [AdminHeroImageController::class, 'update'])
        ->name('hero-image.update');
    Route::delete('hero-image', [AdminHeroImageController::class, 'destroy'])
        ->name('hero-image.destroy');

    // Homepage Management
    Route::get('homepage', [AdminHomepageController::class, 'index'])
        ->name('homepage.index');
    Route::put('homepage/{section}', [AdminHomepageController::class, 'update'])
        ->name('homepage.update');

    // Prestasi Sekolah CRUD
    Route::resource('prestasi-sekolah', AdminPrestasiController::class)
        ->except(['show'])
        ->parameters(['prestasi-sekolah' => 'prestasiSekolah']);

    // Gallery CRUD
    Route::resource('gallery', AdminGalleryController::class)
        ->except(['show'])
        ->parameters(['gallery' => 'gallery']);

    // Artikel & News
    Route::post('articles/ai-generate', [AdminArticleController::class, 'generateAi'])
        ->name('articles.ai-generate');
    Route::resource('articles', AdminArticleController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // PPDB Management
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('/', [AdminPpdbController::class, 'index'])->name('index');
        Route::post('/settings', [AdminPpdbController::class, 'updateSettings'])->name('settings.update');
        Route::put('/settings', [AdminPpdbController::class, 'updateSettings'])->name('settings.update');
        Route::get('/banners/create', [AdminPpdbController::class, 'createBanner'])->name('banners.create');
        Route::post('/banners', [AdminPpdbController::class, 'storeBanner'])->name('banners.store');
        Route::get('/banners/{banner}/edit', [AdminPpdbController::class, 'editBanner'])->name('banners.edit');
        Route::post('/banners/{banner}', [AdminPpdbController::class, 'updateBanner'])->name('banners.update');
        Route::patch('/banners/{banner}/toggle', [AdminPpdbController::class, 'toggleBanner'])->name('banners.toggle');
        Route::delete('/banners/{banner}', [AdminPpdbController::class, 'destroyBanner'])->name('banners.destroy');
    });
});
