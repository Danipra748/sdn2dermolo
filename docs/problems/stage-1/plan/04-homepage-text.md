# Plan 4: Homepage Heading Change

## Source of Problem
The heading on the homepage currently says "Profil Singkat SD N 2 Dermolo", but it should say "Sambutan Kepala Sekolah" as it introduces the principal's message.

## Project Structure Analysis
-   **View:** `resources/views/spa/partials/home.blade.php` contains the hardcoded heading.
-   **Content Source:** The content below the heading comes from `$sambutanText`, which is fetched from `SiteSetting`.

## Proposed Solution
Change the static text in `home.blade.php` to "Sambutan Kepala Sekolah".

## Implementation Steps
1.  Open `resources/views/spa/partials/home.blade.php`.
2.  Locate the `<h2>` tag inside the `#tentang` section with text "Profil Singkat SD N 2 Dermolo".
3.  Replace it with "Sambutan Kepala Sekolah".
