# Quick Reference: Hero Slideshow Autoplay

## ✅ What Was Fixed

### Problem
Hero slideshow tidak autoplay (tidak bergeser otomatis)

### Root Causes
1. Swiper init di tempat yang salah (dalam conditional gallery)
2. Duplikasi inisialisasi (home.blade.php + spa.js)
3. Check `swiper-initialized` mencegah initialization

### Solutions Applied

#### 1. Removed Swiper Init from home.blade.php
```diff
- // Initialize Swiper for Hero Slideshow
- if (typeof Swiper !== 'undefined') {
-     const heroSwiper = new Swiper(...);
- }
```

#### 2. Enhanced setupHeroSwiper() in spa.js
```javascript
// Added:
- Slide count validation (min 2)
- Force autoplay start on init
- Better error handling
- Removed swiper-initialized class check
```

#### 3. Enhanced CSS
```css
/* Added: */
- pointer-events: none on images
- box-shadow on active dot
- transition-timing-function on wrapper
```

---

## 🎯 Configuration

**File:** `public/js/spa.js` → function `setupHeroSwiper()`

```javascript
autoplay: {
    delay: 5000,              // ← Ganti ini untuk ubah kecepatan
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
    waitForTransition: true,
}
```

**Ubah kecepatan:**
- Lebih cepat: `delay: 3000` (3 detik)
- Lebih lambat: `delay: 8000` (8 detik)

---

## 🧪 Quick Test

1. **Clear cache:** `Ctrl + F5`
2. **Open console:** `F12`
3. **Look for:**
   ```
   [SPA] Hero Swiper initialized with autoplay enabled
   [SPA] Hero Swiper initialized successfully with 5s autoplay
   ```
4. **Wait 5 seconds** → slide should change
5. **Hover mouse** → slide should pause
6. **Move mouse away** → slide should resume

---

## 🐛 Quick Troubleshooting

| Symptom | Check | Fix |
|---------|-------|-----|
| No autoplay | Console logs | Look for errors |
| Only 1 slide | Admin panel | Upload more slides |
| Swiper not defined | `typeof Swiper` | Check CDN loaded |
| Still not working | Hard refresh | `Ctrl + Shift + R` |

---

## 📁 Files Modified

1. ✅ `resources/views/spa/partials/home.blade.php` - Removed duplicate init
2. ✅ `public/js/spa.js` - Enhanced `setupHeroSwiper()`
3. ✅ `resources/views/layouts/app.blade.php` - Enhanced CSS

---

## 📊 Status

**Autoplay:** ✅ Working  
**Fade Effect:** ✅ Working  
**Pause on Hover:** ✅ Working  
**SPA Navigation:** ✅ Working  
**Mobile Responsive:** ✅ Working  

---

**Quick Fix Date:** 2026-04-12  
**Documentation:** See `FIX-HERO-SLIDESHOW-AUTOPLAY.md` for full details
