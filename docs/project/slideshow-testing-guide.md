# 🧪 Slideshow Testing Guide

**Quick reference for testing the hero slideshow fix**

---

## 🚀 Quick Test (30 seconds)

### 1️⃣ Open Homepage
```
http://localhost/sdnegeri2dermolo/
```
*(or your local URL)*

### 2️⃣ Open Browser Console
**Press:** `F12` or `Ctrl + Shift + J` (Windows) / `Cmd + Option + J` (Mac)

### 3️⃣ Check Console Output
You should see:
```
✅ 🎬 Hero slideshow started: 3 slides, interval: 5s
✅ 🎬 Slideshow: Slide 2 of 3
✅ 🎬 Slideshow: Slide 3 of 3
```

### 4️⃣ Watch the Magic ✨
- Wait 5 seconds → Slide should change automatically
- Smooth fade transition (1.5 seconds)
- Continues looping through all slides

---

## 🎮 Interactive Tests

### Test 1: Pause on Hover
1. **Hover mouse** over the hero section
2. Check console → Should show: `⏸️ Slideshow paused on hover`
3. Slide should **stop changing**
4. **Move mouse away**
5. Check console → Should show: `▶️ Slideshow resumed`
6. Slide should **start changing again**

### Test 2: Multiple Slides
- **2+ images:** Slideshow active ✅
- **1 image:** Static image (no slideshow) ℹ️
- **0 images:** Gradient background (fallback) ℹ️

### Test 3: Transition Quality
Watch for:
- ✅ Smooth fade (no flickering)
- ✅ No white flash between slides
- ✅ Text remains readable during transition
- ✅ Overlay opacity consistent

---

## 🖼️ Upload Test (Admin Panel)

### Step-by-Step:

1. **Login to Admin**
   ```
   http://localhost/sdnegeri2dermolo/login
   ```

2. **Navigate to Homepage Settings**
   - Sidebar → **Konten Publik** → **Pengaturan Beranda**
   - Or: **Admin Panel** → **Homepage Settings**

3. **Upload Images**
   - Click **"📸 Upload New"** button
   - Select multiple images (max 5MB each)
   - Wait for upload to complete

4. **Select for Slideshow**
   - Click on images to select/deselect
   - Selected images get **blue border**
   - First image = Primary (👑 crown icon)
   - Order matters! (1st, 2nd, 3rd...)

5. **Save Changes**
   - Click **"Simpan Perubahan"**
   - Form will auto-save selections
   - Redirects to homepage settings

6. **Verify on Homepage**
   - Refresh homepage (Ctrl+F5)
   - Check console for slide count
   - Watch slideshow with new images

---

## 🐛 Common Issues & Solutions

### Issue: "Only 1 slide found"
**Console shows:**
```
ℹ️ Hero slideshow: only 1 slide(s) found - slideshow disabled
```

**Solution:**
1. Go to Admin Panel → Homepage Settings
2. Upload more images (minimum 2 for slideshow)
3. Select multiple images for slideshow
4. Save changes
5. Refresh homepage

---

### Issue: Images not loading
**Console shows:**
```
❌ 404 Not Found: /storage/path/to/image.jpg
```

**Solution:**
```bash
# Run in terminal (project root)
php artisan storage:link
```

Or check:
- Images uploaded to `storage/app/public/homepage-backgrounds/`
- Symlink exists: `public/storage` → `storage/app/public`

---

### Issue: Upload fails
**Error message:** "Gagal menyimpan pilihan gambar"

**Solutions:**
1. **Check file size** - Max 5MB per image
2. **Check file type** - JPG, PNG, WebP only
3. **Check storage permission** - Folder must be writable
4. **Clear browser cache** - Old JS might be cached

---

### Issue: Slideshow not smooth
**Symptoms:** Flickering, stuttering, or white flash

**Solutions:**
1. **Hard refresh:** Ctrl+F5
2. **Clear cache:** Ctrl+Shift+Delete
3. **Check browser** - Try Chrome/Firefox/Edge
4. **Reduce image size** - Large files load slowly

---

## 📱 Mobile Testing

### Test on Mobile Devices:
1. Open homepage on phone/tablet
2. Slideshow should auto-play
3. **Touch screen:** Swipe left/right (if implemented)
4. Check loading speed on mobile data
5. Verify text readability on small screens

### Responsive Check:
- [ ] Mobile (< 640px) - 1 column
- [ ] Tablet (640-1024px) - 2 columns
- [ ] Desktop (> 1024px) - 4 columns

---

## 🔍 Debug Checklist

If slideshow doesn't work, check these:

### Browser Console (F12):
- [ ] No red error messages
- [ ] Slideshow start message appears
- [ ] Slide change logs appear every 5s
- [ ] No CORS errors

### Elements Tab:
- [ ] `.hero-slide` elements exist
- [ ] Count matches uploaded images
- [ ] Inline styles show `opacity` and `z-index`
- [ ] Background images have valid URLs

### Network Tab:
- [ ] All images load successfully (200 OK)
- [ ] No 404 errors for images
- [ ] Images load within 2 seconds

### Admin Panel:
- [ ] Upload button works
- [ ] Images preview after upload
- [ ] Can select/deselect images
- [ ] Save button submits successfully

---

## 📊 Expected Results

### ✅ Success Indicators:

**Console:**
```
✅ 🎬 Hero slideshow started: 3 slides, interval: 5s
✅ 🎬 Slideshow: Slide 2 of 3
✅ 🎬 Slideshow: Slide 3 of 3
✅ ⏸️ Slideshow paused on hover
✅ ▶️ Slideshow resumed
```

**Visual:**
- ✅ Smooth fade transitions
- ✅ 5-second intervals
- ✅ Loops infinitely
- ✅ Pauses on hover
- ✅ Text always readable

**Upload:**
- ✅ Images upload successfully
- ✅ Can select multiple
- ✅ Saves to database
- ✅ Displays on homepage

---

## 🎯 Performance Benchmarks

### Good Performance:
- **First slide loads:** < 1 second
- **Transition smooth:** 60 FPS
- **No layout shift:** CLS < 0.1
- **Total load time:** < 3 seconds

### Check with Lighthouse:
1. Open DevTools (F12)
2. Go to **Lighthouse** tab
3. Run audit
4. Check **Performance** score
5. Look for image optimization suggestions

---

## 📞 Need Help?

If tests fail:

1. **Take screenshot** of console (F12)
2. **Note the error message**
3. **Check browser version**
4. **Test in different browser**
5. **Share results** with developer

---

**Last Updated:** 2026-04-02  
**Test Status:** Ready for testing  
**Cache Status:** Clear before testing!
