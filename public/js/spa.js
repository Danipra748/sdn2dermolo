/**
 * SDN 2 Dermolo - Single Page Application (SPA)
 * Handles dynamic content loading without page refresh.
 */

(function () {
    'use strict';

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
        '/tentang-kami': {
            route: '/spa/about',
            title: 'Tentang Kami - SD N 2 Dermolo',
        },
        '/news': {
            route: '/spa/berita',
            title: 'Berita - SD N 2 Dermolo',
        },
        '/program': {
            route: '/spa/program',
            title: 'Program - SD N 2 Dermolo',
        },
    };

    let currentRoute = null;
    let isLoading = false;
    let revealObserver = null;
    let loadingTimer = null;
    const memoryCache = new Map();

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

            if (state && state.route) {
                loadContent(state.route, state.title || document.title, false, state.hash || '');
                return;
            }

            const destination = routeMap[window.location.pathname];

            if (destination) {
                loadContent(destination.route, destination.title, false, window.location.hash || '');
            }
        });
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
        scheduleLoading(contentArea, route);

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
            currentRoute = previousRoute;
            updateActiveNav(previousRoute);
            showError(error instanceof Error ? error.message : 'Unknown error');
            console.error('SPA load failed:', error);
        } finally {
            hideLoading(contentArea);
            isLoading = false;
        }
    }

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
        }).then(async (response) => {
            if (! response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();

            if (! data.success || typeof data.html !== 'string') {
                throw new Error('Invalid SPA response.');
            }

            return data;
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

        // Ensure content is visible before reinitializing components
        const contentArea = getContentArea();
        if (contentArea) {
            contentArea.style.opacity = '1';
            contentArea.style.visibility = 'visible';
        }

        // Reinitialize all components after a brief delay to ensure DOM is ready
        window.setTimeout(() => {
            // Double-check content is still visible
            if (contentArea && !contentArea.innerHTML.trim()) {
                console.warn('[SPA] Content area is empty after render');
            }

            reinitializeComponents();

            // Third scroll attempt after components are initialized
            window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
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

    function scheduleLoading(contentArea, route) {
        window.clearTimeout(loadingTimer);
        loadingTimer = window.setTimeout(() => showLoading(contentArea, route), config.loadingDelay);
    }

    function showLoading(contentArea, route) {
        if (! contentArea) {
            return;
        }

        const minHeight = Math.min(Math.max(contentArea.offsetHeight, 480), 1400);

        contentArea.dataset.loadingState = 'true';
        contentArea.setAttribute('aria-busy', 'true');
        contentArea.style.minHeight = `${minHeight}px`;
        contentArea.style.opacity = '1';
        contentArea.innerHTML = getLoadingTemplate(route);
    }

    function hideLoading(contentArea) {
        window.clearTimeout(loadingTimer);
        loadingTimer = null;

        if (! contentArea) {
            return;
        }

        contentArea.removeAttribute('aria-busy');
        contentArea.removeAttribute('data-loading-state');
        contentArea.style.minHeight = '';
    }

    function getLoadingTemplate(route) {
        if (route === '/spa/data-guru') {
            return buildGuruLoadingTemplate();
        }

        if (route === '/spa/prestasi') {
            return buildPrestasiLoadingTemplate();
        }

        return buildGenericLoadingTemplate();
    }

    function buildLoadingShell(content) {
        return `
            <div class="relative bg-slate-50">
                <div class="pointer-events-none absolute right-6 top-6 z-10 hidden items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-slate-200 md:inline-flex">
                    <span class="inline-flex h-2.5 w-2.5 animate-ping rounded-full bg-blue-500"></span>
                    <span class="-ml-2 inline-flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                    <span class="sr-only">Memuat konten</span>
                </div>
                ${content}
            </div>
        `;
    }

    function buildHeroLoadingTemplate() {
        return `
            <section class="hero-fullscreen relative overflow-hidden text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
                <div class="hero-content mx-auto max-w-6xl px-6 py-16 text-center">
                    <div class="mx-auto h-10 w-40 animate-pulse rounded-full bg-white/15"></div>
                    <div class="mx-auto mt-6 h-7 w-3/4 max-w-2xl animate-pulse rounded-full bg-white/25"></div>
                    <div class="mx-auto mt-4 h-5 w-2/3 max-w-xl animate-pulse rounded-full bg-white/20"></div>
                    <div class="mx-auto mt-3 h-4 w-full max-w-2xl animate-pulse rounded-full bg-white/10"></div>
                    <div class="mx-auto mt-3 h-4 w-5/6 max-w-xl animate-pulse rounded-full bg-white/10"></div>
                </div>
            </section>
        `;
    }

    function buildGuruLoadingTemplate() {
        const cards = Array.from({ length: 6 }, () => `
            <div class="rounded-3xl border border-slate-200 bg-white p-7 text-center shadow-sm">
                <div class="mx-auto h-20 w-20 animate-pulse rounded-full bg-slate-200"></div>
                <div class="mx-auto mt-5 h-5 w-3/4 animate-pulse rounded-full bg-slate-200"></div>
                <div class="mx-auto mt-3 h-4 w-1/2 animate-pulse rounded-full bg-slate-100"></div>
            </div>
        `).join('');

        return buildLoadingShell(`
            ${buildHeroLoadingTemplate()}
            <section class="bg-slate-50 px-4 py-12">
                <div class="mx-auto max-w-6xl">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                        <div class="flex flex-col gap-5 md:flex-row md:items-center">
                            <div class="h-20 w-20 animate-pulse rounded-full bg-slate-200"></div>
                            <div class="flex-1">
                                <div class="h-4 w-28 animate-pulse rounded-full bg-slate-100"></div>
                                <div class="mt-3 h-8 w-2/3 max-w-sm animate-pulse rounded-full bg-slate-200"></div>
                                <div class="mt-3 h-4 w-1/2 max-w-xs animate-pulse rounded-full bg-slate-100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        ${cards}
                    </div>
                </div>
            </section>
        `);
    }

    function buildPrestasiLoadingTemplate() {
        const cards = Array.from({ length: 8 }, () => `
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="aspect-[4/3] animate-pulse bg-slate-200"></div>
                <div class="p-5">
                    <div class="h-5 w-4/5 animate-pulse rounded-full bg-slate-200"></div>
                    <div class="mt-3 h-6 w-24 animate-pulse rounded-full bg-slate-100"></div>
                    <div class="mt-4 h-4 w-full animate-pulse rounded-full bg-slate-100"></div>
                    <div class="mt-2 h-4 w-3/4 animate-pulse rounded-full bg-slate-100"></div>
                </div>
            </div>
        `).join('');

        return buildLoadingShell(`
            ${buildHeroLoadingTemplate()}
            <section class="bg-slate-50 px-4 py-16">
                <div class="mx-auto max-w-7xl">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
                        ${cards}
                    </div>
                </div>
            </section>
        `);
    }

    function buildGenericLoadingTemplate() {
        const cards = Array.from({ length: 4 }, () => `
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="h-52 animate-pulse rounded-2xl bg-slate-200"></div>
                <div class="mt-5 h-5 w-2/3 animate-pulse rounded-full bg-slate-200"></div>
                <div class="mt-3 h-4 w-full animate-pulse rounded-full bg-slate-100"></div>
                <div class="mt-2 h-4 w-5/6 animate-pulse rounded-full bg-slate-100"></div>
            </div>
        `).join('');

        return buildLoadingShell(`
            ${buildHeroLoadingTemplate()}
            <section class="bg-slate-50 px-4 py-12">
                <div class="mx-auto max-w-6xl">
                    <div class="grid gap-6 md:grid-cols-2">
                        ${cards}
                    </div>
                </div>
            </section>
        `);
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
        // Target all SPA links EXCEPT footer (we'll handle footer separately)
        document.querySelectorAll('a[data-spa]').forEach((link) => {
            // Skip if this link is inside footer
            if (link.closest('footer')) {
                return;
            }
            link.classList.remove('bg-emerald-50', 'text-blue-600');
        });

        if (! route) {
            return;
        }

        // Add active state to matching non-footer links
        document.querySelectorAll(`a[data-spa="${route}"]`).forEach((link) => {
            // Skip if this link is inside footer
            if (link.closest('footer')) {
                return;
            }
            link.classList.add('bg-emerald-50', 'text-blue-600');
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
        const modals = ['facility-modal', 'prestasi-modal'];
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
        // Setup click handlers for facility cards
        setupFacilityCardClicks();
        
        // Setup click handlers for prestasi cards
        setupPrestasiCardClicks();
        
        // Setup click handlers for program/ekstrakurikuler cards
        setupProgramCardClicks();
        
        // Setup click handlers for any other dynamic elements
        setupGeneralClickHandlers();
        
        // Setup event delegation for news cards
        setupNewsCardDelegation();
        
        // Setup event delegation for program cards
        setupProgramCardDelegation();
        
        // Setup event delegation for prestasi cards
        setupPrestasiCardDelegation();
        
        console.log('[SPA] Dynamic click handlers initialized');
    }

    function setupProgramCardClicks() {
        // Program cards might have links or modals
        document.querySelectorAll('[data-program-card]').forEach(card => {
            const link = card.querySelector('a');
            if (link) {
                card.style.cursor = 'pointer';
                card.addEventListener('click', (e) => {
                    // Don't trigger if clicking on interactive elements
                    if (e.target.closest('a, button, input, [data-toggle]')) {
                        return;
                    }
                    link.click();
                });
            }
        });
        console.log('[SPA] Program card clicks setup');
    }

    function setupNewsCardDelegation() {
        // Event delegation for news cards (already using <a> tags, so they work natively)
        // This ensures they work even after DOM updates
        document.addEventListener('click', (e) => {
            const newsCard = e.target.closest('[data-news-card]');
            if (newsCard) {
                const link = newsCard.querySelector('a[href]');
                if (link && !e.target.closest('a[href]')) {
                    // Card is clickable but user didn't click a link
                    // The card itself is an <a> tag, so it will work natively
                }
            }
        });
        console.log('[SPA] News card delegation setup');
    }

    function setupProgramCardDelegation() {
        // Event delegation for program/ekstrakurikuler cards
        document.addEventListener('click', (e) => {
            const programCard = e.target.closest('[data-program-card]');
            if (programCard) {
                const link = programCard.querySelector('a[href]');
                if (link && !e.target.closest('a[href], button, input')) {
                    window.location.href = link.href;
                }
            }
        });
        console.log('[SPA] Program card delegation setup');
    }

    function setupPrestasiCardDelegation() {
        // Event delegation for prestasi cards
        // These cards use data attributes to open modals
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
        
        // Escape key handler for prestasi modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('prestasi-modal');
                if (modal && modal.classList.contains('is-open')) {
                    closePrestasiModal();
                }
            }
        });
        
        console.log('[SPA] Prestasi card delegation setup');
    }

    function openPrestasiModal(card) {
        const modal = document.getElementById('prestasi-modal');
        if (!modal) return;

        const imageEl = document.getElementById('prestasi-modal-image');
        const titleEl = document.getElementById('prestasi-modal-title');
        const descEl = document.getElementById('prestasi-modal-desc');

        if (!imageEl || !titleEl || !descEl) return;

        const title = card.dataset.title || '';
        const desc = card.dataset.desc || 'Deskripsi prestasi belum tersedia.';
        const img = card.dataset.image || '';

        titleEl.textContent = title;
        descEl.textContent = desc;

        if (img) {
            imageEl.src = img;
            imageEl.style.display = 'block';
        } else {
            imageEl.removeAttribute('src');
            imageEl.style.display = 'none';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex', 'is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closePrestasiModal() {
        const modal = document.getElementById('prestasi-modal');
        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex', 'is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    function setupFacilityCardClicks() {
        const modal = document.getElementById('facility-modal');
        if (!modal) return;

        const imageEl = document.getElementById('facility-modal-image');
        const titleEl = document.getElementById('facility-modal-title');
        const descEl = document.getElementById('facility-modal-desc');

        if (!imageEl || !titleEl || !descEl) return;

        const openModal = (card) => {
            titleEl.textContent = card.dataset.title || '';
            descEl.textContent = card.dataset.desc || 'Deskripsi fasilitas belum tersedia.';

            if (card.dataset.image) {
                imageEl.src = card.dataset.image;
                imageEl.style.display = 'block';
            } else {
                imageEl.removeAttribute('src');
                imageEl.style.display = 'none';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex', 'is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        // Remove old event listeners by cloning nodes
        document.querySelectorAll('[data-facility-card]').forEach(card => {
            const newCard = card.cloneNode(true);
            card.parentNode.replaceChild(newCard, card);
            newCard.addEventListener('click', () => openModal(newCard));
        });

        modal.querySelectorAll('[data-facility-close]').forEach(button => {
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            newButton.addEventListener('click', closeModal);
        });

        // Add Escape key handler
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });
    }

    function setupPrestasiCardClicks() {
        const modal = document.getElementById('prestasi-modal');
        if (!modal) return;

        const imageEl = document.getElementById('prestasi-modal-image');
        const titleEl = document.getElementById('prestasi-modal-title');
        const descEl = document.getElementById('prestasi-modal-desc');

        if (!imageEl || !titleEl || !descEl) return;

        const openModal = (card) => {
            titleEl.textContent = card.dataset.title || '';
            descEl.textContent = card.dataset.desc || 'Deskripsi prestasi belum tersedia.';

            if (card.dataset.image) {
                imageEl.src = card.dataset.image;
                imageEl.style.display = 'block';
            } else {
                imageEl.removeAttribute('src');
                imageEl.style.display = 'none';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex', 'is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        // Remove old event listeners by cloning nodes
        document.querySelectorAll('[data-prestasi-card]').forEach(card => {
            const newCard = card.cloneNode(true);
            card.parentNode.replaceChild(newCard, card);
            newCard.addEventListener('click', () => openModal(newCard));
        });

        modal.querySelectorAll('[data-prestasi-close]').forEach(button => {
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            newButton.addEventListener('click', closeModal);
        });

        // Add Escape key handler
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });
    }

    function setupGeneralClickHandlers() {
        // Handle accordion/toggle elements
        document.querySelectorAll('[data-toggle], .accordion-toggle').forEach(toggle => {
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);
            
            newToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(newToggle.dataset.target || newToggle.getAttribute('href'));
                if (target) {
                    target.classList.toggle('hidden');
                    newToggle.classList.toggle('active');
                }
            });
        });

        // Handle tabs
        document.querySelectorAll('[data-tab]').forEach(tab => {
            const newTab = tab.cloneNode(true);
            tab.parentNode.replaceChild(newTab, tab);
            
            newTab.addEventListener('click', (e) => {
                e.preventDefault();
                const tabGroup = newTab.closest('[data-tab-group]');
                if (tabGroup) {
                    tabGroup.querySelectorAll('[data-tab]').forEach(t => t.classList.remove('active'));
                    tabGroup.querySelectorAll('[data-tab-content]').forEach(c => c.classList.add('hidden'));
                    
                    newTab.classList.add('active');
                    const contentId = newTab.dataset.tab;
                    const content = document.querySelector(`[data-tab-content="${contentId}"]`);
                    if (content) {
                        content.classList.remove('hidden');
                    }
                }
            });
        });

        console.log('[SPA] General click handlers initialized');
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

            // Add fade out effect
            heroTitleEl.style.transition = 'opacity 0.3s ease-in-out';
            heroSubtitleEl.style.transition = 'opacity 0.3s ease-in-out';
            heroTitleEl.style.opacity = '0';
            heroSubtitleEl.style.opacity = '0';

            // Update text after fade out
            setTimeout(() => {
                if (newTitle) {
                    // Split title at <br> if it exists
                    const titleParts = newTitle.split('<br>');
                    if (titleParts.length > 1) {
                        heroTitleEl.innerHTML = titleParts[0] + '<br><span id="hero-subtitle" class="bg-gradient-to-r from-amber-400 to-yellow-200 bg-clip-text text-transparent">' + titleParts[1] + '</span>';
                    } else {
                        heroTitleEl.textContent = newTitle;
                    }
                }
                
                if (newSubtitle) {
                    const subtitleEl = document.getElementById('hero-subtitle');
                    if (subtitleEl) {
                        subtitleEl.textContent = newSubtitle + ' Generasi Unggul';
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
            if (index === currentSlide) {
                return;
            }

            slides[currentSlide].style.opacity = '0';
            slides[currentSlide].style.zIndex = '1';
            slides[currentSlide].setAttribute('aria-hidden', 'true');

            currentSlide = index;

            slides[currentSlide].style.opacity = '1';
            slides[currentSlide].style.zIndex = '10';
            slides[currentSlide].setAttribute('aria-hidden', 'false');
            
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
            autoplayId = window.setInterval(() => {
                goToSlide((currentSlide + 1) % slides.length);
            }, interval);
        };

        dots.forEach((dot, index) => {
            const handleClick = () => {
                goToSlide(index);
                startAutoplay();
            };

            dot.addEventListener('click', handleClick);
            cleanup.push(() => dot.removeEventListener('click', handleClick));
        });

        updateDots(currentSlide);

        const handleMouseEnter = () => stopAutoplay();
        const handleMouseLeave = () => startAutoplay();

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

        // Event listeners are now handled in setupFacilityCardClicks
        // This function just marks the modal as initialized
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

        // Event listeners are now handled in setupPrestasiCardClicks
        // This function just marks the modal as initialized
        modal.dataset.initialized = 'true';
        
        console.log('[SPA] Prestasi modal initialized');
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

    window.loadSPAContent = loadContent;
})();
