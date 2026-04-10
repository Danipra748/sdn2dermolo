# 🗺️ OpenStreetMap Migration Guide

## ✅ Setup Complete - Ready to Migrate!

### 📋 What Was Created:

1. **Migration File**: `database/migrations/2025_01_03_000000_add_coordinates_to_site_settings.php`
2. **Seeder File**: `database/seeders/CoordinateSeeder.php`
3. **Web Routes**: `routes/migration.php` (for development)
4. **Updated Files**:
   - `app/Models/SiteSetting.php` - Added coordinate methods
   - `app/Http/Controllers/AdminKontakController.php` - Added coordinate handling
   - `resources/views/admin/kontak/form.blade.php` - Added interactive map
   - `resources/views/home.blade.php` - Added public map display

---

## 🚀 How to Run Migration (Choose ONE method):

### **Method 1: Via Web Browser (RECOMMENDED - No CLI needed)**

1. **Open your browser**
2. **Visit**: `http://127.0.0.1:8000/_migrate-coordinates`
3. **Wait for response** - Should show:
   ```json
   {
     "status": "success",
     "message": "Migration completed successfully!",
     "details": [
       "Columns added: school_latitude, school_longitude, map_zoom",
       "Default coordinates set: -6.8283, 110.6536 (Jepara)",
       "Default zoom: 15"
     ]
   }
   ```
4. **Verify**: Visit `http://127.0.0.1:8000/_check-columns`
   ```json
   {
     "status": "success",
     "columns": {
       "school_latitude": "EXISTS ✅",
       "school_longitude": "EXISTS ✅",
       "map_zoom": "EXISTS ✅"
     },
     "ready": true
   }
   ```

---

### **Method 2: Via Command Line (If PHP available)**

```bash
cd c:\laragon\www\sdnegeri2dermolo

# Run migration
php artisan migrate

# Run seeder (optional - migration already sets defaults)
php artisan db:seed --class=CoordinateSeeder

# Or seed all
php artisan db:seed
```

---

## ✅ Post-Migration Checklist:

### **1. Test Admin Panel**
- [ ] Visit: `http://127.0.0.1:8000/admin/kontak-sekolah`
- [ ] See interactive OpenStreetMap
- [ ] Click on map → Pin appears
- [ ] Drag pin → Coordinates update
- [ ] Click "Simpan Kontak" → No errors

### **2. Test Public Page**
- [ ] Visit: `http://127.0.0.1:8000/`
- [ ] Scroll to "Kontak" section
- [ ] See static map with school pin
- [ ] Click "Buka di OpenStreetMap" → Opens in new tab

### **3. Test Coordinate Features**
- [ ] Admin can click map to place pin
- [ ] Coordinates auto-fill in input fields
- [ ] Manual coordinate input moves pin
- [ ] "Lokasi Saya" button works (GPS)
- [ ] Save persists to database

---

## 🔧 Troubleshooting:

### **Error: "Column 'school_latitude' not found"**

**Solution**: Migration hasn't run yet.

1. Visit: `http://127.0.0.1:8000/_migrate-coordinates`
2. Check response shows "success"
3. Refresh your admin page

---

### **Error: "Table 'school_profiles' already exists"**

**Solution**: Old migration file was deleted.

This error is **FIXED** - the conflicting migration file was removed.
Just run the coordinate migration via web browser.

---

### **Map Not Showing**

**Check**:
1. Browser console for errors (F12)
2. Leaflet.js loaded? Check Network tab
3. Coordinates valid? (-90 to 90, -180 to 180)

**Solution**:
```javascript
// In browser console, check:
console.log(typeof L); // Should be "function"
console.log(latitude, longitude); // Should be numbers
```

---

## 📊 Database Schema:

After migration, `site_settings` table will have:

```sql
+--------------------+---------------+------+-----+---------+----------------+
| Field              | Type          | Null | Key | Default | Extra          |
+--------------------+---------------+------+-----+---------+----------------+
| school_latitude    | decimal(10,8) | YES  |     | NULL    |                |
| school_longitude   | decimal(11,8) | YES  |     | NULL    |                |
| map_zoom           | int           | YES  |     | 15      |                |
+--------------------+---------------+------+-----+---------+----------------+
```

---

## 🎯 Default Values:

After migration/seeding:

```
Latitude:  -6.82830000  (Jepara, Central Java)
Longitude: 110.65360000
Zoom:      15
```

These are **placeholder coordinates** (Jepara center).
Admin should update to actual school location via `/admin/kontak-sekolah`.

---

## 🧪 Testing Coordinates:

### **Test Data (Jepara Landmarks)**:

| Location | Latitude | Longitude | Zoom |
|----------|----------|-----------|------|
| **Jepara Center** | -6.8283 | 110.6536 | 15 |
| **Kartini Park** | -6.8150 | 110.6700 | 16 |
| **Pulau Panjang** | -6.8000 | 110.7000 | 14 |
| **Mount Muria** | -6.7500 | 110.8000 | 13 |

Try these coordinates in admin panel to test!

---

## 📝 Cleanup (Before Production):

**IMPORTANT**: Remove development routes!

Delete or comment out in `routes/migration.php`:

```php
// REMOVE THESE IN PRODUCTION!
Route::get('/_migrate-coordinates', ...);
Route::get('/_check-columns', ...);
```

These routes are **ONLY for development** and should **NEVER** be in production!

---

## ✅ Success Indicators:

After migration, you should see:

1. ✅ No errors when saving contact form
2. ✅ Interactive map in admin panel
3. ✅ Static map in public contact section
4. ✅ Coordinates persist in database
5. ✅ Pin placement works correctly
6. ✅ Two-way sync (map ↔ coordinates)

---

## 🎉 Ready to Use!

Once migration is complete:

1. **Admin can set school location** via interactive map
2. **Public can see school location** on contact page
3. **Coordinates stored in database** for future use
4. **No Google Maps dependency** - Using OpenStreetMap (free!)

---

**Next Step**: Run migration via `http://127.0.0.1:8000/_migrate-coordinates` 🚀
