# SPA Navigation Fix - Complete Implementation

## Masalah yang Diperbaiki

### 1. ❌ Click Events Mati Setelah SPA Navigation
**Problem**: Card di halaman Ekstrakurikuler dan Prestasi tidak bisa dibuka setelah pindah halaman via SPA.

**Solusi**: 
- ✅ Event delegation menggunakan `document.addEventListener()`
- ✅ Handler terdaftar di document level, tidak hilang saat DOM update
- ✅ `element.closest()` untuk menemukan target card

### 2. ❌ Filter Berita Tidak Bekerja
**Problem**: Fungsi filter/pencarian berita tidak jalan setelah halaman Berita dimuat via SPA.

**Solusi**:
- ✅ Hapus guard `newsFilterInitialized` yang mencegah re-init
- ✅ Setup ulang event listeners untuk category buttons
- ✅ Reset filter state setiap kali konten baru dimuat

### 3. ❌ Content Tersembunyi (Hidden)
**Problem**: Elemen tidak muncul karena konflik dengan library animasi (AOS).

**Solusi**:
- ✅ `AOS.init()` dipanggil ulang untuk konten baru
- ✅ `AOS.refresh()` untuk update state
- ✅ `fixHiddenContent()` untuk paksa elemen visible
- ✅ Reset opacity & transform untuk elemen `[data-aos]`

### 4. ❌ Scroll Tidak Reset ke Atas
**Problem**: Setelah pindah halaman, posisi scroll tetap di posisi sebelumnya.

**Solusi**:
- ✅ `window.scrollTo(0, 0)` dengan `behavior: 'instant'`
- ✅ Double scroll attempt (sebelum & sesudah re-init)
- ✅ Force reset `document.scrollingElement.scrollTop`

---

## Implementasi Detail

### 1. Event Delegation untuk Click Events

#### Prestasi Cards
```javascript
// TIDAK LAGI menggunakan direct event listeners
// ❌ document.querySelectorAll('[data-prestasi-card]').forEach(...)

// SEKARANG menggunakan event delegation
document.addEventListener('click', (e) => {
    const prestasiCard = e.target.closest('[data-prestasi-card]');
    if (prestasiCard && !e.target.closest('[data-prestasi-close]')) {
        openPrestasiModal(prestasiCard);
    }
    
    // Handle close buttons
    const closeBtn = e.target.closest('[data-prestasi-close]');
    if (closeBtn) {
        closePrestasiModal();
    }
});
```

**Keuntungan**:
- ✅ Listener tetap ada meskipun DOM berubah
- ✅ Tidak perlu re-setup setelah SPA navigation
- ✅ Memory efficient (1 listener vs N listeners)

#### Program/Ekstrakurikuler Cards
```javascript
document.addEventListener('click', (e) => {
    const programCard = e.target.closest('[data-program-card]');
    if (programCard) {
        const link = programCard.querySelector('a[href]');
        if (link && !e.target.closest('a[href], button, input')) {
            window.location.href = link.href;
        }
    }
});
```

#### Facility Cards
```javascript
// Menggunakan cloneNode technique untuk hapus listeners lama
document.querySelectorAll('[data-facility-card]').forEach(card => {
    const newCard = card.cloneNode(true);
    card.parentNode.replaceChild(newCard, card);
    newCard.addEventListener('click', () => openModal(newCard));
});
```

### 2. Filter Berita - Re-initialization

#### Before (Broken)
```javascript
document.querySelectorAll('[data-news-filter-root]').forEach((root) => {
    if (root.dataset.newsFilterInitialized === 'true') {
        return; // ❌ Mencegah re-init!
    }
    root.dataset.newsFilterInitialized = 'true';
    // ... setup code
});
```

#### After (Fixed)
```javascript
document.querySelectorAll('[data-news-filter-root]').forEach((root) => {
    // ✅ Hapus flag agar bisa di-reinit
    delete root.dataset.newsFilterInitialized;
    
    root.dataset.newsFilterInitialized = 'true';
    
    const buttons = Array.from(root.querySelectorAll('[data-news-category-button]'));
    const cards = Array.from(root.querySelectorAll('[data-news-card]'));
    // ... setup code dengan elements yang FRESH dari DOM
});
```

**Proses**:
1. Hapus `newsFilterInitialized` flag
2. Query ulang semua buttons & cards dari DOM
3. Setup event listeners baru
4. Apply filter initial (biasanya "all")

### 3. AOS Refresh & Hidden Content Fix

#### AOS Handling
```javascript
function refreshExternalLibraries() {
    if (typeof AOS !== 'undefined') {
        // Re-init untuk konten baru
        if (typeof AOS.init === 'function') {
            AOS.init();
        }
        
        // Refresh state
        if (typeof AOS.refresh === 'function') {
            AOS.refresh();
        }
        
        // Reset inline styles yang mungkin ter-set
        document.querySelectorAll('[data-aos]').forEach(el => {
            el.style.opacity = '';
            el.style.transform = '';
        });
    }
}
```

#### Fix Hidden Content
```javascript
function fixHiddenContent() {
    // Fix AOS-animated elements yang stuck
    const hiddenElements = document.querySelectorAll('.aos-animate:not([class*="visible"])');
    hiddenElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        const isInViewport = rect.top < window.innerHeight && rect.bottom >= 0;
        
        if (isInViewport && !el.classList.contains('visible')) {
            el.classList.add('visible');
            el.style.opacity = '1';
            el.style.transform = 'none';
        }
    });

    // Fix reveal elements yang tidak ter-observe
    document.querySelectorAll('.reveal').forEach(el => {
        const rect = el.getBoundingClientRect();
        const isInViewport = rect.top < window.innerHeight && rect.bottom >= 0;
        
        if (isInViewport && !el.classList.contains('visible')) {
            if (revealObserver) {
                revealObserver.observe(el);
            }
        }
    });
}
```

### 4. Scroll Reset Implementation

#### Immediate Scroll
```javascript
function finalizeRender(hash, animated) {
    // LANGSUNG scroll ke atas sebelum apapun
    window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
    
    // Force reset untuk browser compatibility
    if (document.scrollingElement) {
        document.scrollingElement.scrollTop = 0;
    }
    
    // Delay re-init untuk pastikan DOM ready
    window.setTimeout(() => {
        reinitializeComponents();
        
        // Second scroll attempt setelah re-init
        window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
    }, 50);
}
```

**Kenapa 2x scroll?**:
1. **Pertama**: Langsung setelah HTML inserted (instant)
2. **Kedua**: Setelah components re-initialized (jika ada yang mengubah scroll)

---

## Flow SPA Navigation (Updated)

```
User clicks link
    ↓
Prevent default navigation
    ↓
Fetch new content via AJAX
    ↓
Insert HTML into #main-content
    ↓
═══════════════════════════════════════
FINALIZE RENDER (new function)
═══════════════════════════════════════
    ↓
1. window.scrollTo(0, 0) - INSTANT
    ↓
2. document.scrollingElement.scrollTop = 0
    ↓
3. setTimeout(50ms) - Wait for DOM
    ↓
═══════════════════════════════════════
REINITIALIZE COMPONENTS
═══════════════════════════════════════
    ↓
Cleanup:
  - cleanupOldInstances()
  - cleanupModalInstances()
  - Destroy old slideshow
    ↓
Re-init Core:
  - setupScrollReveal() ✅
  - setupSlideshow() ✅
  - setupFacilityModal() ✅
  - setupPrestasiModal() ✅
  - setupNewsCategoryFilters() ✅ (with flag reset!)
    ↓
Re-init Layouts:
  - setupGridLayout() ✅
  - setupDynamicClickHandlers() ✅
    ↓
Event Delegation:
  - setupNewsCardDelegation() ✅
  - setupProgramCardDelegation() ✅
  - setupPrestasiCardDelegation() ✅
    ↓
External Libraries:
  - refreshExternalLibraries() ✅
    - AOS.init() + AOS.refresh()
    - fixHiddenContent()
    - Swiper.update()
    - Lightbox refresh
    ↓
Global UI:
  - window.reinitializeGlobalUI() ✅
    - Confirm modal
    - Scroll-to-top button
    - Card animations
    ↓
4. window.scrollTo(0, 0) - SECOND PASS
    ↓
✅ DONE - Page fully functional!
```

---

## File Changes Summary

### Modified: `public/js/spa.js`

#### 1. `finalizeRender()` - Enhanced
```diff
+ window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
+ document.scrollingElement.scrollTop = 0;
  
  setTimeout(() => {
      reinitializeComponents();
+     window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
  }, 50);
```

#### 2. `reinitializeComponents()` - Unchanged structure
- Already has try-catch for each component
- Already calls all necessary setup functions

#### 3. `setupNewsCategoryFilters()` - FIXED
```diff
  document.querySelectorAll('[data-news-filter-root]').forEach((root) => {
-     if (root.dataset.newsFilterInitialized === 'true') {
-         return; // ❌ Prevents re-init!
-     }
+     // ✅ Allow re-initialization
+     delete root.dataset.newsFilterInitialized;
      
      root.dataset.newsFilterInitialized = 'true';
      // ... rest of setup
  });
```

#### 4. `refreshExternalLibraries()` - ENHANCED
```diff
  if (typeof AOS !== 'undefined') {
+     if (typeof AOS.init === 'function') {
+         AOS.init(); // ✅ Re-init for new content
+     }
      if (typeof AOS.refresh === 'function') {
          AOS.refresh();
      }
+     
+     // ✅ Fix hidden elements
+     document.querySelectorAll('[data-aos]').forEach(el => {
+         el.style.opacity = '';
+         el.style.transform = '';
+     });
  }
  
+ fixHiddenContent(); // ✅ New function
```

#### 5. `fixHiddenContent()` - NEW FUNCTION
```javascript
function fixHiddenContent() {
    // Fix AOS-animated elements
    document.querySelectorAll('.aos-animate:not([class*="visible"])').forEach(el => {
        if (isInViewport && !visible) {
            el.classList.add('visible');
            el.style.opacity = '1';
            el.style.transform = 'none';
        }
    });

    // Fix reveal elements
    document.querySelectorAll('.reveal').forEach(el => {
        if (isInViewport && !visible && revealObserver) {
            revealObserver.observe(el);
        }
    });
}
```

#### 6. `setupDynamicClickHandlers()` - ENHANCED
```diff
  function setupDynamicClickHandlers() {
      setupFacilityCardClicks();
      setupPrestasiCardClicks();
+     setupProgramCardClicks(); // ✅ NEW
      setupGeneralClickHandlers();
+     setupNewsCardDelegation(); // ✅ NEW
+     setupProgramCardDelegation(); // ✅ NEW
+     setupPrestasiCardDelegation(); // ✅ NEW
  }
```

#### 7. Event Delegation Functions - NEW
```javascript
// ✅ NEW: setupNewsCardDelegation()
// ✅ NEW: setupProgramCardDelegation()
// ✅ NEW: setupPrestasiCardDelegation()
// ✅ NEW: openPrestasiModal()
// ✅ NEW: closePrestasiModal()
```

---

## Testing Guide

### Test 1: Scroll Reset
1. Buka halaman Home
2. Scroll ke bawah
3. Klik "Berita" di navbar
4. **Expected**: Halaman langsung scroll ke atas (tidak smooth)
5. **Expected**: Konten berita terlihat dari atas

### Test 2: Filter Berita
1. Navigasi ke halaman Berita via SPA
2. Klik category button (misal: "Pengumuman")
3. **Expected**: Filter langsung bekerja
4. **Expected**: Hanya berita kategori terpilih yang muncul
5. Klik "Semua"
6. **Expected**: Semua berita muncul kembali

### Test 3: Prestasi Modal
1. Navigasi ke halaman Prestasi via SPA
2. Klik salah satu card prestasi
3. **Expected**: Modal terbuka
4. Klik tombol close / klik di luar modal / tekan Escape
5. **Expected**: Modal tertutup
6. **Repeat**: Modal masih bisa dibuka lagi (tidak mati)

### Test 4: Program/Ekstrakurikuler
1. Navigasi ke halaman Program via SPA
2. Klik card ekstrakurikuler
3. **Expected**: Navigasi ke detail atau modal terbuka
4. **Expected**: Card responsive terhadap klik

### Test 5: AOS Animations
1. Navigasi ke halaman manapun via SPA
2. Scroll perlahan ke bawah
3. **Expected**: Elemen muncul dengan animasi (fade-in, slide, dll)
4. **Expected**: Tidak ada elemen yang stuck invisible
5. **Expected**: Semua `.reveal` elements terlihat saat di viewport

### Test 6: Multiple Navigation
1. Home → Berita → Prestasi → Fasilitas → Program
2. Di setiap halaman, test semua interaksi
3. **Expected**: Semua fitur bekerja di setiap halaman
4. **Expected**: Tidak ada yang "mati" setelah beberapa kali navigasi

---

## Console Logs yang Diharapkan

Setelah setiap SPA navigation berhasil:

```
[SPA] Grid layouts initialized
[SPA] Program card clicks setup
[SPA] News card delegation setup
[SPA] Program card delegation setup
[SPA] Prestasi card delegation setup
[SPA] Dynamic click handlers initialized
[SPA] AOS re-initialized
[SPA] AOS refreshed
[SPA] Hidden content fixed
[SPA] External libraries refreshed
[GlobalUI] Components reinitialized after SPA navigation
[SPA] Components reinitialized successfully
```

Jika ada error:
```
[SPA] Error in <function-name>: <error details>
```

---

## Performance Impact

### Before:
- ❌ Event listeners hilang setelah DOM update
- ❌ Harus refresh halaman untuk restore functionality
- ❌ AOS elements stuck invisible

### After:
- ✅ Event delegation = 1 listener per type (efficient)
- ✅ No refresh needed, semua otomatis
- ✅ AOS auto-refreshed setiap navigation
- ✅ Scroll always reset ke atas

### Memory Usage:
- **Before**: N listeners per page × M pages visited = O(N×M) memory
- **After**: 1 delegation listener per type = O(1) memory

---

## Migration Notes

### Jika Menambah Halaman Baru dengan Cards

**Untuk cards yang perlu klik**:

Option 1: Event Delegation (Recommended)
```javascript
// Tambah di setupDynamicClickHandlers()
document.addEventListener('click', (e) => {
    const card = e.target.closest('[data-my-card]');
    if (card) {
        handleMyCard(card);
    }
});
```

Option 2: Direct Setup (jika perlu re-init)
```javascript
function setupMyCardClicks() {
    document.querySelectorAll('[data-my-card]').forEach(card => {
        const newCard = card.cloneNode(true);
        card.parentNode.replaceChild(newCard, card);
        newCard.addEventListener('click', () => handleMyCard(newCard));
    });
}

// Panggil di reinitializeComponents()
```

### Jika Menggunakan Library Animasi Baru

Tambahkan di `refreshExternalLibraries()`:
```javascript
if (typeof MyAnimationLibrary !== 'undefined') {
    if (typeof MyAnimationLibrary.init === 'function') {
        MyAnimationLibrary.init();
    }
    if (typeof MyAnimationLibrary.refresh === 'function') {
        MyAnimationLibrary.refresh();
    }
}
```

---

## Troubleshooting

### Problem: Modal masih tidak bisa dibuka setelah navigasi

**Check**:
1. Pastikan HTML card punya attribute `data-prestasi-card` atau `data-facility-card`
2. Check console untuk errors
3. Pastikan modal HTML ada di halaman tersebut

**Debug**:
```javascript
// Di browser console:
document.querySelectorAll('[data-prestasi-card]').length
// Harus > 0 jika ada card

document.getElementById('prestasi-modal')
// Harus return element, bukan null
```

### Problem: Filter berita tidak muncul

**Check**:
1. Pastikan halaman punya `[data-news-filter-root]`
2. Check `root.dataset.newsFilterInitialized` harus bisa di-delete
3. Verify buttons dan cards ada di DOM

**Debug**:
```javascript
document.querySelectorAll('[data-news-filter-root]').length
document.querySelectorAll('[data-news-category-button]').length
document.querySelectorAll('[data-news-card]').length
```

### Problem: Elemen masih invisible (AOS issue)

**Check**:
1. Inspect element, cek apakah ada class `aos-animate`
2. Cek inline styles: `opacity`, `transform`
3. Force visible manual:

```javascript
// Emergency fix di console:
document.querySelectorAll('[data-aos]').forEach(el => {
    el.style.opacity = '1';
    el.style.transform = 'none';
});
```

### Problem: Scroll tidak reset

**Check**:
1. Apakah ada `window.scrollTo` dipanggil?
2. Apakah ada smooth scroll yang override instant scroll?
3. Force manual:

```javascript
// Emergency fix di console:
window.scrollTo(0, 0);
document.scrollingElement.scrollTop = 0;
document.documentElement.scrollTop = 0;
document.body.scrollTop = 0;
```

---

## Summary

✅ **Click Events**: Event delegation untuk Prestasi, Program, Facility cards
✅ **Filter Berita**: Re-initialization dengan flag reset
✅ **AOS/Animations**: Auto init + refresh + fix hidden content
✅ **Scroll Reset**: Double scroll attempt (before & after re-init)
✅ **Memory Efficient**: Delegation pattern, no duplicate listeners
✅ **Error Handling**: Try-catch untuk setiap komponen
✅ **Console Logging**: Debug friendly dengan labeled logs

**Status**: SPA navigation sekarang **fully functional** tanpa perlu refresh manual! 🎉
