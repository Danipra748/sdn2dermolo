# 🧪 Testing Guide - Slideshow Save Fix

**Quick reference for testing the slideshow save functionality**

---

## 🎯 Test Scenario: Save Slideshow Images

### Pre-requisites:
- ✅ Logged into admin panel
- ✅ Have 3-5 images ready (JPG, PNG, or WebP)
- ✅ Browser DevTools open (F12)

---

## 📝 Step-by-Step Test

### Step 1: Navigate to Hero Editor

**Path:** Admin Panel → Konten Publik → Pengaturan Beranda → Edit Hero

**Expected:**
- ✅ Page loads
- ✅ Form shows current hero settings
- ✅ Media Library section visible

---

### Step 2: Upload Images

**Action:** Click **"📸 Upload New"** button

**Expected:**
- ✅ File picker opens
- ✅ Can select multiple files
- ✅ Upload starts immediately

**During Upload:**
```
Console: Upload response: {success: true, paths: [...]}
Media Library: Shows "⏳ Uploading 3 file(s)..."
```

**After Upload:**
- ✅ Images appear in Media Library
- ✅ Images auto-selected (blue border)
- ✅ Count updates: "📁 Media Library (3)"

---

### Step 3: Select/Deselect Images

**Action:** Click on images in Media Library

**Expected:**
- ✅ Click once = Select (blue border appears)
- ✅ Click again = Deselect (border disappears)
- ✅ Selected count updates
- ✅ Auto-save triggers (check Network tab)

**Network Tab Check:**
```
Request: POST /admin/homepage/hero/media/save-selected
Status: 200 OK
Payload: {"selected_images":["img1.jpg","img2.jpg"]}
Response: {"success":true,"count":2}
```

---

### Step 4: Save Changes

**Action:** Click **"Simpan Perubahan"**

**Expected Sequence:**

**1. Immediate (0ms):**
- ✅ Button text changes: "⏳ Menyimpan..."
- ✅ Button disabled (gray, not clickable)
- ✅ Console: "✅ Images saved successfully..."

**2. During Save (0-500ms):**
- ✅ Network tab: `save-selected` request
- ✅ Network tab: Form POST request
- ✅ Console: "✓ Saved 2 images for slideshow"

**3. Success (500-1000ms):**
- ✅ Green notification appears (top-right)
- ✅ Text: "✅ Berhasil menyimpan 2 gambar untuk slideshow!"
- ✅ Notification fades after 3 seconds

**4. Redirect (1-2 seconds):**
- ✅ Page redirects to Homepage Settings
- ✅ Flash message: "Hero Section berhasil diupdate!"

---

### Step 5: Verify Save

**Action:** Refresh page or navigate back to Hero Editor

**Expected:**
- ✅ Previously selected images still shown
- ✅ Selected count matches what you saved
- ✅ Images in correct order (1st = primary)

**Database Check:**
```sql
SELECT 
    section_key,
    background_image,
    JSON_EXTRACT(extra_data, '$.slideshow_images') as slideshow
FROM homepage_sections 
WHERE section_key = 'hero';
```

**Expected Result:**
```
section_key: 'hero'
background_image: 'homepage-backgrounds/img1.jpg'
slideshow: ['homepage-backgrounds/img2.jpg', 'homepage-backgrounds/img3.jpg']
```

---

### Step 6: Check Homepage

**Action:** Open homepage in new tab and refresh

**Expected:**
- ✅ Hero section shows uploaded images
- ✅ Slideshow auto-plays every 5 seconds
- ✅ Smooth fade transitions
- ✅ Console: "🎬 Hero slideshow started: 3 slides"

---

## ✅ Success Checklist

- [ ] Upload button works
- [ ] Can select multiple images
- [ ] Images preview in Media Library
- [ ] Click to select/deselect works
- [ ] Selected count updates
- [ ] Save button shows loading state
- [ ] Green notification appears on success
- [ ] Page redirects after save
- [ ] Success message shows
- [ ] Images persist after refresh
- [ ] Homepage displays slideshow
- [ ] Slideshow auto-plays

---

## 🐛 Error Scenarios to Test

### Test 1: Save with No Images

**Steps:**
1. Deselect all images
2. Click "Simpan Perubahan"

**Expected:**
- ✅ Saves successfully
- ✅ Clears all images from database
- ✅ Notification: "✅ Berhasil menyimpan 0 gambar..."
- ✅ Homepage shows gradient fallback

---

### Test 2: Save with One Image

**Steps:**
1. Select only 1 image
2. Click "Simpan Perubahan"

**Expected:**
- ✅ Saves successfully
- ✅ Database: `background_image` = that image
- ✅ Database: `slideshow_images` = empty array
- ✅ Homepage shows static image (no slideshow)

---

### Test 3: Network Error

**Steps:**
1. Disconnect internet
2. Click "Simpan Perubahan"

**Expected:**
- ✅ Button shows "⏳ Menyimpan..."
- ✅ After timeout: Button re-enables
- ✅ Red notification: "❌ Gagal menyimpan..."
- ✅ Console: Error message
- ✅ Form does NOT submit

---

### Test 4: Server Error

**Simulate:** Comment out saveSelectedImages route temporarily

**Expected:**
- ✅ Click save
- ✅ Red notification appears
- ✅ Console: Error details
- ✅ Button re-enables
- ✅ User can try again

---

## 🔍 Debug Checklist

### If save doesn't work:

**1. Console Check (F12 → Console)**
```
Look for:
✅ "✅ Images saved successfully..."
❌ "Error saving selected images"
❌ Red error messages
```

**2. Network Check (F12 → Network)**
```
Filter: "save-selected"
Check:
✅ Status: 200 OK
✅ Method: POST
✅ Payload has selected_images
✅ Response has success: true
```

**3. Form Check**
```
Inspect form element:
✅ action="/admin/homepage/hero"
✅ method="POST"
✅ enctype="multipart/form-data"
✅ CSRF token present
```

**4. Laravel Logs**
```bash
tail -f storage/logs/laravel.log
```

**Look for:**
```
✅ "Hero save: Starting save process"
✅ "Hero save: Successfully updated"
❌ "Hero save: Failed to save"
❌ Any error messages
```

---

## 📊 Performance Benchmarks

### Good Performance:
- **Upload start:** Immediate
- **Upload complete:** < 3 seconds per image
- **Save AJAX:** < 500ms
- **Form submit:** < 2 seconds
- **Total flow:** < 10 seconds

### Check with DevTools:
1. F12 → Performance tab
2. Start recording
3. Click save
4. Stop recording after redirect
5. Check timeline for bottlenecks

---

## 🎨 Visual Reference

### Success Notification:
```
┌─────────────────────────────────────────┐
│ ✅ Berhasil menyimpan 3 gambar untuk    │
│    slideshow!                           │
└─────────────────────────────────────────┘
     (Green background, top-right)
```

### Loading State:
```
┌────────────────────────────┐
│  ⏳ Menyimpan...           │  (Disabled, gray)
└────────────────────────────┘
```

### Normal State:
```
┌────────────────────────────┐
│  Simpan Perubahan          │  (Active, dark blue)
└────────────────────────────┘
```

---

## 📞 Report Issues

**If test fails, provide:**

1. **Screenshot of:**
   - Browser console (F12)
   - Network tab request/response
   - Error notification

2. **Describe:**
   - What step failed?
   - What did you expect?
   - What actually happened?

3. **Logs:**
   ```bash
   cat storage/logs/laravel.log | tail -100
   ```

4. **Browser info:**
   - Browser name & version
   - OS
   - Screen resolution

---

**Test Guide Version:** 1.0  
**Last Updated:** 2026-04-02  
**Status:** Ready for testing  
**Estimated Test Time:** 10 minutes
