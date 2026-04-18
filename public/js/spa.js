/**
 * SDN 2 Dermolo - Single Page Application (SPA)
 * Handles dynamic content loading without page refresh.
 */

(function () {
    'use strict';

    const config = {
        contentContainer: '#main-content',
        animationDuration: 220,
        loadingDelay: 200,
        cachePrefix: 'sdn2-dermolo-spa-cache:v4',
        // Routes that should always fetch fresh data (no cache)
        noCacheRoutes: [
            '/spa/data-guru',
            '/spa/prestasi',
            '/spa/gallery',
            '/spa/sarana-prasarana',
            '/spa/program',
            '/spa/about',
            '/spa/home',
            '/spa/contact',
            '/spa/ppdb',
            '/spa/ppdb/daftar',
        ],
    };

    const routeMap = {
        '/': {
            route: '/spa/home',
            title: 'Beranda - SD N 2 Dermolo',
        },
        '/fasilitas': {
            route: '/spa/sarana-prasarana',
            title: 'Sarana & Prasarana - SD N 2 Dermolo',
        },
        '/guru-pendidik': {
            route: '/spa/data-guru',
            title: 'Data Guru - SD N 2 Dermolo',
        },
        '/prestasi': {
            route: '/spa/prestasi',
            title: 'Prestasi - SD N 2 Dermolo',
        },
        '/galeri': {
            route: '/spa/gallery',
            title: 'Galeri - SD N 2 Dermolo',
        },
        '/tentang-kami': {
            route: '/spa/about',
            title: 'Tentang Kami - SD N 2 Dermolo',
        },
        '/program': {
            route: '/spa/program',
            title: 'Program - SD N 2 Dermolo',
        },
        '/kontak': {
            route: '/spa/contact',
            title: 'Kontak - SD N 2 Dermolo',
        },
        '/ppdb': {
            route: '/spa/ppdb',
            title: 'PPDB Online - SD N 2 Dermolo',
        },
        '/ppdb/daftar': {
            route: '/spa/ppdb/daftar',
            title: 'Pendaftaran PPDB - SD N 2 Dermolo',
        },
    };

    let currentRoute = null;
    let isLoading = false;
    let revealObserver = null;
    let loadingTimer = null;
    const memoryCache = new Map();

    // Loading progress bar element
    let loadingBar = null;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        setupNavigation();
        setupHistoryHandling();
        reinitializeComponents();
        loadInitialContent();

        // Ensure hero slideshow initializes on initial page load
        // This fixes the issue where slideshow disappears on page refresh
        window.setTimeout(function () {
            setupHeroSwiper();
            console.log('[SPA] Hero Swiper initialized on page load');
        }, 200);
    }

    function setupNavigation() {
        if (document.body.dataset.spaNavigationBound === 'true') {
            return;
        }

        document.body.dataset.spaNavigationBound = 'true';

        document.addEventListener('click', (event) => {
            if (
                event.defaultPrevented
                || event.button !== 0
                || event.metaKey
                || event.ctrlKey
                || event.shiftKey
                || event.altKey
            ) {
                return;
            }

            const spaLink = event.target.closest('a[data-spa]');

            if (spaLink) {
                event.preventDefault();

                const route = spaLink.dataset.spa;
                const title = spaLink.dataset.spaTitle || document.title;
                const hash = spaLink.dataset.spaHash || spaLink.hash || '';

                closeMobileMenu();

                if (route) {
                    loadContent(route, title, true, hash);
                }

                return;
            }

            const anchorLink = event.target.closest('a[href]');

            if (! anchorLink) {
                return;
            }

            if (
                anchorLink.hasAttribute('download')
                || anchorLink.target === '_blank'
                || anchorLink.dataset.noSpa === 'true'
            ) {
                return;
            }

            const rawHref = anchorLink.getAttribute('href') || '';

            if (rawHref === '#home' || rawHref === '#tentang' || rawHref === '#kontak') {
                event.preventDefault();
                navigateToHomeSection(rawHref);
                return;
            }

            let destinationUrl;

            try {
                destinationUrl = new URL(anchorLink.href, window.location.origin);
            } catch (error) {
                return;
            }

            if (destinationUrl.origin !== window.location.origin) {
                return;
            }

            const destination = routeMap[destinationUrl.pathname];

            if (! destination) {
                return;
            }

            event.preventDefault();
            closeMobileMenu();
            loadContent(
                destination.route,
                anchorLink.dataset.spaTitle || destination.title,
                true,
                destinationUrl.hash || ''
            );
        });
    }

    function setupHistoryHandling() {
        window.addEventListener('popstate', (event) => {
            const state = event.state;

            console.log('[SPA] Popstate event triggered', state);

            if (state && state.route) {
                console.log('[SPA] Loading content from history state:', state.route);
                loadContent(state.route, state.title || document.title, false, state.hash || '');
                return;
            }

            // Fallback: use the current URL pathname
            const destination = routeMap[window.location.pathname];

            if (destination) {
                console.log('[SPA] Loading content from URL pathname:', destination.route);
                loadContent(destination.route, destination.title, false, window.location.hash || '');
            } else {
                console.warn('[SPA] No route found for pathname:', window.location.pathname);
            }
        });

        // Ensure initial state is properly set
        if (!window.history.state) {
            const destination = routeMap[window.location.pathname];
            if (destination) {
                window.history.replaceState({
                    route: destination.route,
                    url: window.location.pathname,
                    title: document.title,
                    hash: window.location.hash || '',
                }, document.title, window.location.pathname + window.location.hash);
                
                console.log('[SPA] Initial history state set:', destination.route);
            }
        }
    }

    function loadInitialContent() {
        const destination = routeMap[window.location.pathname];

        if (! destination) {
            return;
        }

        currentRoute = destination.route;
        updateActiveNav(destination.route);

        window.history.replaceState({
            route: destination.route,
            url: window.location.pathname,
            title: document.title,
            hash: window.location.hash || '',
        }, document.title, window.location.pathname + window.location.hash);

        seedCurrentRouteCache(destination.route, document.title, window.location.pathname);
    }

    async function loadContent(route, title, updateHistory, hash = '') {
        const contentArea = getContentArea();

        if (! contentArea || isLoading) {
            return;
        }

        if (currentRoute === route) {
            if (hash) {
                scrollToSection(hash);
            }

            return;
        }

        const previousRoute = currentRoute;
        
        // Check if this route should bypass cache
        const shouldBypassCache = config.noCacheRoutes.includes(route);
        
        // Only use cache if route is not in noCacheRoutes list
        const cachedData = shouldBypassCache ? null : getCachedResponse(route);

        updateActiveNav(route);

        if (cachedData) {
            await renderContent(contentArea, cachedData, {
                route,
                title,
                updateHistory,
                hash,
                animate: true,
            });

            return;
        }

        isLoading = true;

        // Show loading bar indicator
        showLoadingBar();

        try {
            const data = await fetchContent(route);
            cacheResponse(route, data);

            await renderContent(contentArea, data, {
                route,
                title,
                updateHistory,
                hash,
                animate: true,
            });
        } catch (error) {
            console.error('[SPA] Critical load failure, falling back to standard navigation:', error);
            
            // If it's a timeout or network error, fallback to standard browser navigation
            // This prevents the user from being "stuck" in a loading state
            const targetUrl = routeMap[window.location.pathname] ? window.location.pathname : route;
            window.location.href = targetUrl;
        } finally {
            hideLoadingBar();
            isLoading = false;
        }
    }

    function fetchContent(route) {
        // Add cache-busting timestamp for no-cache routes
        const isNoCache = config.noCacheRoutes.includes(route);
        const cacheBustUrl = isNoCache ? `${route}?_t=${Date.now()}` : route;

        console.log('[SPA] Fetching content from:', cacheBustUrl, isNoCache ? '(no-cache)' : '(cached)');

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Add timeout controller (15 seconds)
        const controller = new AbortController();
        const timeoutId = setTimeout(() => {
            console.warn('[SPA] Request timed out for:', route);
            controller.abort();
        }, 15000);

        return fetch(cacheBustUrl, {
            signal: controller.signal,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            // Add cache control for no-cache routes
            cache: isNoCache ? 'no-store' : 'default',
        }).then(async (response) => {
            clearTimeout(timeoutId);
            if (! response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();

            if (! data.success || typeof data.html !== 'string') {
                throw new Error('Invalid SPA response.');
            }

            console.log('[SPA] Content fetched successfully for:', route);
            return data;
        }).catch(error => {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                throw new Error('Request timeout');
            }
            throw error;
        });
    }

    function renderContent(contentArea, data, options = {}) {
        const shouldAnimate = Boolean(options.animate) && contentArea.dataset.loadingState !== 'true';
        const nextTitle = data.title || options.title || document.title;
        const nextUrl = data.url || window.location.pathname;
        const nextHash = options.hash || '';
        
        // Invalidate cache for previous route if it's a no-cache route
        // This ensures fresh data when user navigates back
        const previousRoute = currentRoute;
        if (previousRoute && config.noCacheRoutes.includes(previousRoute)) {
            invalidateRouteCache(previousRoute);
        }

        if (shouldAnimate) {
            contentArea.style.transition = '';
            contentArea.style.opacity = '0';
        }

        contentArea.innerHTML = data.html;
        contentArea.removeAttribute('aria-busy');
        contentArea.removeAttribute('data-loading-state');
        contentArea.style.minHeight = '';

        currentRoute = options.route || currentRoute;
        document.title = nextTitle;

        const publicUrl = buildPublicUrl(nextUrl, nextHash);
        const state = {
            route: options.route || currentRoute,
            url: nextUrl,
            title: nextTitle,
            hash: nextHash,
        };

        if (options.updateHistory) {
            window.history.pushState(state, nextTitle, publicUrl);
        } else {
            window.history.replaceState(state, nextTitle, publicUrl);
        }

        if (shouldAnimate) {
            return animateIn(contentArea).then(() => {
                finalizeRender(nextHash, shouldAnimate);
            });
        }

        contentArea.style.transition = '';
        contentArea.style.opacity = '1';
        finalizeRender(nextHash, shouldAnimate);

        return Promise.resolve();
    }

    function finalizeRender(hash, animated) {
        // IMMEDIATE scroll to top before anything else
        window.scrollTo({ top: 0, left: 0, behavior: 'instant' });

        // Force scroll reset for older browsers
        if (document.scrollingElement) {
            document.scrollingElement.scrollTop = 0;
        }

        // Ensure content area is visible and properly styled
        const contentArea = getContentArea();
        if (contentArea) {
            contentArea.style.opacity = '1';
            contentArea.style.visibility = 'visible';
            contentArea.style.display = '';
            
            // Remove any hidden states that might block content
            contentArea.classList.remove('hidden', 'invisible');
        }

        // Reinitialize all components after a brief delay to ensure DOM is ready
        window.setTimeout(() => {
            // Double-check content is still visible
            if (contentArea && !contentArea.innerHTML.trim()) {
                console.warn('[SPA] Content area is empty after render');
            }

            // Force another visibility check
            if (contentArea) {
                contentArea.style.opacity = '1';
                contentArea.style.visibility = 'visible';
            }

            reinitializeComponents();

            // Third scroll attempt after components are initialized
            window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
            
            console.log('[SPA] Page navigation complete:', currentRoute);
        }, 100);

        if (hash) {
            window.setTimeout(() => scrollToSection(hash), 200);
        }
    }

    function getContentArea() {
        return document.querySelector(config.contentContainer);
    }

    function buildPublicUrl(url, hash) {
        const normalizedUrl = url || window.location.pathname;

        if (! hash) {
            return normalizedUrl;
        }

        return `${normalizedUrl}${hash}`;
    }

    function navigateToHomeSection(hash) {
        const isHome = window.location.pathname === '/';

        if (isHome && document.querySelector(hash)) {
            scrollToSection(hash);
            window.history.replaceState({
                route: '/spa/home',
                url: '/',
                title: document.title,
                hash,
            }, document.title, `/${hash}`);
            return;
        }

        loadContent('/spa/home', 'Beranda - SD N 2 Dermolo', true, hash);
    }

    function scrollToSection(hash) {
        const target = document.querySelector(hash);

        if (! target) {
            return;
        }

        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });
    }

    function closeMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenu) {
            mobileMenu.classList.add('hidden');
        }
    }

    function showLoadingBar() {
        // Create loading bar if it doesn't exist
        if (!loadingBar) {
            loadingBar = document.createElement('div');
            loadingBar.id = 'spa-loading-bar';
            loadingBar.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                height: 3px;
                background: linear-gradient(90deg, #10b981, #3b82f6, #8b5cf6);
                z-index: 9999;
                width: 0%;
                transition: width 0.3s ease;
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
            `;
            document.body.appendChild(loadingBar);
        }

        // Show and animate
        loadingBar.style.display = 'block';
        loadingBar.style.width = '0%';

        // Animate to 70%
        setTimeout(() => {
            if (loadingBar) {
                loadingBar.style.width = '70%';
            }
        }, 50);

        // Animate to 90%
        setTimeout(() => {
            if (loadingBar) {
                loadingBar.style.width = '90%';
            }
        }, 300);
    }

    function hideLoadingBar() {
        if (!loadingBar) return;

        // Complete to 100%
        loadingBar.style.width = '100%';

        // Hide after animation
        setTimeout(() => {
            if (loadingBar) {
                loadingBar.style.display = 'none';
                loadingBar.style.width = '0%';
            }
        }, 300);
    }

    function seedCurrentRouteCache(route, title, url) {
        const contentArea = getContentArea();

        if (! contentArea || contentArea.dataset.spaSeed !== 'true') {
            return;
        }

        const html = contentArea.innerHTML.trim();

        if (! html) {
            return;
        }

        cacheResponse(route, {
            success: true,
            html,
            title,
            url,
        });
    }

    function cacheResponse(route, data) {
        const entry = {
            success: true,
            html: data.html,
            title: data.title,
            url: data.url,
            timestamp: Date.now(), // Add timestamp for tracking
        };

        memoryCache.set(route, entry);

        try {
            window.sessionStorage.setItem(createCacheKey(route), JSON.stringify(entry));
        } catch (error) {
            console.warn('SPA cache unavailable:', error);
        }
    }

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

        try {
            const stored = window.sessionStorage.getItem(createCacheKey(route));

            if (! stored) {
                return null;
            }

            const parsed = JSON.parse(stored);

            if (! parsed || typeof parsed.html !== 'string') {
                window.sessionStorage.removeItem(createCacheKey(route));
                return null;
            }
            
            // Check if cache is expired
            if (parsed.timestamp && (Date.now() - parsed.timestamp > CACHE_TTL)) {
                window.sessionStorage.removeItem(createCacheKey(route));
                return null;
            }

            memoryCache.set(route, parsed);

            return parsed;
        } catch (error) {
            console.warn('SPA cache read failed:', error);
            return null;
        }
    }

    function createCacheKey(route) {
        return `${config.cachePrefix}:${route}`;
    }

    function animateIn(contentArea) {
        return new Promise((resolve) => {
            contentArea.style.transition = `opacity ${config.animationDuration}ms ease-in`;
            contentArea.style.opacity = '1';
            window.setTimeout(resolve, config.animationDuration);
        });
    }

    function updateActiveNav(route) {
        // Reset PPDB buttons to default amber gradient
        document.querySelectorAll('a[data-spa="/spa/ppdb"], a[data-spa="/spa/ppdb/daftar"]').forEach((link) => {
            link.classList.remove('from-blue-600', 'to-cyan-500', 'shadow-blue-500/30', 'hover:shadow-blue-500/50');
            link.classList.add('from-amber-400', 'to-orange-500');
            if (link.classList.contains('shadow-lg')) {
                link.classList.add('shadow-amber-500/30', 'hover:shadow-amber-500/50');
            }
        });

        // Target all SPA links (Desktop & Mobile) EXCEPT footer and explicitly ignored buttons
        document.querySelectorAll('a[data-spa], #mobile-menu a[data-spa]').forEach((link) => {
            // Skip if this link is inside footer or has ignore-active attribute
            if (link.closest('footer') || link.dataset.spaIgnoreActive === 'true') {
                return;
            }
            link.classList.remove('bg-emerald-50', 'text-blue-600', 'text-blue-600');
            
            // For mobile menu specifically
            if (link.closest('#mobile-menu')) {
                link.classList.remove('text-blue-600');
                link.classList.add('text-slate-600');
            }
        });

        // Reset dropdown parents (Profil button)
        document.querySelectorAll('nav .group button').forEach(button => {
            button.classList.remove('bg-emerald-50', 'text-blue-600');
        });

        if (! route) {
            return;
        }

        // Handle active state for PPDB buttons
        if (route.startsWith('/spa/ppdb')) {
            document.querySelectorAll('a[data-spa="/spa/ppdb"], a[data-spa="/spa/ppdb/daftar"]').forEach((link) => {
                link.classList.remove('from-amber-400', 'to-orange-500', 'shadow-amber-500/30', 'hover:shadow-amber-500/50');
                link.classList.add('from-blue-600', 'to-cyan-500');
                if (link.classList.contains('shadow-lg')) {
                    link.classList.add('shadow-blue-500/30', 'hover:shadow-blue-500/50');
                }
            });
        }

        // Add active state to matching links
        document.querySelectorAll(`a[data-spa="${route}"]`).forEach((link) => {
            // Skip if this link is inside footer or has ignore-active attribute
            if (link.closest('footer') || link.dataset.spaIgnoreActive === 'true') {
                return;
            }
            
            link.classList.add('text-blue-600');
            
            // Desktop specific (non-dropdown items or specific design)
            if (!link.closest('.absolute')) {
                link.classList.add('bg-emerald-50');
            }

            // Dropdown parent handling
            const dropdown = link.closest('.group');
            if (dropdown) {
                const button = dropdown.querySelector('button');
                if (button) {
                    button.classList.add('bg-emerald-50', 'text-blue-600');
                }
            }
            
            // Mobile menu active handling
            if (link.closest('#mobile-menu')) {
                link.classList.remove('text-slate-600');
                link.classList.add('text-blue-600');
                
                // If it's inside a <details> in mobile menu, open it
                const details = link.closest('details');
                if (details) {
                    details.open = true;
                }
            }
        });

        // Update footer navigation separately with footer-specific styling
        updateFooterActiveNav(route);
    }

    function updateFooterActiveNav(route) {
        // Remove active state from ALL footer navigation links
        document.querySelectorAll('footer a[data-spa]').forEach((link) => {
            link.classList.remove('text-white', 'font-semibold');
            link.classList.add('text-blue-200/80');
        });

        if (! route) {
            return;
        }

        // Add active state ONLY to matching footer link
        document.querySelectorAll(`footer a[data-spa="${route}"]`).forEach((link) => {
            link.classList.remove('text-blue-200/80');
            link.classList.add('text-white', 'font-semibold');
        });
    }

    function showError(message) {
        const contentArea = getContentArea();

        if (! contentArea) {
            return;
        }

        contentArea.innerHTML = `
            <div class="flex items-center justify-center min-h-[50vh] px-4">
                <div class="text-center max-w-md">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Terjadi Kesalahan</h2>
                    <p class="text-slate-600 mb-6">Gagal memuat konten: ${message}</p>
                    <div class="flex gap-3 justify-center">
                        <button onclick="location.reload()" class="px-6 py-3 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg">
                            Muat Ulang Halaman
                        </button>
                        <button onclick="window.history.back()" class="px-6 py-3 rounded-full bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300 transition shadow-lg">
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function reinitializeComponents() {
        // Ensure the DOM is ready before we start reinitializing
        if (document.readyState === 'loading') {
            console.warn('[SPA] DOM not ready, delaying reinitialization');
            window.setTimeout(reinitializeComponents, 50);
            return;
        }

        try {
            // Clean up old instances before reinitializing
            cleanupOldInstances();
        } catch (error) {
            console.error('[SPA] Error during cleanup:', error);
        }

        try {
            // Reinitialize all components with proper order
            setupScrollReveal();
        } catch (error) {
            console.error('[SPA] Error in setupScrollReveal:', error);
        }

        try {
            setupSlideshow();
        } catch (error) {
            console.error('[SPA] Error in setupSlideshow:', error);
        }

        try {
            setupHeroSwiper();
        } catch (error) {
            console.error('[SPA] Error in setupHeroSwiper:', error);
        }

        try {
            setupFacilityModal();
        } catch (error) {
            console.error('[SPA] Error in setupFacilityModal:', error);
        }

        try {
            setupPrestasiModal();
        } catch (error) {
            console.error('[SPA] Error in setupPrestasiModal:', error);
        }

        try {
            setupGalleryModal();
        } catch (error) {
            console.error('[SPA] Error in setupGalleryModal:', error);
        }

        try {
            setupNewsCategoryFilters();
        } catch (error) {
            console.error('[SPA] Error in setupNewsCategoryFilters:', error);
        }

        try {
            // Reinitialize grid layouts and masonry
            setupGridLayout();
        } catch (error) {
            console.error('[SPA] Error in setupGridLayout:', error);
        }

        try {
            // Reinitialize click handlers for dynamic elements
            setupDynamicClickHandlers();
        } catch (error) {
            console.error('[SPA] Error in setupDynamicClickHandlers:', error);
        }

        try {
            // Refresh external libraries if they exist
            refreshExternalLibraries();
        } catch (error) {
            console.error('[SPA] Error in refreshExternalLibraries:', error);
        }

        try {
            // Reinitialize global UI components (confirm modal, scroll-to-top, card animations)
            if (typeof window.reinitializeGlobalUI === 'function') {
                window.reinitializeGlobalUI();
            }
        } catch (error) {
            console.error('[SPA] Error in reinitializeGlobalUI:', error);
        }

        try {
            // Reinitialize Drop Zone file uploads (Drag & Drop)
            initializeDropZones();
        } catch (error) {
            console.error('[SPA] Error in initializeDropZones:', error);
        }

        try {
            // Reinitialize gallery-specific drop zones
            if (typeof window.initializeGalleryDropZone === 'function') {
                window.initializeGalleryDropZone();
            }
        } catch (error) {
            console.error('[SPA] Error in initializeGalleryDropZone:', error);
        }

        try {
            // Reinitialize any admin form scripts
            initializeAdminForms();
        } catch (error) {
            console.error('[SPA] Error in initializeAdminForms:', error);
        }

        try {
            // Reinitialize image previews
            initializeImagePreviews();
        } catch (error) {
            console.error('[SPA] Error in initializeImagePreviews:', error);
        }

        console.log('[SPA] Components reinitialized successfully');
    }

    function cleanupOldInstances() {
        // Clean up modal instances to prevent duplicate event listeners
        cleanupModalInstances();
        
        // Clean up any existing slideshow instances
        if (window.heroSlideshowController?.destroy) {
            window.heroSlideshowController.destroy();
            window.heroSlideshowController = null;
        }
    }

    function cleanupModalInstances() {
        // Remove initialized flags from modals so they can be re-setup
        const modals = ['facility-modal', 'prestasi-modal', 'gallery-modal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal) {
                delete modal.dataset.initialized;
            }
        });
    }

    function setupGridLayout() {
        // Reinitialize any grid/masonry layouts
        const grids = document.querySelectorAll('.grid, [class*="grid-cols-"]');
        
        grids.forEach(grid => {
            // Force browser to recalculate grid layout
            grid.style.display = 'none';
            grid.offsetHeight; // Trigger reflow
            grid.style.display = '';
        });

        // Handle any masonry layouts if present
        const masonryGrids = document.querySelectorAll('[data-masonry], .masonry-grid');
        masonryGrids.forEach(masonry => {
            if (typeof window.initMasonry === 'function') {
                window.initMasonry(masonry);
            }
        });

        console.log('[SPA] Grid layouts initialized');
    }

    function setupDynamicClickHandlers() {
        if (document.body.dataset.spaDynamicHandlersBound === 'true') {
            console.log('[SPA] Dynamic click handlers initialized');
            return;
        }

        document.body.dataset.spaDynamicHandlersBound = 'true';
        document.addEventListener('click', handleDynamicClick);
        document.addEventListener('keydown', handleDynamicKeydown);

        console.log('[SPA] Dynamic click handlers initialized');
    }

    function handleDynamicKeydown(event) {
        if (event.key !== 'Escape') {
            return;
        }

        const openModal = document.querySelector('.is-open');
        if (openModal) {
            const modalId = openModal.id;
            if (modalId === 'gallery-modal') closeGalleryModal();
            else if (modalId === 'prestasi-modal') closePrestasiModal();
            else if (modalId === 'facility-modal') closeFacilityModal();
        }
    }

    function handleDynamicClick(event) {
        const target = event.target;
        if (!(target instanceof Element)) {
            return;
        }

        // Improved detection: use closest() to find the trigger element
        const facilityCard = target.closest('[data-facility-card]');
        if (facilityCard) {
            if (handleFacilityModalClick(facilityCard, target)) return;
        }

        const prestasiCard = target.closest('[data-prestasi-card]');
        if (prestasiCard) {
            if (handlePrestasiModalClick(prestasiCard, target)) return;
        }

        const galleryCard = target.closest('[data-gallery-card]');
        if (galleryCard) {
            if (handleGalleryModalClick(galleryCard, target)) return;
        }

        const programCard = target.closest('[data-program-card]');
        if (programCard) {
            if (handleProgramCardClick(programCard, target)) return;
        }

        if (target.closest('[data-facility-close]')) {
            closeFacilityModal();
            return;
        }

        if (target.closest('[data-prestasi-close]')) {
            closePrestasiModal();
            return;
        }

        if (target.closest('[data-gallery-close]')) {
            closeGalleryModal();
            return;
        }

        handleGeneralInteractiveClick(event, target);
    }

    function handleFacilityModalClick(card, originalTarget) {
        if (hasNestedInteractiveTarget(originalTarget, card, 'a[href], button, input, textarea, select')) {
            return false;
        }
        openFacilityModal(card);
        return true;
    }

    function handlePrestasiModalClick(card, originalTarget) {
        if (hasNestedInteractiveTarget(originalTarget, card, 'a[href], button, input, textarea, select')) {
            return false;
        }
        openPrestasiModal(card);
        return true;
    }

    function handleGalleryModalClick(card, originalTarget) {
        if (hasNestedInteractiveTarget(originalTarget, card, 'a[href], button, input, textarea, select')) {
            return false;
        }
        openGalleryModal(card);
        return true;
    }

    function handleProgramCardClick(card, originalTarget) {
        if (card.matches('a[href]') || hasNestedInteractiveTarget(originalTarget, card, 'a[href], button, input, textarea, select, [data-toggle]')) {
            return false;
        }
        const link = card.querySelector('a[href]');
        if (link) {
            window.location.href = link.href;
            return true;
        }
        return false;
    }

    function handleGeneralInteractiveClick(event, target) {
        const toggle = target.closest('[data-toggle], .accordion-toggle');
        if (toggle) {
            event.preventDefault();

            const selector = toggle.dataset.target || toggle.getAttribute('href');
            if (!selector) {
                return true;
            }

            const panel = document.querySelector(selector);
            if (panel) {
                panel.classList.toggle('hidden');
                toggle.classList.toggle('active');
            }

            return true;
        }

        const tab = target.closest('[data-tab]');
        if (!tab) {
            return false;
        }

        event.preventDefault();

        const tabGroup = tab.closest('[data-tab-group]');
        if (!tabGroup) {
            return true;
        }

        tabGroup.querySelectorAll('[data-tab]').forEach((item) => item.classList.remove('active'));
        tabGroup.querySelectorAll('[data-tab-content]').forEach((item) => item.classList.add('hidden'));

        tab.classList.add('active');

        const contentId = tab.dataset.tab;
        if (!contentId) {
            return true;
        }

        const content = document.querySelector(`[data-tab-content="${contentId}"]`);
        if (content) {
            content.classList.remove('hidden');
        }

        return true;
    }

    function openFacilityModal(card) {
        openContentModal('facility', card, 'Deskripsi fasilitas belum tersedia.');
    }

    function closeFacilityModal() {
        closeContentModal('facility');
    }

    function openPrestasiModal(card) {
        openContentModal('prestasi', card, 'Deskripsi prestasi belum tersedia.');
    }

    function closePrestasiModal() {
        closeContentModal('prestasi');
    }

    function openGalleryModal(card) {
        openContentModal('gallery', card, 'Deskripsi belum tersedia.');
    }

    function closeGalleryModal() {
        closeContentModal('gallery');
    }

    function openContentModal(prefix, card, fallbackDescription) {
        const modal = document.getElementById(`${prefix}-modal`);
        const imageEl = document.getElementById(`${prefix}-modal-image`);
        const titleEl = document.getElementById(`${prefix}-modal-title`);
        const descEl = document.getElementById(`${prefix}-modal-desc`);

        if (!modal || !imageEl || !titleEl || !descEl) {
            return;
        }

        titleEl.textContent = card.dataset.title || '';
        descEl.textContent = card.dataset.desc || fallbackDescription;

        if (card.dataset.image) {
            imageEl.src = card.dataset.image;
            imageEl.style.display = 'block';
        } else {
            imageEl.removeAttribute('src');
            imageEl.style.display = 'none';
        }

        setModalState(modal, true);
    }

    function closeContentModal(prefix) {
        const modal = document.getElementById(`${prefix}-modal`);
        if (!modal) {
            return;
        }

        setModalState(modal, false);
    }

    function setModalState(modal, isOpen) {
        modal.classList.toggle('hidden', !isOpen);
        modal.classList.toggle('flex', isOpen);
        modal.classList.toggle('is-open', isOpen);
        modal.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        document.body.style.overflow = isOpen ? 'hidden' : '';
    }

    function isModalOpen(modalId) {
        const modal = document.getElementById(modalId);
        return Boolean(modal && modal.classList.contains('is-open'));
    }

    function hasNestedInteractiveTarget(target, container, selector) {
        const interactiveTarget = target.closest(selector);
        return Boolean(interactiveTarget && interactiveTarget !== container);
    }

    function refreshExternalLibraries() {
        // Refresh AOS (Animate On Scroll) if present
        if (typeof AOS !== 'undefined') {
            if (typeof AOS.init === 'function') {
                // Re-initialize AOS for new content
                AOS.init();
                console.log('[SPA] AOS re-initialized');
            }
            if (typeof AOS.refresh === 'function') {
                AOS.refresh();
                console.log('[SPA] AOS refreshed');
            }
            
            // Fix hidden elements caused by AOS
            document.querySelectorAll('[data-aos]').forEach(el => {
                // Remove invisible state caused by AOS
                el.style.opacity = '';
                el.style.transform = '';
            });
        }

        // Refresh Swiper if present
        if (window.swiperInstances) {
            window.swiperInstances.forEach(swiper => {
                if (swiper && swiper.update) {
                    swiper.update();
                }
            });
            console.log('[SPA] Swiper instances updated');
        }

        // Refresh Lightbox if present
        if (typeof window.initLightbox === 'function') {
            window.initLightbox();
            console.log('[SPA] Lightbox refreshed');
        }

        // Refresh any chart libraries
        if (typeof Chart !== 'undefined' && Chart.helpers) {
            // Charts will auto-update when data changes
            console.log('[SPA] Chart.js detected');
        }

        // Fix any elements that might be hidden due to animation conflicts
        fixHiddenContent();

        // Trigger custom event for third-party integrations
        window.dispatchEvent(new CustomEvent('spa:contentLoaded', {
            detail: { route: currentRoute }
        }));

        console.log('[SPA] External libraries refreshed');
    }

    function fixHiddenContent() {
        // Fix elements hidden by AOS or other animation libraries
        const hiddenElements = document.querySelectorAll('.aos-animate:not([class*="visible"])');
        hiddenElements.forEach(el => {
            // Force visibility for elements that should be in viewport
            const rect = el.getBoundingClientRect();
            const isInViewport = rect.top < window.innerHeight && rect.bottom >= 0;
            
            if (isInViewport && !el.classList.contains('visible')) {
                el.classList.add('visible');
                el.style.opacity = '1';
                el.style.transform = 'none';
            }
        });

        // Fix reveal elements that might be stuck in hidden state
        document.querySelectorAll('.reveal').forEach(el => {
            const rect = el.getBoundingClientRect();
            const isInViewport = rect.top < window.innerHeight && rect.bottom >= 0;
            
            if (isInViewport && !el.classList.contains('visible')) {
                // Let the IntersectionObserver handle it, but ensure it's observable
                if (revealObserver) {
                    revealObserver.observe(el);
                }
            }
        });

        console.log('[SPA] Hidden content fixed');
    }

    function setupScrollReveal() {
        if (revealObserver) {
            revealObserver.disconnect();
        }

        revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        // Observe all reveal elements
        document.querySelectorAll('.reveal').forEach((element) => {
            // Immediately show elements that are already in viewport
            const rect = element.getBoundingClientRect();
            const isInViewport = rect.top < window.innerHeight && rect.bottom >= 0;

            if (isInViewport) {
                element.classList.add('visible');
            } else {
                revealObserver.observe(element);
            }
        });
    }

    function setupSlideshow() {
        if (window.heroSlideshowController?.destroy) {
            window.heroSlideshowController.destroy();
            window.heroSlideshowController = null;
        }

        const heroSection = document.querySelector('#home');

        if (! heroSection) {
            return;
        }

        const slides = Array.from(heroSection.querySelectorAll('.hero-slide'));
        const dots = Array.from(heroSection.querySelectorAll('.slideshow-dot'));
        const heroTitleEl = document.getElementById('hero-title');
        const heroSubtitleEl = document.getElementById('hero-subtitle');

        if (slides.length <= 1) {
            return;
        }

        let currentSlide = 0;
        const interval = 5000;
        const fadeDuration = 800;
        let autoplayId = null;
        const cleanup = [];

        slides.forEach((slide, index) => {
            slide.style.transition = `opacity ${fadeDuration}ms ease-in-out`;
            slide.style.willChange = 'opacity';
            slide.style.opacity = index === 0 ? '1' : '0';
            slide.style.zIndex = index === 0 ? '10' : '1';
            slide.setAttribute('aria-hidden', index === 0 ? 'false' : 'true');
        });

        // Function to update hero text based on slide data
        const updateHeroText = (index) => {
            if (!heroTitleEl || !heroSubtitleEl) return;

            const currentSlide = slides[index];
            if (!currentSlide) return;

            const newTitle = currentSlide.dataset.slideTitle || '';
            const newSubtitle = currentSlide.dataset.slideSubtitle || '';
            const newDescription = currentSlide.dataset.slideDescription || '';

            // Add fade out effect
            heroTitleEl.style.transition = 'opacity 0.3s ease-in-out';
            heroSubtitleEl.style.transition = 'opacity 0.3s ease-in-out';
            heroTitleEl.style.opacity = '0';
            heroSubtitleEl.style.opacity = '0';

            // Update text after fade out
            setTimeout(() => {
                if (newTitle) {
                    const titleTextEl = document.getElementById('hero-title-text');
                    if (titleTextEl) {
                        titleTextEl.textContent = newTitle;
                    }
                }

                if (newSubtitle) {
                    const subtitleTextEl = document.getElementById('hero-subtitle-text');
                    if (subtitleTextEl) {
                        subtitleTextEl.textContent = newSubtitle;
                    }
                }

                if (newDescription) {
                    const descTextEl = document.getElementById('hero-description');
                    if (descTextEl) {
                        descTextEl.textContent = newDescription;
                    }
                }

                // Fade back in
                heroTitleEl.style.opacity = '1';
                const subtitleEl = document.getElementById('hero-subtitle');
                if (subtitleEl) {
                    subtitleEl.style.opacity = '1';
                }
            }, 300);
        };

        const updateDots = (index) => {
            dots.forEach((dot, dotIndex) => {
                if (dotIndex === index) {
                    dot.style.backgroundColor = '#fbbf24';
                    dot.style.transform = 'scale(1.2)';
                    dot.style.borderColor = '#fbbf24';
                    dot.setAttribute('aria-pressed', 'true');
                } else {
                    dot.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                    dot.style.transform = 'scale(1)';
                    dot.style.borderColor = 'rgba(255, 255, 255, 0.5)';
                    dot.setAttribute('aria-pressed', 'false');
                }
            });
        };

        const goToSlide = (index) => {
            // Lightweight infinite loop logic
            const targetIndex = (index + slides.length) % slides.length;

            if (targetIndex === currentSlide) {
                return;
            }

            slides[currentSlide].style.opacity = '0';
            slides[currentSlide].style.zIndex = '1';
            slides[currentSlide].setAttribute('aria-hidden', 'true');

            slides[targetIndex].style.opacity = '1';
            slides[targetIndex].style.zIndex = '10';
            slides[targetIndex].setAttribute('aria-hidden', 'false');

            currentSlide = targetIndex;

            // Update hero text with animation
            updateHeroText(currentSlide);
            updateDots(currentSlide);
        };
        const stopAutoplay = () => {
            if (autoplayId !== null) {
                window.clearInterval(autoplayId);
                autoplayId = null;
            }
        };

        const startAutoplay = () => {
            stopAutoplay();
            if (slides.length > 1) {
                autoplayId = window.setInterval(() => {
                    goToSlide(currentSlide + 1);
                }, interval);
                console.log('[SPA] Hero Slideshow: Infinite loop active');
            }
        };

        dots.forEach((dot, index) => {
            const handleClick = (e) => {
                e.stopPropagation();
                goToSlide(index);
                // Restart autoplay so the timer resets
                startAutoplay();
            };

            dot.addEventListener('click', handleClick);
            cleanup.push(() => dot.removeEventListener('click', handleClick));
        });

        updateDots(currentSlide);

        const handleMouseEnter = () => {
            stopAutoplay();
            console.log('[SPA] Hero Slideshow Autoplay paused (hover)');
        };
        const handleMouseLeave = () => {
            startAutoplay();
            console.log('[SPA] Hero Slideshow Autoplay resumed (leave)');
        };

        heroSection.addEventListener('mouseenter', handleMouseEnter);
        heroSection.addEventListener('mouseleave', handleMouseLeave);
        cleanup.push(() => heroSection.removeEventListener('mouseenter', handleMouseEnter));
        cleanup.push(() => heroSection.removeEventListener('mouseleave', handleMouseLeave));

        startAutoplay();

        window.heroSlideshowController = {
            destroy() {
                stopAutoplay();
                cleanup.forEach((teardown) => teardown());
            },
        };
    }

    function setupFacilityModal() {
        const modal = document.getElementById('facility-modal');

        if (!modal) {
            return;
        }

        const imageEl = document.getElementById('facility-modal-image');
        const titleEl = document.getElementById('facility-modal-title');
        const descEl = document.getElementById('facility-modal-desc');

        if (!imageEl || !titleEl || !descEl) {
            return;
        }

        // Event listeners are handled by the global SPA delegation.
        modal.dataset.initialized = 'true';
        
        console.log('[SPA] Facility modal initialized');
    }

    function setupPrestasiModal() {
        const modal = document.getElementById('prestasi-modal');

        if (!modal) {
            return;
        }

        const imageEl = document.getElementById('prestasi-modal-image');
        const titleEl = document.getElementById('prestasi-modal-title');
        const descEl = document.getElementById('prestasi-modal-desc');

        if (!imageEl || !titleEl || !descEl) {
            return;
        }

        // Event listeners are handled by the global SPA delegation.
        modal.dataset.initialized = 'true';

        console.log('[SPA] Prestasi modal initialized');
    }

    function setupGalleryModal() {
        const modal = document.getElementById('gallery-modal');

        if (!modal) {
            return;
        }

        const imageEl = document.getElementById('gallery-modal-image');
        const titleEl = document.getElementById('gallery-modal-title');
        const descEl = document.getElementById('gallery-modal-desc');

        if (!imageEl || !titleEl || !descEl) {
            return;
        }

        // Event listeners are handled by the global SPA delegation.
        modal.dataset.initialized = 'true';

        console.log('[SPA] Gallery modal initialized');
    }

    function setupNewsCategoryFilters() {
        const activeClasses = ['border-slate-900', 'bg-slate-900', 'text-white', 'shadow-sm'];
        const inactiveClasses = ['border-slate-200', 'bg-white', 'text-slate-600'];
        const inactiveHoverClasses = ['hover:border-blue-200', 'hover:bg-blue-50', 'hover:text-blue-600'];

        document.querySelectorAll('[data-news-filter-root]').forEach((root) => {
            // Allow re-initialization by removing the guard
            // Delete the flag so it can be re-setup
            delete root.dataset.newsFilterInitialized;

            root.dataset.newsFilterInitialized = 'true';

            const buttons = Array.from(root.querySelectorAll('[data-news-category-button]'));
            const cards = Array.from(root.querySelectorAll('[data-news-card]'));
            const sections = Array.from(root.querySelectorAll('[data-news-filter-section]'));
            const activeLabel = root.querySelector('[data-news-active-label]');
            const activeLabelText = root.querySelector('[data-news-active-label-text]');
            const categoryInput = root.querySelector('[data-news-category-input]');

            const setButtonState = (button, isActive) => {
                button.classList.remove(...activeClasses, ...inactiveClasses, ...inactiveHoverClasses);

                if (isActive) {
                    button.classList.add(...activeClasses);
                    button.setAttribute('aria-pressed', 'true');
                } else {
                    button.classList.add(...inactiveClasses, ...inactiveHoverClasses);
                    button.setAttribute('aria-pressed', 'false');
                }
            };

            const updateEmptyStates = () => {
                sections.forEach((section) => {
                    const sectionCards = Array.from(section.querySelectorAll('[data-news-card]'));
                    const visibleCount = sectionCards.filter((card) => ! card.classList.contains('hidden')).length;
                    const emptyState = section.querySelector('[data-news-empty-state]');

                    if (! emptyState) {
                        return;
                    }

                    if (visibleCount === 0) {
                        emptyState.classList.remove('hidden');
                        emptyState.classList.add('flex');
                    } else {
                        emptyState.classList.add('hidden');
                        emptyState.classList.remove('flex');
                    }
                });
            };

            const applyFilter = (category) => {
                const normalizedCategory = category || 'all';
                const activeButton = buttons.find((button) => (button.dataset.newsCategory || 'all') === normalizedCategory) || buttons[0] || null;

                buttons.forEach((button) => {
                    setButtonState(button, button === activeButton);
                });

                cards.forEach((card) => {
                    const cardCategory = card.dataset.newsCategory || 'uncategorized';
                    const isVisible = normalizedCategory === 'all' || cardCategory === normalizedCategory;

                    card.classList.toggle('hidden', ! isVisible);
                });

                if (categoryInput) {
                    categoryInput.value = normalizedCategory === 'all' ? '' : normalizedCategory;
                }

                if (activeLabel && activeLabelText) {
                    const activeText = activeButton ? activeButton.textContent.trim() : 'Semua kategori';
                    activeLabelText.textContent = activeText === 'Semua' ? 'Semua kategori' : activeText;
                }

                updateEmptyStates();
            };

            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    applyFilter(button.dataset.newsCategory || 'all');
                });
            });

            const initialCategory = root.dataset.initialCategory || categoryInput?.value || 'all';
            applyFilter(initialCategory);
        });
    }

    // ============================================
    // NEW: Drop Zone Reinitialization
    // ============================================

    function initializeDropZones() {
        // Call the global drop zone initializer if it exists
        if (typeof window.initializeDropZones === 'function') {
            window.initializeDropZones();
            console.log('[SPA] Drop zones reinitialized');
        }
    }

    function initializeAdminForms() {
        // Reinitialize any form-specific scripts
        // This includes character counters, dynamic fields, etc.
        
        // Reinitialize character counters
        document.querySelectorAll('[data-maxlength]').forEach(input => {
            const maxLength = input.getAttribute('data-maxlength');
            const counter = input.parentElement.querySelector('.char-counter');
            
            if (counter) {
                const updateCounter = () => {
                    const remaining = maxLength - input.value.length;
                    counter.textContent = `${remaining} karakter tersisa`;
                };
                
                input.removeEventListener('input', updateCounter);
                input.addEventListener('input', updateCounter);
                updateCounter();
            }
        });

        // Reinitialize any rich text editors
        if (typeof tinymce !== 'undefined' && tinymce.EditorManager) {
            // TinyMCE exists - reinitialize it
            tinymce.EditorManager.execCommand('mceRemoveEditor', true, 'content');
            tinymce.EditorManager.execCommand('mceAddEditor', true, 'content');
        }

        console.log('[SPA] Admin forms reinitialized');
    }

    function initializeImagePreviews() {
        // Reinitialize image preview for file inputs
        document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
            const previewSelector = input.dataset.preview;
            const previewEl = document.querySelector(previewSelector);
            
            if (previewEl) {
                input.removeEventListener('change', handleFilePreview);
                input.addEventListener('change', handleFilePreview);
                
                function handleFilePreview(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewEl.src = e.target.result;
                            previewEl.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        });

        console.log('[SPA] Image previews reinitialized');
    }

    function setupHeroSwiper() {
        // Check if Swiper is available
        if (typeof Swiper === 'undefined') {
            console.warn('[SPA] Swiper.js not loaded, skipping hero swiper setup');
            return;
        }

        // Destroy existing instance if present
        if (window.heroSwiperInstance) {
            try {
                window.heroSwiperInstance.destroy(true, true);
                window.heroSwiperInstance = null;
                console.log('[SPA] Previous hero Swiper instance destroyed');
            } catch (e) {
                console.error('[SPA] Error destroying previous Swiper instance:', e);
            }
        }

        // Check if hero swiper markup exists
        const swiperContainer = document.querySelector('.hero-swiper-instance');
        if (!swiperContainer) {
            console.log('[SPA] No hero swiper container found, skipping');
            return;
        }

        // Check if there are at least 2 slides (otherwise no need for slideshow)
        const slideCount = swiperContainer.querySelectorAll('.swiper-slide').length;
        if (slideCount < 2) {
            console.log('[SPA] Less than 2 slides, skipping slideshow');
            return;
        }

        try {
            // Initialize new Swiper instance with autoplay
            window.heroSwiperInstance = new Swiper('.hero-swiper-instance', {
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                    waitForTransition: true,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                pagination: {
                    el: '.hero-swiper-pagination',
                    clickable: true,
                    bulletClass: 'slideshow-dot',
                    bulletActiveClass: 'is-active',
                    renderBullet: function (index, className) {
                        return '<button type="button" class="' + className + ' h-3 w-3 cursor-pointer rounded-full border-2 border-white/50 transition-all duration-300" aria-label="Go to slide ' + (index + 1) + '"></button>';
                    },
                },
                on: {
                    init: function () {
                        console.log('[SPA] Hero Swiper initialized with autoplay enabled');
                        // Update text content for first slide
                        updateHeroSlideText(0);
                        // Force autoplay start
                        try {
                            this.autoplay.start();
                        } catch (e) {
                            console.warn('[SPA] Could not start autoplay:', e);
                        }
                    },
                    slideChange: function () {
                        // Update text content when slide changes
                        const realIndex = this.realIndex;
                        updateHeroSlideText(realIndex);
                    },
                },
            });

            console.log('[SPA] Hero Swiper initialized successfully with 5s autoplay');
        } catch (error) {
            console.error('[SPA] Error initializing Hero Swiper:', error);
        }
    }

    function updateHeroSlideText(slideIndex) {
        try {
            const slidesData = document.getElementById('hero-slides-data');
            if (!slidesData) return;

            const slideElement = slidesData.querySelector('[data-slide-index="' + slideIndex + '"]');
            if (!slideElement) return;

            const title = slideElement.getAttribute('data-title');
            const subtitle = slideElement.getAttribute('data-subtitle');
            const description = slideElement.getAttribute('data-description');

            const titleText = document.getElementById('hero-title-text');
            const subtitleText = document.getElementById('hero-subtitle-text');
            const descText = document.getElementById('hero-description');

            if (titleText && title) {
                titleText.textContent = title;
            }
            if (subtitleText && subtitle) {
                subtitleText.textContent = subtitle;
            }
            if (descText && description) {
                descText.textContent = description;
            }

            // Re-trigger reveal animations
            const reveals = document.querySelectorAll('#hero-slide-content .reveal');
            reveals.forEach(function(el) {
                el.classList.remove('reveal');
                void el.offsetWidth; // Force reflow
                el.classList.add('reveal');
            });

            console.log('[SPA] Updated hero slide text to slide', slideIndex + 1);
        } catch (error) {
            console.error('[SPA] Error updating hero slide text:', error);
        }
    }

    function setupPpdbFeatures() {
        const countdownEl = document.getElementById('ppdb-countdown');
        const mainContainer = document.getElementById('ppdb-main-container');
        const regContainer = document.getElementById('ppdb-reg-container');
        const adminForm = document.getElementById('ppdb-settings-form');

        if (!countdownEl && !mainContainer && !regContainer && !adminForm) {
            return;
        }

        // State monitoring loop
        const timer = setInterval(() => {
            const now = new Date().getTime();

            // 1. Landing Page Logic
            if (mainContainer && window.location.pathname === '/ppdb') {
                const start = new Date(mainContainer.dataset.ppdbStart).getTime();
                const end = new Date(mainContainer.dataset.ppdbEnd).getTime();
                
                // Countdown logic (only if waiting)
                if (countdownEl && now < start) {
                    const distance = start - now;
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    countdownEl.innerHTML = `
                        <div class="ppdb-cd-box">
                            <div class="ppdb-cd-num">${days}</div>
                            <div class="ppdb-cd-lbl">Hari</div>
                        </div>
                        <div class="ppdb-cd-box">
                            <div class="ppdb-cd-num">${hours}</div>
                            <div class="ppdb-cd-lbl">Jam</div>
                        </div>
                        <div class="ppdb-cd-box">
                            <div class="ppdb-cd-num">${minutes}</div>
                            <div class="ppdb-cd-lbl">Menit</div>
                        </div>
                        <div class="ppdb-cd-box">
                            <div class="ppdb-cd-num">${seconds}</div>
                            <div class="ppdb-cd-lbl">Detik</div>
                        </div>
                    `;
                }

                // Auto-refresh landing page if state transitions
                const currentState = mainContainer.dataset.ppdbState;
                let newState = 'closed';
                if (now < start) newState = 'waiting';
                else if (now >= start && now <= end) newState = 'open';

                if (currentState && currentState !== newState) {
                    console.log(`[SPA] PPDB state changed from ${currentState} to ${newState}. Refreshing...`);
                    // Ensure we are still on the PPDB page before reloading
                    if (window.location.pathname === '/ppdb') {
                        loadContent('/spa/ppdb', 'PPDB Online - SD N 2 Dermolo', true);
                    }
                }
            }

            // 2. Registration Page Protection
            if (regContainer && window.location.pathname === '/ppdb/daftar') {
                const end = new Date(regContainer.dataset.ppdbEnd).getTime();
                if (now > end) {
                    const modal = document.getElementById('ppdb-closed-modal');
                    const iframeWrapper = document.getElementById('iframe-wrapper');
                    if (modal && modal.classList.contains('hidden')) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        if (iframeWrapper) iframeWrapper.innerHTML = '<div class="p-20 text-center text-slate-400">Pendaftaran telah ditutup.</div>';
                    }
                }
            }

            // 3. Admin Dashboard Realtime Status
            const adminStatus = document.getElementById('ppdb-admin-status');
            if (adminStatus && adminForm) {
                const start = new Date(adminForm.dataset.ppdbStart).getTime();
                const end = new Date(adminForm.dataset.ppdbEnd).getTime();
                
                let badgeHtml = '';
                if (!start || !end) {
                    badgeHtml = '<span class="flex h-3 w-3 rounded-full bg-slate-500"></span><span class="text-slate-700 font-bold">Belum Dikonfigurasi</span>';
                } else if (now < start) {
                    badgeHtml = '<span class="flex h-3 w-3 rounded-full bg-amber-500"></span><span class="text-amber-700 font-bold">Belum Dimulai</span>';
                } else if (now > end) {
                    badgeHtml = '<span class="flex h-3 w-3 rounded-full bg-slate-500"></span><span class="text-slate-700 font-bold">Ditutup</span>';
                } else if (end - now <= (24 * 60 * 60 * 1000)) { // 24 hours
                    badgeHtml = '<span class="flex h-3 w-3 rounded-full bg-red-500 animate-pulse"></span><span class="text-red-700 font-bold">Hampir Selesai</span>';
                } else {
                    badgeHtml = '<span class="flex h-3 w-3 rounded-full bg-green-500 animate-pulse"></span><span class="text-green-700 font-bold">Sedang Berlangsung</span>';
                }
                
                if (adminStatus.innerHTML !== badgeHtml) {
                    adminStatus.innerHTML = badgeHtml;
                }
            }
        }, 1000);
        
        cleanup.push(() => clearInterval(timer));

        // PPDB Carousel (same as before)
        const banners = document.querySelectorAll('.ppdb-banner');
        const dots = document.querySelectorAll('.ppdb-dot');
        if (banners.length > 1) {
            let current = 0;
            const bannerTimer = setInterval(() => {
                const activeBanners = document.querySelectorAll('.ppdb-banner');
                if (activeBanners.length === 0) {
                    clearInterval(bannerTimer);
                    return;
                }
                
                banners[current].classList.replace('opacity-100', 'opacity-0');
                if (dots[current]) dots[current].classList.remove('bg-white', 'scale-125');
                current = (current + 1) % banners.length;
                banners[current].classList.replace('opacity-0', 'opacity-100');
                if (dots[current]) dots[current].classList.add('bg-white', 'scale-125');
            }, 5000);
            cleanup.push(() => clearInterval(bannerTimer));
        }
    }

    window.loadSPAContent = loadContent;
})();
