# Plan 5: Automatic Hero Slideshow

## Source of Problem
The hero section on the homepage has multiple slides, but it doesn't advance automatically. The user needs to manually click dots to change slides.

## Project Structure Analysis
-   **Homepage View:** `resources/views/spa/partials/home.blade.php` defines the hero section with `hero-slide` class.
-   **JavaScript:** `public/js/spa.js` contains the `setupSlideshow()` function that handles the slide transitions.

## Proposed Solution
Fix the `autoplay` logic in `public/js/spa.js` to ensure that `startAutoplay()` works correctly and doesn't get interrupted incorrectly.

## Implementation Steps
1.  Debug the `setupSlideshow()` function in `spa.js`.
2.  Ensure that `startAutoplay()` is called during initialization.
3.  Check if there's any conflict between `setupSlideshow()` and `setupHeroSwiper()` in the same file.
4.  Standardize the slideshow implementation to use a more robust logic for automatic sliding.
5.  Ensure that autoplay is re-started after manual dot clicks or hover events.
