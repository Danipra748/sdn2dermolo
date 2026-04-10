# 🗺️ OpenStreetMap Interactive Location Picker - Planning Document

**Project**: SD N 2 Dermolo - School Location Management  
**Version**: 1.0.0  
**Created**: 2026-04-01  
**Status**: 📋 Pending Review  

---

## 📋 Table of Contents

1. [Executive Summary](#executive-summary)
2. [Current Problems](#current-problems)
3. [Proposed Solution](#proposed-solution)
4. [Technical Specifications](#technical-specifications)
5. [Database Design](#database-design)
6. [User Interface Design](#user-interface-design)
7. [Implementation Plan](#implementation-plan)
8. [Testing Strategy](#testing-strategy)
9. [Performance Optimization](#performance-optimization)
10. [Security Considerations](#security-considerations)
11. [Timeline & Estimates](#timeline--estimates)
12. [Open Questions](#open-questions)

---

## Executive Summary

### 🎯 Objectives

Mengganti Google Maps dengan **OpenStreetMap (Leaflet.js)** untuk:
- ✅ Interactive pin placement (klik map untuk set lokasi)
- ✅ Manual coordinate input (latitude/longitude)
- ✅ Two-way sync (map ↔ coordinates)
- ✅ Real-time preview
- ✅ Free & open source (no API key required)
- ✅ Better privacy & no usage limits

### 📊 Current vs Proposed

| Feature | Google Maps (Current) | OpenStreetMap (Proposed) |
|---------|----------------------|---------------------------|
| **Cost** | Free tier limits | ✅ Completely free |
| **API Key** | Required | ✅ Not required |
| **Interactive Pin** | ❌ No | ✅ Yes |
| **Coordinate Input** | ❌ No | ✅ Yes |
| **Two-way Sync** | ❌ No | ✅ Yes |
| **Usage Limits** | Yes (28,000/month) | ✅ Unlimited |
| **Privacy** | Google tracking | ✅ Privacy-friendly |
| **Customization** | Limited | ✅ Highly customizable |

---

## Current Problems

### 🐛 Issues with Google Maps Implementation

1. **Short URL Issues**
   - `maps.app.goo.gl` URLs don't embed properly
   - Pin location often inaccurate
   - No way to verify location before saving

2. **No Interactive Features**
   - Admin cannot place pin on map
   - Cannot verify exact location
   - Must manually find and copy URL

3. **Poor UX**
   - No preview in admin panel
   - Cannot adjust location easily
   - Requires external Google Maps app

4. **Technical Limitations**
   - Embed URL conversion complex
   - Different URL formats cause issues
   - iframe sometimes doesn't load

---

## Proposed Solution

### 🎨 OpenStreetMap + Leaflet.js Implementation

#### **Technology Stack**

```
Frontend:
├── Leaflet.js 1.9.4      (Map library)
├── OpenStreetMap         (Map tiles)
├── Leaflet.Draw          (Pin placement)
└── Vanilla JavaScript    (No framework needed)

Backend:
├── Laravel 12.x
├── PHP 8.3+
└── MySQL 8.0

Storage:
├── latitude (DECIMAL)
└── longitude (DECIMAL)
```

#### **Key Features**

1. **Interactive Map**
   - Click to place pin
   - Drag to adjust position
   - Zoom in/out for precision
   - Real-time coordinate display

2. **Dual Input Methods**
   - **Method A**: Click map → Auto-fill coordinates
   - **Method B**: Enter coordinates → Move pin

3. **Live Preview**
   - See pin location immediately
   - Update on both map click and coordinate change
   - Visual confirmation before save

4. **Public Display**
   - Show school location on contact page
   - Static pin (not editable)
   - Click to open in OSM app

---

## Technical Specifications

### 📦 Dependencies

#### **CDN Resources** (No npm needed)
```html
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
```

#### **Optional: Local Installation**
```bash
npm install leaflet --save
```

### 🔧 Map Configuration

```javascript
const mapConfig = {
    defaultCenter: [-6.8283, 110.6536], // Jepara, Central Java
    defaultZoom: 13,
    minZoom: 1,
    maxZoom: 19,
    tileLayer: {
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }
};
```

### 📍 Coordinate System

```
Format: Decimal Degrees (DD)
Latitude:  -90.000000 to 90.000000
Longitude: -180.000000 to 180.000000
Precision: 6 decimal places (~0.1m accuracy)

Example:
Latitude:  -6.828300
Longitude: 110.653600
```

---

## Database Design

### 🗄️ Schema Changes

#### **Option A: Add to Existing `site_settings` Table** (RECOMMENDED)

```sql
ALTER TABLE `site_settings` 
ADD COLUMN `school_latitude` DECIMAL(10, 8) DEFAULT NULL AFTER `maps_url`,
ADD COLUMN `school_longitude` DECIMAL(11, 8) DEFAULT NULL AFTER `school_latitude`;

-- Migrate existing data (optional)
-- Convert Google Maps URL to coordinates manually or keep NULL
```

**Pros:**
- ✅ No new table needed
- ✅ Simple migration
- ✅ Backwards compatible

**Cons:**
- ⚠️ Still have old `maps_url` column

---

#### **Option B: New `school_locations` Table**

```sql
CREATE TABLE `school_locations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT 'Main Campus',
  `latitude` DECIMAL(10, 8) NOT NULL,
  `longitude` DECIMAL(11, 8) NOT NULL,
  `zoom_level` INT NOT NULL DEFAULT 15,
  `is_primary` BOOLEAN NOT NULL DEFAULT TRUE,
  `address` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `primary_location` (`is_primary`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Pros:**
- ✅ Clean separation of concerns
- ✅ Support multiple locations (future campuses)
- ✅ Store additional location data

**Cons:**
- ⚠️ More complex migration
- ⚠️ Need to update existing code

---

#### **Recommended: Hybrid Approach**

```sql
-- Keep existing maps_url for backwards compatibility
-- Add coordinate columns
ALTER TABLE `site_settings` 
ADD COLUMN `school_latitude` DECIMAL(10, 8) NULL AFTER `maps_url`,
ADD COLUMN `school_longitude` DECIMAL(11, 8) NULL AFTER `school_latitude`,
ADD COLUMN `map_zoom` INT NULL DEFAULT 15 AFTER `school_longitude`;

-- Default to Jepara center
UPDATE `site_settings` 
SET `school_latitude` = -6.8283, 
    `school_longitude` = 110.6536,
    `map_zoom` = 15
WHERE `key` = 'school_maps_url';
```

---

## User Interface Design

### 🎨 Admin Contact Form

```
┌─────────────────────────────────────────────────────────────┐
│  📍 Lokasi Sekolah                                          │
│                                                             │
│  ┌───────────────────────────────────────────────────────┐ │
│  │                                                       │ │
│  │          [Interactive OpenStreetMap]                  │ │
│  │                                                       │ │
│  │              📍 [Draggable Pin]                       │ │
│  │                                                       │ │
│  │  [Zoom In] [Zoom Out] [My Location] [Reset View]     │ │
│  │                                                       │ │
│  └───────────────────────────────────────────────────────┘ │
│                                                             │
│  Koordinat Lokasi:                                          │
│  ┌─────────────────────┐  ┌─────────────────────┐         │
│  │ Latitude            │  │ Longitude           │         │
│  │ [-6.828300      ]   │  │ [110.653600     ]   │         │
│  └─────────────────────┘  └─────────────────────┘         │
│                                                             │
│  💡 Cara menambahkan lokasi:                               │
│  1. Klik pada map untuk menempatkan pin, ATAU              │
│  2. Masukkan koordinat latitude & longitude manual         │
│  3. Drag pin untuk menyesuaikan posisi dengan tepat        │
│                                                             │
│  [Preview Location] [Clear Coordinates]                     │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

###  Public Contact Page

```
┌─────────────────────────────────────────────────────────────┐
│  📍 Lokasi Kami                                             │
│                                                             │
│  ┌───────────────────────────────────────────────────────┐ │
│  │                                                       │ │
│  │          [Static OpenStreetMap]                       │ │
│  │                                                       │ │
│  │              📍 [School Pin]                          │ │
│  │                                                       │ │
│  │  [View Larger Map] ← Opens in new tab                │ │
│  │                                                       │ │
│  └───────────────────────────────────────────────────────┘ │
│                                                             │
│  SD N 2 Dermolo                                            │
│  Desa Dermolo, Kec. Kembang, Kab. Jepara                   │
│  Jawa Tengah, 59453                                        │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

## Implementation Plan

### 📋 Phase 1: Database & Backend (Day 1)

#### **Task 1.1: Database Migration**
- [ ] Create migration file
- [ ] Add latitude/longitude columns
- [ ] Set default values (Jepara center)
- [ ] Test migration on staging

#### **Task 1.2: Model Updates**
- [ ] Update `SiteSetting` model (if using existing table)
- [ ] OR create `SchoolLocation` model (if new table)
- [ ] Add validation rules
- [ ] Add accessor/mutator for coordinates

#### **Task 1.3: Admin Controller**
- [ ] Create `AdminLocationController`
- [ ] Add `edit()` method
- [ ] Add `update()` method
- [ ] Add API endpoint for coordinate save

---

### 📋 Phase 2: Frontend - Admin Map (Day 2-3)

#### **Task 2.1: Map Component Setup**
- [ ] Include Leaflet CSS/JS
- [ ] Create map container div
- [ ] Initialize map with config
- [ ] Add tile layer (OSM)

#### **Task 2.2: Interactive Features**
- [ ] Add draggable marker
- [ ] Implement click-to-place-pin
- [ ] Add coordinate input fields
- [ ] Implement two-way sync (map ↔ inputs)

#### **Task 2.3: Map Controls**
- [ ] Zoom in/out buttons
- [ ] "My Location" button (geolocation API)
- [ ] "Reset View" button
- [ ] Search box (optional, Nominatim API)

#### **Task 2.4: Validation & Save**
- [ ] Validate coordinates range
- [ ] Auto-save on pin move (debounced)
- [ ] Manual save button
- [ ] Success/error notifications

---

### 📋 Phase 3: Frontend - Public Map (Day 4)

#### **Task 3.1: Static Map Display**
- [ ] Include Leaflet CSS/JS (lighter version)
- [ ] Create static map container
- [ ] Display school location pin
- [ ] Set appropriate zoom level

#### **Task 3.2: Map Optimization**
- [ ] Disable interactions (scrollWheelZoom, dragging)
- [ ] Add "Open in OSM" link
- [ ] Lazy load map
- [ ] Add loading skeleton

#### **Task 3.3: Responsive Design**
- [ ] Mobile-friendly sizing
- [ ] Touch-friendly controls
- [ ] Test on various devices

---

### 📋 Phase 4: Testing & Optimization (Day 5)

#### **Task 4.1: Functional Testing**
- [ ] Test pin placement
- [ ] Test coordinate input
- [ ] Test two-way sync
- [ ] Test save functionality
- [ ] Test public display

#### **Task 4.2: Performance Optimization**
- [ ] Lazy load maps
- [ ] Debounce coordinate updates
- [ ] Optimize tile loading
- [ ] Minimize API calls

#### **Task 4.3: Browser Testing**
- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari
- [ ] Mobile browsers

---

## Testing Strategy

### 🧪 Unit Tests

```php
// Test coordinate validation
public function test_coordinate_validation()
{
    $this->assertTrue(validateLatitude(-6.828300));
    $this->assertFalse(validateLatitude(-91.000000));
    $this->assertTrue(validateLongitude(110.653600));
    $this->assertFalse(validateLongitude(-181.000000));
}

// Test location save
public function test_location_save()
{
    $response = $this->put('/admin/location', [
        'latitude' => -6.828300,
        'longitude' => 110.653600
    ]);
    
    $response->assertStatus(200);
    $this->assertDatabaseHas('site_settings', [
        'school_latitude' => -6.828300,
        'school_longitude' => 110.653600
    ]);
}
```

### 🧪 Integration Tests

```javascript
// Test map click → coordinate update
describe('Map Interaction', () => {
    it('should update coordinates when map is clicked', () => {
        const map = L.map('map').setView([-6.8283, 110.6536], 13);
        
        map.on('click', (e) => {
            expect(e.latlng.lat).toBeCloseTo(-6.8283, 4);
            expect(e.latlng.lng).toBeCloseTo(110.6536, 4);
        });
        
        map.fire('click', { latlng: { lat: -6.8283, lng: 110.6536 } });
    });
});
```

### 🧪 Manual Testing Checklist

- [ ] Admin can click map to place pin
- [ ] Pin is draggable
- [ ] Coordinates update when pin moves
- [ ] Pin moves when coordinates change
- [ ] Save button works
- [ ] Public map displays correctly
- [ ] Map loads on mobile
- [ ] Coordinates persist after refresh

---

## Performance Optimization

### ⚡ Loading Optimization

```javascript
// 1. Lazy Load Map
const loadMap = () => {
    if (window.IntersectionObserver) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    initMap();
                    observer.unobserve(entry.target);
                }
            });
        });
        observer.observe(document.getElementById('map'));
    } else {
        initMap();
    }
};

// 2. Debounce Coordinate Updates
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

const updateCoordinates = debounce((lat, lng) => {
    // Save to database
}, 500);

// 3. Optimize Tile Loading
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    zoomOffset: -1,
    maxNativeZoom: 18,
    crossOrigin: true
});
```

### 📦 Asset Optimization

```html
<!-- Preload critical assets -->
<link rel="preload" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" as="style">
<link rel="preload" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" as="script">

<!-- Async load non-critical -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" media="print" onload="this.media='all'">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
```

---

## Security Considerations

### 🔒 Input Validation

```php
// Backend Validation
$validated = $request->validate([
    'school_latitude' => 'required|numeric|between:-90,90',
    'school_longitude' => 'required|numeric|between:-180,180',
    'map_zoom' => 'nullable|integer|between:1,19',
]);

// Sanitize coordinates
$latitude = round((float) $validated['school_latitude'], 6);
$longitude = round((float) $validated['school_longitude'], 6);
```

### 🔒 XSS Prevention

```javascript
// Escape user input in map popup
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Use textContent instead of innerHTML
marker.bindPopup(document.createTextNode('School Location'));
```

### 🔒 Rate Limiting

```php
// Prevent coordinate spam
Route::middleware(['throttle:60,1'])->group(function () {
    Route::put('/admin/location', [LocationController::class, 'update']);
});
```

---

## Timeline & Estimates

### 📅 Development Schedule

| Phase | Tasks | Duration | Status |
|-------|-------|----------|--------|
| **Phase 1** | Database & Backend | 1 day | ⏳ Pending |
| **Phase 2** | Frontend - Admin Map | 2 days | ⏳ Pending |
| **Phase 3** | Frontend - Public Map | 1 day | ⏳ Pending |
| **Phase 4** | Testing & Optimization | 1 day | ⏳ Pending |
| **Total** | | **5 days** | |

### 🎯 Milestone Checklist

- [ ] Database migration completed
- [ ] Admin map interactive & functional
- [ ] Two-way sync working perfectly
- [ ] Public map displaying correctly
- [ ] All tests passing
- [ ] Performance optimized
- [ ] Documentation complete
- [ ] Deployed to production

---

## Open Questions

### ❓ Questions for Review

1. **Map Provider Choice**
   - Use OpenStreetMap (default) or consider alternatives?
   - Alternatives: CartoDB, Mapbox (free tier), Stamen

2. **Coordinate Storage**
   - Store in existing `site_settings` table?
   - Or create new `school_locations` table for flexibility?

3. **Additional Features**
   - Add search functionality? (Nominatim API)
   - Add multiple location support? (future campuses)
   - Add location history/audit log?

4. **Map Styling**
   - Use default OSM style or custom theme?
   - Match school branding colors?

5. **Fallback Strategy**
   - What if coordinates are NULL? (show Jepara center)
   - What if map fails to load? (show static image or address)

6. **Admin UX**
   - Auto-save on pin move or manual save only?
   - Show confirmation dialog before clearing coordinates?

---

## Recommendations

### 💡 My Recommendations

1. **Use Hybrid Database Approach**
   - Add columns to `site_settings`
   - Keep `maps_url` for backwards compatibility
   - Gradually migrate to coordinates

2. **Implement Auto-save with Debounce**
   - Save coordinates 500ms after pin stops moving
   - Manual save button as backup
   - Show "Saving..." indicator

3. **Add "My Location" Feature**
   - Use browser Geolocation API
   - Quick way for admin to find current location
   - Fallback to manual input if denied

4. **Optimize for Mobile**
   - Touch-friendly controls
   - Larger tap targets
   - Responsive map sizing

5. **Provide Clear Instructions**
   - Tooltip on first visit
   - Help text below map
   - Example coordinates

---

## Appendix

### 📚 Resources & Documentation

- [Leaflet.js Documentation](https://leafletjs.com/reference.html)
- [OpenStreetMap Wiki](https://wiki.openstreetmap.org/wiki/Main_Page)
- [Nominatim Search API](https://nominatim.org/release-docs/develop/api/Search/)
- [Coordinate Format Guide](https://en.wikipedia.org/wiki/Decimal_degrees)

### 🔧 Code Snippets

#### Basic Map Initialization
```javascript
// Initialize map
const map = L.map('map').setView([-6.8283, 110.6536], 13);

// Add OSM tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Add marker
const marker = L.marker([-6.8283, 110.6536], {
    draggable: true
}).addTo(map);

// Handle map click
map.on('click', (e) => {
    marker.setLatLng(e.latlng);
    updateCoordinateInputs(e.latlng.lat, e.latlng.lng);
});

// Handle marker drag
marker.on('dragend', () => {
    const latlng = marker.getLatLng();
    updateCoordinateInputs(latlng.lat, latlng.lng);
});
```

---

**Document Status**: 📋 Ready for Review  
**Next Step**: Stakeholder review and feedback  
**Last Updated**: 2026-04-01
