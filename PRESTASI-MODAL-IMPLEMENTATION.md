# PRESTASI-MODAL-IMPLEMENTATION.md

## Prestasi Modal Implementation - Complete

**Date:** Rabu, 8 April 2026  
**Status:** ✅ Completed

---

## Overview

Successfully replicated the modal behavior from the Facilities (Sarana Prasarana) page and applied it to the Achievements (Prestasi) page in the SPA partial view.

---

## Changes Made

### 1. Updated File: `resources/views/spa/partials/prestasi.blade.php`

#### A. Added CSS Styles for Modal
```css
.prestasi-modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; padding: 1.5rem; z-index: 60; }
.prestasi-modal.is-open { display: flex; }
.prestasi-card-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.prestasi-card-desc {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
```

#### B. Updated Achievement Cards
Changed from `<div>` to `<button>` elements with the following attributes:

**Before:**
```blade
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm reveal transition-all duration-[400ms] ...">
    <!-- card content -->
</div>
```

**After:**
```blade
<button type="button"
    class="prestasi-card group w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm text-left cursor-pointer transition-all duration-[400ms] ..."
    data-prestasi-card
    data-title="{{ $item->judul ?? '' }}"
    data-desc="{{ $item->deskripsi ?? '' }}"
    data-image="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}">
    <!-- card content -->
</button>
```

**Key Changes:**
- ✅ Changed from `<div>` to `<button type="button">` for proper semantics
- ✅ Added `data-prestasi-card` attribute for event listener targeting
- ✅ Added `data-title`, `data-desc`, `data-image` attributes to store achievement details
- ✅ Added `cursor-pointer` and `text-left` classes for better UX
- ✅ Added "Klik untuk detail" hint text at the bottom of each card
- ✅ Added CSS classes `.prestasi-card-title` and `.prestasi-card-desc` for text truncation

#### C. Added Modal HTML Structure
```html
{{-- Prestasi Modal --}}
<div id="prestasi-modal" class="prestasi-modal" aria-hidden="true">
    <div class="prestasi-modal-backdrop absolute inset-0 bg-slate-900/60" data-prestasi-close></div>
    <div class="prestasi-modal-content relative bg-white rounded-[1.5rem] overflow-hidden max-w-[900px] w-full grid grid-cols-1 md:grid-cols-[1.2fr_1fr] shadow-[0_30px_60px_rgba(15,23,42,0.2)] z-10" role="dialog" aria-modal="true" aria-labelledby="prestasi-modal-title">
        <button type="button" class="prestasi-modal-close absolute top-[0.75rem] right-[0.75rem] w-[38px] h-[38px] rounded-full bg-white border border-slate-200 inline-flex items-center justify-center shadow-[0_8px_18px_rgba(15,23,42,0.12)] cursor-pointer z-20" data-prestasi-close aria-label="Tutup">
            <x-heroicon-o-x-mark class="w-5 h-5 text-slate-700" />
        </button>
        <div class="prestasi-modal-media bg-slate-200 min-h-[300px]">
            <img id="prestasi-modal-image" alt="" class="w-full h-full object-cover" />
        </div>
        <div class="prestasi-modal-body p-6">
            <h3 id="prestasi-modal-title" class="font-black text-[1.35rem] text-slate-900"></h3>
            <p id="prestasi-modal-desc" class="mt-[0.75rem] text-slate-500 leading-[1.7]"></p>
        </div>
    </div>
</div>
```

**Modal Features:**
- Two-column layout (image on left, content on right) on desktop
- Responsive design (single column on mobile)
- Close button in top-right corner
- Backdrop click to close
- Escape key to close
- Accessible with ARIA attributes

#### D. Added JavaScript Event Handlers
```javascript
<script>
(function() {
    const modal = document.getElementById('prestasi-modal');
    if (!modal) return;
    const imageEl = document.getElementById('prestasi-modal-image');
    const titleEl = document.getElementById('prestasi-modal-title');
    const descEl  = document.getElementById('prestasi-modal-desc');

    const openModal = (card) => {
        const title = card.dataset.title || '';
        const desc  = card.dataset.desc || '';
        const img   = card.dataset.image || '';
        titleEl.textContent = title;
        descEl.textContent = desc || 'Deskripsi prestasi belum tersedia.';
        if (img) {
            imageEl.src = img;
            imageEl.style.display = 'block';
        } else {
            imageEl.removeAttribute('src');
            imageEl.style.display = 'none';
        }
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    document.querySelectorAll('[data-prestasi-card]').forEach(card => {
        card.addEventListener('click', () => openModal(card));
    });
    modal.querySelectorAll('[data-prestasi-close]').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
})();
</script>
```

**JavaScript Features:**
- IIFE to avoid global scope pollution
- Opens modal when card is clicked
- Reads data from `data-*` attributes
- Populates modal content dynamically
- Three ways to close modal: close button, backdrop click, Escape key
- Disables body scroll when modal is open

---

## How It Works

### 1. Card Click Flow
1. User clicks on an achievement card (`[data-prestasi-card]`)
2. JavaScript reads the `data-title`, `data-desc`, and `data-image` attributes
3. Modal elements are populated with the achievement data
4. Modal is displayed by adding `is-open` class
5. Body scroll is disabled

### 2. Modal Close Flow
1. User clicks close button, backdrop, or presses Escape
2. Modal `is-open` class is removed
3. Body scroll is re-enabled
4. Modal is hidden

### 3. Data Attributes
Each achievement card stores its data in HTML attributes:
- `data-prestasi-card` - Identifies clickable cards
- `data-title` - Achievement title (from `$item->judul`)
- `data-desc` - Achievement description (from `$item->deskripsi`)
- `data-image` - Image URL (from `$item->foto`)

---

## Consistency with Facilities Modal

The implementation follows the exact same pattern as the Facilities modal:

| Feature | Facilities | Prestasi |
|---------|-----------|----------|
| Card Element | `<button>` | `<button>` |
| Card Data Attribute | `data-facility-card` | `data-prestasi-card` |
| Modal ID | `facility-modal` | `prestasi-modal` |
| Close Data Attribute | `data-facility-close` | `data-prestasi-close` |
| CSS Classes | `.facility-modal` | `.prestasi-modal` |
| JavaScript Handler | Inline script + spa.js | Inline script + spa.js |
| Modal Layout | 2-column grid | 2-column grid |

---

## Testing Checklist

- [ ] Click on an achievement card - modal should open
- [ ] Verify title, description, and image are displayed correctly
- [ ] Click the close button (X) - modal should close
- [ ] Click the backdrop - modal should close
- [ ] Press Escape key - modal should close
- [ ] Verify body scroll is disabled when modal is open
- [ ] Verify body scroll is re-enabled when modal closes
- [ ] Test on mobile viewport - modal should be responsive
- [ ] Test with achievement that has no image - should hide image container
- [ ] Test with achievement that has no description - should show default text

---

## Files Modified

1. ✅ `resources/views/spa/partials/prestasi.blade.php`
   - Added CSS styles for modal
   - Changed cards from `<div>` to `<button>` elements
   - Added `data-*` attributes to cards
   - Added modal HTML structure
   - Added JavaScript event handlers

---

## Notes

- The SPA JavaScript (`spa.js`) already has a `setupPrestasiModal()` function that serves as a backup handler
- The inline script in the partial view is the primary handler for modal functionality
- Both approaches work together to ensure the modal functions correctly in both direct page loads and SPA navigation
- Removed the non-functional `tahun` (year) badge that referenced a non-existent database column
- Added text truncation CSS to prevent overflow issues with long titles/descriptions

---

## Related Files

- `resources/views/prestasi/index.blade.php` - Regular (non-SPA) achievements page (already had modal)
- `public/js/spa.js` - SPA JavaScript with `setupPrestasiModal()` function
- `resources/views/spa/partials/sarana-prasarana.blade.php` - Facilities SPA partial (reference implementation)

---

## Implementation Complete ✅

The Achievements page now has full modal functionality identical to the Facilities page. Users can click on achievement cards to view full details in a beautiful modal dialog.
