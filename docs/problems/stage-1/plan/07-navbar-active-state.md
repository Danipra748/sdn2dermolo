# Plan 7: Fix Navbar Active Menu State

## Source of Problem
The active menu state in the navbar (both desktop and mobile) is inconsistent or not updating correctly during SPA transitions.
1.  **Desktop Navbar:** `updateActiveNav` in `spa.js` only targets `a[data-spa]`, but some links (like "Berita") might not have it or use different classes.
2.  **Mobile Navbar:** The mobile menu links are not being updated by `updateActiveNav`.
3.  **Inconsistent Classes:** The active class used in JavaScript (`bg-emerald-50 text-blue-600`) might differ from what's initially rendered by Laravel's `@if(request()->routeIs(...))`.
4.  **Dropdowns:** The parent "Profil" dropdown doesn't stay active when its children are selected during SPA navigation.

## Project Structure Analysis
-   **Layout:** `resources/views/layouts/app.blade.php` contains the desktop and mobile navbar.
-   **JavaScript:** `public/js/spa.js` handles the `updateActiveNav(route)` function.

## Proposed Solution
1.  **Standardize Selectors:** Ensure all navigation links (desktop, mobile, and dropdown items) are correctly targeted by the SPA logic.
2.  **Unified Active Classes:** Use a consistent set of classes for active states across Laravel and JavaScript.
3.  **Dropdown Parent State:** Add logic to highlight the parent dropdown button if any of its children are active.
4.  **Mobile Menu Update:** Ensure `updateActiveNav` also updates the mobile menu links.

## Implementation Steps
1.  Update `resources/views/layouts/app.blade.php`:
    -   Add `data-spa` to the "Berita" link if it's meant to be an SPA link, or handle it specifically.
    -   Ensure mobile menu links have `data-spa` attributes.
2.  Update `public/js/spa.js`:
    -   Refactor `updateActiveNav(route)` to target both `#desktop-menu` (if ID added) and `#mobile-menu`.
    -   Add logic to find parent containers (like the "Profil" dropdown) and apply active classes to the button.
    -   Ensure the classes matched exactly with what Tailwind expects.
3.  Fix the initial state logic to ensure it aligns with the first page load.
