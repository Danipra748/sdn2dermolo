# SPA Cache Invalidation Solution

## Problem Description
When navigating between pages (Data Guru → Berita → Data Guru), the SPA system was showing **stale cached data** instead of fresh content. Users had to manually refresh the browser to see updated data.

## Root Cause
The SPA system (`public/js/spa.js`) caches HTML responses in both:
1. **Memory Cache** (JavaScript Map)
2. **Session Storage** (Browser storage)

This cache mechanism was too aggressive - it never invalidated old data, causing:
- Outdated teacher lists when returning to Data Guru page
- Stale news articles on Berita page
- Old program data on Ekstrakurikuler pages

## Solution Implemented

### 1. **No-Cache Routes Configuration**
Added a list of routes that should **always fetch fresh data**:

```javascript
const config = {
    contentContainer: '#spa-content, #main-content',
    animationDuration: 220,
    loadingDelay: 200,
    cachePrefix: 'sdn2-dermolo-spa-cache:v3',
    // Routes that should always fetch fresh data (no cache)
    noCacheRoutes: [
        '/spa/data-guru',
        '/spa/berita',
        '/spa/prestasi',
        '/spa/sarana-prasarana',
        '/spa/program',
    ],
};
```

### 2. **Cache Bypass on Load**
Modified `loadContent()` to skip cache for no-cache routes:

```javascript
// Check if this route should bypass cache
const shouldBypassCache = config.noCacheRoutes.includes(route);

// Only use cache if route is not in noCacheRoutes list
const cachedData = shouldBypassCache ? null : getCachedResponse(route);
```

### 3. **HTTP Cache Busting**
Enhanced `fetchContent()` to add timestamp parameter and cache control headers:

```javascript
function fetchContent(route) {
    // Add cache-busting timestamp for no-cache routes
    const isNoCache = config.noCacheRoutes.includes(route);
    const cacheBustUrl = isNoCache ? `${route}?_t=${Date.now()}` : route;
    
    return fetch(cacheBustUrl, {
        headers: {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        // Add cache control for no-cache routes
        cache: isNoCache ? 'no-store' : 'default',
    })
    // ...
}
```

### 4. **Route Invalidation on Navigation**
Added automatic cache invalidation when leaving a page:

```javascript
function renderContent(contentArea, data, options = {}) {
    // ...
    
    // Invalidate cache for previous route if it's a no-cache route
    // This ensures fresh data when user navigates back
    const previousRoute = currentRoute;
    if (previousRoute && config.noCacheRoutes.includes(previousRoute)) {
        invalidateRouteCache(previousRoute);
    }
    
    // ...
}
```

### 5. **Cache Expiry Mechanism**
Added TTL (Time To Live) to prevent stale data even if cache is used:

```javascript
function getCachedResponse(route) {
    // Cache expiry time: 5 minutes (300,000 ms)
    const CACHE_TTL = 5 * 60 * 1000;
    
    if (memoryCache.has(route)) {
        const cached = memoryCache.get(route);
        
        // Check if cache is expired
        if (cached.timestamp && (Date.now() - cached.timestamp > CACHE_TTL)) {
            invalidateRouteCache(route);
            return null;
        }
        
        return cached;
    }
    // ...
}
```

### 6. **Cache Invalidation Functions**
Added helper functions for manual cache management:

```javascript
function invalidateRouteCache(route) {
    // Remove from memory cache
    memoryCache.delete(route);
    
    // Remove from session storage
    try {
        window.sessionStorage.removeItem(createCacheKey(route));
    } catch (error) {
        console.warn('Failed to invalidate route cache:', error);
    }
}

function invalidateAllNoCacheRoutes() {
    config.noCacheRoutes.forEach(route => {
        invalidateRouteCache(route);
    });
}
```

## How It Works

### Navigation Flow (Before)
1. User visits Data Guru → Data cached
2. User visits Berita → Data cached
3. User returns to Data Guru → **Shows old cached data** ❌

### Navigation Flow (After)
1. User visits Data Guru → Data fetched fresh, cached temporarily
2. User visits Berita → **Data Guru cache invalidated** ✅
3. User returns to Data Guru → **Fetches fresh data** ✅

## Benefits

✅ **Always Fresh Data**: No-cache routes always fetch latest data from server
✅ **Better UX**: Users see updated content without manual refresh
✅ **Smart Caching**: Static pages still benefit from fast cache
✅ **Automatic Cleanup**: Cache invalidated on navigation
✅ **Fallback Protection**: 5-minute TTL prevents stale data
✅ **HTTP Level**: Browser cache also busted with timestamp

## Modified Files

- `public/js/spa.js` - Main SPA routing file

## Testing

To verify the fix works:

1. Open browser DevTools → Network tab
2. Navigate to Data Guru page
3. Navigate to Berita page
4. Navigate back to Data Guru
5. **Check Network tab**: You should see a new request with `_t=` parameter
6. **Verify**: Data should be fresh, not from cache

## Future Improvements

- Add WebSocket/polling for real-time updates
- Implement stale-while-revalidate pattern
- Add manual "Refresh" button for users
- Consider ETag-based cache validation
