# Plan 6: News Back Button

## Source of Problem
The news detail page lacks a "Back" button to return to the news list, which makes navigation difficult for users.

## Project Structure Analysis
-   **News Detail View:** `resources/views/news/show.blade.php` shows the article content.
-   **News Index Route:** The news list is available via `route('news.index')`.

## Proposed Solution
Add a "Back" button in `resources/views/news/show.blade.php` that points to the news list page.

## Implementation Steps
1.  Open `resources/views/news/show.blade.php`.
2.  Add a button with text "Kembali ke Berita" before the article content or below it.
3.  Ensure the button is styled consistently with the rest of the site and is responsive.
