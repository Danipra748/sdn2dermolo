# Plan 1: Fix Image Modals

## Source of Problem
The image modals in Sarana Prasarana, Gallery, and Prestasi pages are not appearing correctly. This is likely due to:
1.  **Z-index issues:** The modals might be behind other elements.
2.  **Initialization order:** The SPA (Single Page Application) logic might not be re-initializing the modal listeners when a new page is loaded.
3.  **Trigger selectors:** The data attributes used for triggering the modals might have inconsistencies between the HTML and the JavaScript.

## Project Structure Analysis
-   **Views:**
    -   `resources/views/spa/partials/sarana-prasarana.blade.php`: Contains `#facility-modal` and buttons with `data-facility-card`.
    -   `resources/views/spa/partials/prestasi.blade.php`: Contains `#prestasi-modal` and buttons with `data-prestasi-card`.
    -   `resources/views/spa/partials/home.blade.php`: Contains `#gallery-modal` and buttons with `data-gallery-card`.
-   **JavaScript:**
    -   `public/js/spa.js`: Contains `reinitializeComponents()` which calls `setupFacilityModal()`, `setupPrestasiModal()`, and `setupGalleryModal()`. It also has a global click listener `handleDynamicClick`.

## Proposed Solution
1.  **Check and Fix Z-index:** Ensure the modals have a higher z-index (currently `z-[60]`) and that their parent containers don't restrict them.
2.  **Refactor Modal Triggers:** Standardize the modal trigger logic in `spa.js` to ensure it works consistently across all pages.
3.  **Ensure Re-initialization:** Verify that `reinitializeComponents()` is correctly called after every SPA content load and that it properly binds the events.
4.  **Fix Backdrop and Close Logic:** Ensure the backdrop and close buttons correctly hide the modal.

## Implementation Steps
1.  Verify the `data-*-card` attributes in all partials.
2.  Update `public/js/spa.js` to ensure `handleDynamicClick` correctly identifies the triggers even if clicked on a child element of the button.
3.  Add a debug log to `spa.js` to verify when a card is clicked and if the modal open function is called.
4.  Ensure the modal container is not nested inside an element with `overflow: hidden` or low `z-index`.
