# Hero Slideshow & Foto Kepala Sekolah - Implementation Guide

## Overview
This document describes the new features added to SD N 2 Dermolo website:
1. **Multi-Hero Slideshow** - Support for multiple hero images with automatic slideshow
2. **Foto Kepala Sekolah** - Official headmaster photo on "Tentang Kami" page

## Features Implemented

### 1. Hero Slideshow System

#### Database Changes
- **New Table**: `hero_slides` - Stores multiple hero images with ordering
  - `id` - Primary key
  - `image_path` - Path to uploaded image
  - `title` - Optional slide title
  - `subtitle` - Optional slide subtitle
  - `description` - Optional slide description
  - `display_order` - Integer for ordering slides
  - `is_active` - Boolean to show/hide slide
  - `timestamps`

#### Backend Files Created/Updated
- **Model**: `app/Models/HeroSlide.php`
  - Methods for CRUD operations
  - Order management (move up/down, reorder)
  - Image upload/delete handling

- **Controller**: `app/Http/Controllers/AdminHeroSlideController.php`
  - `index()` - Display all slides
  - `store()` - Add new slide
  - `update()` - Edit existing slide
  - `destroy()` - Delete slide with image
  - `reorder()` - Update order via drag-drop
  - `moveUp()` / `moveDown()` - Manual ordering
  - `toggleActive()` - Show/hide slide

- **Routes**: Added to `routes/web.php`
  ```php
  Route::prefix('admin/hero-slides')->name('admin.hero-slides.')->group(function () {
      Route::get('/', [AdminHeroSlideController::class, 'index'])->name('index');
      Route::post('/', [AdminHeroSlideController::class, 'store'])->name('store');
      Route::put('/{heroSlide}', [AdminHeroSlideController::class, 'update'])->name('update');
      Route::delete('/{heroSlide}', [AdminHeroSlideController::class, 'destroy'])->name('destroy');
      Route::post('/reorder', [AdminHeroSlideController::class, 'reorder'])->name('reorder');
      Route::post('/{heroSlide}/move-up', [AdminHeroSlideController::class, 'moveUp'])->name('move-up');
      Route::post('/{heroSlide}/move-down', [AdminHeroSlideController::class, 'moveDown'])->name('move-down');
      Route::post('/{heroSlide}/toggle-active', [AdminHeroSlideController::class, 'toggleActive'])->name('toggle-active');
  });
  ```

#### Frontend Files Updated
- **Admin View**: `resources/views/admin/hero-slides/index.blade.php`
  - Form to add new slides
  - Drag & drop reordering
  - Edit modal for each slide
  - Toggle active/inactive status
  - Delete with confirmation

- **Home Page**: `resources/views/spa/partials/home.blade.php`
  - Integrated Swiper.js slideshow
  - Autoplay with 5-second intervals
  - Fade transition effect
  - Pagination dots at bottom
  - Responsive design

- **SPA Integration**: `public/js/spa.js`
  - Added `setupHeroSwiper()` function
  - Properly destroys and reinitializes on navigation
  - Works with AJAX-based page loads

- **Swiper.js CDN**: Added to `resources/views/layouts/app.blade.php`
  - CSS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css`
  - JS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js`
  - Custom styles for pagination dots

#### Controller Updates
- **SpaController**: `app/Http/Controllers/SpaController.php`
  - `getHomeContent()` now passes `$heroSlides` from `HeroSlide::getActiveOrdered()`

### 2. Foto Kepala Sekolah System

#### Database Changes
- **New Column**: `foto_kepsek` added to `site_settings` table
  - Stores path to official headmaster photo
  - Separate from `kepsek_sambutan_foto` (used in sambutan section)

#### Backend Updates
- **Model**: `app/Models/SiteSetting.php`
  - Added `foto_kepsek` to `$fillable` array
  - `getFotoKepsek()` - Get photo path
  - `uploadFotoKepsek($image)` - Upload new photo
  - `deleteFotoKepsek()` - Delete existing photo

- **Controller**: `app/Http/Controllers/AdminSettingsController.php`
  - `uploadFotoKepsek()` - Handle photo upload
  - `deleteFotoKepsek()` - Handle photo deletion
  - Updated `hiddenSettings()` to pass `$fotoKepsek` to view

- **Routes**: Added to `routes/web.php`
  ```php
  Route::post('/settings/foto-kepsek/upload', [AdminSettingsController::class, 'uploadFotoKepsek'])->name('settings.upload-foto-kepsek');
  Route::delete('/settings/foto-kepsek/delete', [AdminSettingsController::class, 'deleteFotoKepsek'])->name('settings.delete-foto-kepsek');
  ```

#### Frontend Updates
- **Admin Settings**: `resources/views/admin/settings_hidden.blade.php`
  - New section "Foto Resmi Kepala Sekolah"
  - Upload form with preview
  - Delete button with confirmation
  - 4:5 aspect ratio recommendation

- **Home Page**: `resources/views/spa/partials/home.blade.php`
  - "Tentang Kami" section now shows `$fotoKepsek` (priority) or `$sambutanFoto` (fallback)
  - Professional styling with white border and shadow

- **About Page**: `resources/views/spa/partials/about.blade.php`
  - New "Kepala Sekolah Sambutan" section
  - Two-column layout: photo on left, text on right
  - Shows `$fotoKepsek` with fallback to `$sambutanFoto`

#### Controller Updates
- **SpaController**: 
  - `getHomeContent()` passes `$fotoKepsek`
  - `getAboutContent()` passes `$fotoKepsek`, `$sambutanText`, `$sambutanFoto`, `$kepsek`

## Installation Steps

### 1. Run Migrations
Open Laragon terminal or command prompt in project directory and run:
```bash
php artisan migrate
```

This will create:
- `hero_slides` table
- `foto_kepsek` column in `site_settings` table

### 2. Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 3. Create Storage Link (if not exists)
```bash
php artisan storage:link
```

### 4. Test the Features

#### Admin Panel - Hero Slides
1. Login to admin panel
2. Navigate to "Konten Publik > Hero Slides (Slideshow)"
3. Upload multiple images (JPG, PNG, WebP - max 3MB each)
4. Use drag & drop to reorder slides
5. Toggle active/inactive status
6. Visit homepage to see slideshow in action

#### Admin Panel - Foto Kepala Sekolah
1. Navigate to "Pengaturan > Hidden Settings"
2. Find "Foto Resmi Kepala Sekolah" section
3. Upload official headmaster photo (recommended 4:5 ratio)
4. Visit homepage and "Tentang Kami" page to see the photo

## Technical Details

### Swiper.js Configuration
```javascript
{
    loop: true,
    speed: 1000,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
    effect: 'fade',
    fadeEffect: {
        crossFade: true
    },
    pagination: {
        el: '.hero-swiper-pagination',
        clickable: true,
    },
}
```

### Image Storage Paths
- Hero slides: `storage/app/public/hero-slides/`
- Foto Kepsek: `storage/app/public/kepala-sekolah/`

### Fallback Behavior
- If no hero slides exist, falls back to single `$dbHeroImage`
- If no `$fotoKepsek`, falls back to `$sambutanFoto`
- If neither exists, shows placeholder icon

### SPA Compatibility
- Swiper reinitializes on every page navigation
- Old instances are properly destroyed to prevent memory leaks
- Works seamlessly with AJAX content loading

## Admin Menu Location
- **Hero Slides**: Admin Sidebar > Konten Publik > Hero Slides (Slideshow)
- **Foto Kepsek**: Admin Sidebar > Pengaturan > Hidden Settings (scroll down)

## Browser Support
- Chrome/Edge: Full support
- Firefox: Full support
- Safari: Full support
- Mobile browsers: Responsive and touch-friendly

## Troubleshooting

### Slideshow not showing
1. Check if hero slides exist in database
2. Verify images are uploaded via admin panel
3. Check browser console for JavaScript errors
4. Ensure Swiper.js CDN is loading properly

### Foto Kepala Sekolah not appearing
1. Verify photo is uploaded in Hidden Settings
2. Check `storage` symlink is working
3. Clear view cache: `php artisan view:clear`
4. Check file permissions on storage directory

### Drag & drop not working
1. Ensure JavaScript is enabled in browser
2. Check console for errors
3. Verify SPA is reinitializing components on navigation

## Notes
- No emoji characters used in code (cPanel deployment safe)
- All text in Indonesian language
- Professional styling with Tailwind CSS
- Fully responsive on mobile devices
- SPA-compatible for smooth navigation

## Next Steps (Optional Enhancements)
- Add video support for hero slides
- Add text overlay customization per slide
- Add transition effect options (slide, cube, coverflow, etc.)
- Add analytics for slideshow views
- Add bulk upload for multiple slides
