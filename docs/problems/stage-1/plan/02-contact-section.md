# Plan 2: Separate Contact Section

## Source of Problem
The contact section is currently part of the homepage (`home.blade.php`), which makes the homepage too long and less focused. It should have its own page as requested.

## Project Structure Analysis
-   **Homepage View:** `resources/views/spa/partials/home.blade.php` contains the contact section under `<section id="kontak">`.
-   **Route:** The current contact route leads to the same SPA page or was not explicitly defined.
-   **SPA Logic:** The application uses an SPA approach (controlled by `public/js/spa.js`).

## Proposed Solution
1.  **Extract Section:** Move the contact section from `resources/views/spa/partials/home.blade.php` to a new file `resources/views/spa/partials/contact.blade.php`.
2.  **Define Route:** Ensure a route exists (e.g., `/kontak`) and its corresponding SPA route (e.g., `/spa/contact`).
3.  **Update Navigation:** Update the navbar and footer to link to the new contact page instead of an anchor (`#kontak`).
4.  **Update SPA Configuration:** Add the new route to `public/js/spa.js` `routeMap`.

## Implementation Steps
1.  Create `resources/views/spa/partials/contact.blade.php` by copying the contact section from `home.blade.php`.
2.  Update `routes/web.php` to include the new contact route.
3.  Modify `resources/views/spa/partials/home.blade.php` to remove the contact section.
4.  Update `public/js/spa.js` `routeMap` and navigation logic.
5.  Add a "Back to Home" button or ensure consistent layout on the new contact page.
