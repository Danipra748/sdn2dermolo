# Plan 3: School Logo Upload & Dynamic Logo

## Source of Problem
-   The school logo upload lacks cropping and preview with a specific ratio (1:1).
-   The logo and favicon are not dynamic (currently static assets in `public/`).
-   Need to support multiple formats (WebP for logo, ICO for favicon) for better performance and compatibility.

## Project Structure Analysis
-   **Admin View:** `resources/views/admin/school-profile/edit.blade.php` handles the logo upload UI.
-   **Controller:** `AdminSchoolProfileController.php` handles the backend logic for logo storage.
-   **Model:** `SchoolProfile.php` stores the logo path.
-   **Global Layout:** `resources/views/layouts/app.blade.php` (and partials) contains the navbar and footer where the logo is displayed.

## Proposed Solution
1.  **Frontend Cropping:** Integrate `Cropper.js` in the logo upload section to allow 1:1 ratio cropping.
2.  **Backend Processing:** Use PHP GD to process the uploaded image:
    -   Crop/Resize to 512x512.
    -   Save as `logo.webp` (high quality, small size).
    -   Save as `favicon.ico` (standard size 32x32 or 48x48).
3.  **Dynamic Display:** Update the frontend to fetch the logo path from `SchoolProfile`. If not set, use a default fallback.
4.  **Seeder:** Create a seeder to set the initial logo using a default image from `database/seeders/images/logo/tut-wuri-handayani.png`.

## Implementation Steps
1.  Add `Cropper.js` CDN and CSS to `admin/layout.blade.php` or `school-profile/edit.blade.php`.
2.  Update `AdminSchoolProfileController.php` to handle base64 cropped image or file with cropping coordinates.
3.  Implement image conversion logic (to WebP and ICO) in the controller or a service.
4.  Update `SchoolProfile` model to handle the storage of these files.
5.  Modify `resources/views/layouts/app.blade.php` and its partials to use the dynamic logo.
6.  Create `Database\Seeders\LogoSeeder` and provide the "tut wuri handayani" image.
