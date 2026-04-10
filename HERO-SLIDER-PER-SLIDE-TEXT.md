# Hero Slider - Per-Slide Title & Subtitle Feature

## Overview
The hero slider now supports unique **Title** and **Subtitle** text for each slide. When admins configure the hero slider in the admin panel, they can set different text for each image, and the frontend will automatically display the corresponding text when slides transition.

---

## Features

### ✅ Admin Panel
- **Per-Slide Text Management**: Each slide has its own title and subtitle fields
- **Visual Interface**: Clean card-based layout with numbered slides
- **Add/Remove Slides**: Easily add new slides or remove existing ones
- **Auto-Sync**: Text fields automatically sync with the database
- **Preview**: See which image corresponds to each text field

### ✅ Frontend
- **Dynamic Text Updates**: Title and subtitle change automatically when slides transition
- **Smooth Transitions**: Text fades out and in during slide changes (300ms animation)
- **Responsive Design**: Text maintains styling across all screen sizes
- **Fallback Support**: If no per-slide text is set, uses global title/subtitle

---

## How It Works

### Database Structure

The slide texts are stored in the `extra_data` JSON column of the `homepage_sections` table:

```json
{
  "slide_texts": [
    {
      "title": "SD N 2 Dermolo",
      "subtitle": "Unggul & Berkarakter"
    },
    {
      "title": "Prestasi Akademik",
      "subtitle": "Meraih Keunggulan"
    },
    {
      "title": "Lingkungan Inspiratif",
      "subtitle": "Belajar dengan Nyaman"
    }
  ],
  "slideshow_images": ["image1.jpg", "image2.jpg", "image3.jpg"],
  "badge_text": "SELAMAT DATANG"
}
```

### Admin Panel Workflow

1. **Navigate to Admin Panel**
   - Go to: `Admin Panel → Pengaturan Beranda → Edit Hero Section`

2. **Upload Images** (if not already done)
   - Use the Media Library to upload slider images
   - Select images for the slideshow (first image = primary)

3. **Set Text for Each Slide**
   - Scroll to "📝 Teks Tiap Slide" section
   - Each slide shows:
     - Slide number badge
     - Image filename (for reference)
     - **Judul** field (Title)
     - **Subjudul** field (Subtitle)

4. **Add New Slides**
   - Click "Tambah Slide" button
   - New slide added with empty title/subtitle
   - Fill in the text fields

5. **Remove Slides**
   - Click the trash icon on any slide
   - Confirm deletion
   - Slide text removed from database

6. **Save Changes**
   - Click "Simpan Perubahan" button
   - All slide texts saved to database
   - Redirects to homepage dashboard

### Frontend Behavior

1. **Initial Load**
   - First slide displays its title/subtitle
   - Text rendered with full opacity

2. **Slide Transition** (every 5 seconds)
   - Current text fades out (300ms)
   - New text updates in DOM
   - New text fades in (300ms)

3. **Dot Navigation**
   - Clicking a dot navigates to that slide
   - Text updates immediately with fade animation
   - Autoplay restarts after 5 seconds

4. **Hover Pause**
   - Hovering over hero pauses autoplay
   - Text remains visible
   - Autoplay resumes on mouse leave

---

## Technical Implementation

### Files Modified

#### 1. Admin Edit Form
**File**: `resources/views/admin/homepage/edit.blade.php`

**Changes**:
- Added "Teks Tiap Slide" section with dynamic form fields
- JavaScript functions:
  - `initializeSlideTexts()` - Load saved texts from database
  - `renderSlideTexts()` - Render form fields for each slide
  - `updateSlideText()` - Update text value on change
  - `addNewSlide()` - Add new slide text fields
  - `removeSlide()` - Remove slide text fields
- Hidden input: `slide_texts_json` stores JSON data

**Code Example**:
```blade
<input type="hidden" name="slide_texts_json" id="slide-texts-json"
       value="{{ old('slide_texts_json', json_encode($section->extra_data['slide_texts'] ?? [])) }}">
```

#### 2. Admin Controller
**File**: `app/Http/Controllers/AdminHomepageController.php`

**Changes**:
- Added validation rule: `'slide_texts_json' => 'nullable|string'`
- Saves slide texts to `extra_data['slide_texts']` after form submission
- Preserves existing extra_data while updating slide_texts

**Code Example**:
```php
$slideTextsJson = $request->input('slide_texts_json');
if ($slideTextsJson) {
    $decodedSlideTexts = json_decode($slideTextsJson, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decodedSlideTexts)) {
        $existingExtra = is_array($section->extra_data) ? $section->extra_data : [];
        $existingExtra['slide_texts'] = $decodedSlideTexts;
        $section->update(['extra_data' => $existingExtra]);
    }
}
```

#### 3. Frontend View
**File**: `resources/views/spa/partials/home.blade.php`

**Changes**:
- Extracts `slide_texts` from `$heroExtra`
- Adds `data-slide-title` and `data-slide-subtitle` attributes to each slide
- Added IDs to hero title/subtitle elements for JavaScript access

**Code Example**:
```blade
@php
    $slideTitle = $slideTexts[$index]['title'] ?? ($index === 0 ? $heroTitle : '');
    $slideSubtitle = $slideTexts[$index]['subtitle'] ?? ($index === 0 ? $heroSubtitle : '');
@endphp
<div class="hero-slide" data-slide-title="{{ e($slideTitle) }}" data-slide-subtitle="{{ e($slideSubtitle) }}">
```

#### 4. Frontend JavaScript
**File**: `public/js/spa.js`

**Changes**:
- Added `updateHeroText(index)` function
- Reads `data-slide-title` and `data-slide-subtitle` from active slide
- Fades out current text (300ms)
- Updates text in DOM
- Fades in new text (300ms)
- Called automatically in `goToSlide()`

**Code Example**:
```javascript
const updateHeroText = (index) => {
    if (!heroTitleEl || !heroSubtitleEl) return;

    const currentSlide = slides[index];
    const newTitle = currentSlide.dataset.slideTitle || '';
    const newSubtitle = currentSlide.dataset.slideSubtitle || '';

    // Fade out
    heroTitleEl.style.opacity = '0';
    heroSubtitleEl.style.opacity = '0';

    // Update text
    setTimeout(() => {
        heroTitleEl.textContent = newTitle;
        // Update subtitle...
        
        // Fade in
        heroTitleEl.style.opacity = '1';
    }, 300);
};
```

---

## Usage Example

### Scenario: 3-Slide Hero Slider

**Slide 1**: School Welcome
- Image: School building photo
- Title: "SD N 2 Dermolo"
- Subtitle: "Unggul & Berkarakter"

**Slide 2**: Academic Achievement
- Image: Students receiving awards
- Title: "Prestasi Akademik"
- Subtitle: "Meraih Keunggulan"

**Slide 3**: Learning Environment
- Image: Classroom activities
- Title: "Lingkungan Inspiratif"
- Subtitle: "Belajar dengan Nyaman"

**Result**:
When visitors view the homepage:
1. Slide 1 shows: "SD N 2 Dermolo / Unggul & Berkarakter"
2. After 5 seconds, transitions to Slide 2: "Prestasi Akademik / Meraih Keunggulan"
3. After 5 seconds, transitions to Slide 3: "Lingkungan Inspiratif / Belajar dengan Nyaman"
4. Loops back to Slide 1

---

## Troubleshooting

### Issue: Text not changing on slide transition
**Solution**: 
- Check browser console for JavaScript errors
- Verify slides have `data-slide-title` and `data-slide-subtitle` attributes
- Ensure `spa.js` is loaded and `setupSlideshow()` is called

### Issue: Admin form not showing text fields
**Solution**:
- Check if `slide_texts_json` hidden input exists
- Verify JavaScript functions are loaded
- Check for JSON parsing errors in console

### Issue: Text not saving to database
**Solution**:
- Check Laravel logs: `storage/logs/laravel.log`
- Verify `slide_texts_json` is being submitted in form data
- Ensure `extra_data` column is mutable in HomepageSection model

### Issue: Text appears blank on some slides
**Solution**:
- Fill in title/subtitle for all slides in admin panel
- Check if `slide_texts` array has same length as `slideshow_images` array
- Verify data attributes are properly escaped with `{{ e() }}`

---

## Best Practices

1. **Keep Texts Concise**
   - Title: 2-5 words maximum
   - Subtitle: 3-6 words maximum
   - Ensures readability on all screen sizes

2. **Match Text to Image**
   - Write text that relates to the image content
   - Creates cohesive visual narrative

3. **Use Consistent Tone**
   - Maintain professional, welcoming language
   - Align with school's brand voice

4. **Test on Multiple Devices**
   - Preview on desktop, tablet, and mobile
   - Ensure text doesn't overflow or truncate

5. **Provide Fallbacks**
   - Set global title/subtitle as defaults
   - Ensures something displays if per-slide text is missing

---

## Future Enhancements

Potential improvements for future versions:

- [ ] Per-slide button text (CTA buttons)
- [ ] Per-slide badge text
- [ ] Text animation style selector (fade, slide, zoom)
- [ ] Text position controls (center, left, right)
- [ ] Text color picker
- [ ] Font size controls
- [ ] Preview button before saving
- [ ] Bulk edit mode
- [ ] Translation support (multi-language slides)

---

## Support

For questions or issues:
- Check Laravel logs: `storage/logs/laravel.log`
- Check browser console for JavaScript errors
- Review this documentation file
- Test with sample data to isolate issues

---

**Version**: 1.0.0  
**Last Updated**: April 2026  
**Compatibility**: Laravel 10+, PHP 8.1+, Tailwind CSS 3+
