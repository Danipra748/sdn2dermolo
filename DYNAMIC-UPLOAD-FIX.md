# Dynamic Logo & Foto Kepala Sekolah Upload Fix

## 📋 Overview
Fixed the dynamic upload feature for **Logo Sekolah** and **Foto Kepala Sekolah** so that upload fields are always visible in admin forms, allowing you to add/replace photos anytime without breaking the database structure.

---

## ✅ Changes Made

### 1. **Controller Updates**

#### `app/Http/Controllers/AdminSchoolProfileController.php`
- ✅ **Simplified logo upload logic** - Removed excessive debug logging
- ✅ **Safe file handling** - Only processes logo if `hasFile('logo')` returns true
- ✅ **Preserves existing data** - If no file uploaded, old logo stays in database
- ✅ **Update pattern** - Uses `$profile->update($validated)` which only updates sent fields

**Key Logic:**
```php
// Only handle upload if file exists
if ($request->hasFile('logo')) {
    // Delete old logo
    // Store new logo
    // Add to $validated array
}
// Update profile (logo field only updated if new file was uploaded)
$profile->update($validated);
```

#### `app/Http/Controllers/AdminSettingsController.php`
- ✅ **Added try-catch error handling** for both upload and delete methods
- ✅ **Better error messages** with logging for debugging

---

### 2. **Model Updates**

#### `app/Models/SiteSetting.php`

**`uploadFotoKepsek()` method:**
- ✅ Uses `updateOrCreate()` to ensure row always exists
- ✅ Wraps logic in try-catch for safety
- ✅ Deletes old photo before storing new one

**`deleteFotoKepsek()` method:**
- ✅ **Sets value to `null` instead of deleting row**
- ✅ Keeps database structure intact
- ✅ Allows immediate re-upload after deletion

**Key Pattern:**
```php
// Instead of deleting the row, set foto_kepsek to null
static::updateOrCreate(
    ['key' => 'foto_kepsek'],
    ['foto_kepsek' => null]  // ← Null, not deleted!
);
```

---

### 3. **Blade View Updates**

#### `resources/views/admin/school-profile/edit.blade.php`

**Added permanent Logo Upload Section:**
- ✅ **Always visible** - Shows even when logo is null
- ✅ **Two-column layout:**
  - Left: Upload input + delete button (if logo exists)
  - Right: Preview of current logo or placeholder
- ✅ **Live preview** - JavaScript updates preview when new file selected
- ✅ **Clear instructions** - Helper text explains file requirements

**Features:**
```blade
@if ($profile->logo)
    <!-- Show current logo preview + delete button -->
@else
    <!-- Show placeholder "Belum ada logo" -->
@endif

<!-- Upload field ALWAYS visible -->
<input type="file" name="logo" accept=".jpg,.jpeg,.png,.svg" onchange="previewLogo(event)">
```

#### `resources/views/admin/settings_hidden.blade.php`

**Enhanced Foto Kepsek Section:**
- ✅ **Always visible upload field** with helper text
- ✅ **Better placeholder** when no photo exists
- ✅ **Updated button label** - "Upload / Ganti Foto Kepala Sekolah"
- ✅ **Clear preview section** labeled "Preview Foto Baru (Akan Diupload)"

---

### 4. **Migration Verification**

#### ✅ Confirmed Nullable Columns

**`school_profiles` table:**
```php
$table->string('logo')->nullable();  // ✅ Already nullable
```

**`site_settings` table:**
```php
$table->string('foto_kepsek')->nullable()->after('hero_image');  // ✅ Already nullable
```

**No migration changes needed** - Both columns were already configured correctly!

---

## 🎯 How It Works Now

### Logo Sekolah (School Profile Page)
1. **Navigate to:** Admin → Profil Sekolah
2. **Logo section** is always visible at bottom of form
3. **Current scenarios:**
   - ✅ **No logo:** Shows placeholder → Upload to add
   - ✅ **Has logo:** Shows preview → Upload to replace OR delete
   - ✅ **Upload without deleting:** Old logo auto-deleted when new one uploaded
   - ✅ **Delete then upload:** Field stays visible → Upload anytime

### Foto Kepala Sekolah (Hidden Settings Page)
1. **Navigate to:** Admin → Hidden Settings
2. **Upload field** is always visible in "Foto Resmi Kepala Sekolah" section
3. **Current scenarios:**
   - ✅ **No photo:** Shows placeholder → Upload to add
   - ✅ **Has photo:** Shows preview → Upload to replace OR delete
   - ✅ **Upload:** Old photo auto-deleted, new photo stored
   - ✅ **Delete:** Database row preserved with `null` value → Upload field still works

---

## 🔧 Technical Details

### Database Safety
- **No rows are ever deleted** when you delete a photo
- **Columns stay `nullable`** - allows empty values
- **`updateOrCreate()` pattern** ensures row exists before upload

### File Storage
```
storage/app/public/
├── school-profile/       ← Logo files
└── kepala-sekolah/       ← Foto Kepala Sekolah files
```

### Validation Rules
**Logo:**
- Types: JPEG, PNG, JPG, SVG
- Max size: 2MB
- Optional: `nullable|image|mimes:jpeg,png,jpg,svg|max:2048`

**Foto Kepsek:**
- Types: JPEG, JPG, PNG, WebP
- Max size: 3MB
- Required for upload: `required|image|mimes:jpeg,jpg,png,webp|max:3072`

---

## 🚀 Testing Checklist

After applying changes, test these scenarios:

### Logo Testing
- [ ] Visit Profil Sekolah page → Logo upload field is visible
- [ ] Upload a logo → Success message appears, logo shows in preview
- [ ] Upload different logo → Old logo replaced, new one shows
- [ ] Delete logo → Logo removed, upload field still visible
- [ ] Upload after delete → Works without errors
- [ ] Save form without uploading logo → Other fields save, logo unchanged

### Foto Kepsek Testing
- [ ] Visit Hidden Settings → Foto Kepsek upload field is visible
- [ ] Upload a photo → Success message, photo shows in preview
- [ ] Upload different photo → Old photo replaced, new one shows
- [ ] Delete photo → Photo removed, upload field still visible
- [ ] Upload after delete → Works without errors

---

## 📝 Best Practices

1. **Always backup** before uploading new files
2. **Optimize images** before upload (compress to reduce file size)
3. **Use consistent naming** for logo files (e.g., `logo-sekolah.png`)
4. **Test in staging** before production deployment
5. **Clear browser cache** if preview doesn't update

---

## 🐛 Troubleshooting

### Issue: Upload field not showing
**Solution:** Hard refresh browser (`Ctrl+F5` or `Cmd+Shift+R`)

### Issue: "File too large" error
**Solution:** Compress image to meet size limits (2MB for logo, 3MB for foto)

### Issue: Old logo not deleted
**Solution:** Check `storage/app/public/school-profile/` folder permissions

### Issue: Preview not updating
**Solution:** Clear browser cache or use incognito mode

---

## 📌 Summary

✅ **Upload fields are now permanent** - Always visible regardless of data state  
✅ **Safe deletion** - Sets to `null` instead of deleting database rows  
✅ **Auto-replacement** - Old files deleted when new ones uploaded  
✅ **Error handling** - Try-catch blocks prevent crashes  
✅ **User-friendly** - Clear previews and instructions  

Your upload system is now **robust, dynamic, and production-ready**! 🎉
