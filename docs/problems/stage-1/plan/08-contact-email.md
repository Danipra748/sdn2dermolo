# Plan 8: Contact Message Email

## Source of Problem
Messages sent via the contact form on the contact page (formerly homepage) should be sent to `sdndermolo728@gmail.com` as requested.

## Project Structure Analysis
-   **Contact Controller:** `ContactMessageController.php` currently stores messages in the database.
-   **Model:** `ContactMessage.php`.
-   **View:** `resources/views/spa/partials/contact.blade.php` (new file) or `resources/views/spa/partials/home.blade.php`.

## Proposed Solution
Update `ContactMessageController.php` to send an email notification when a new contact message is received.

## Implementation Steps
1.  Configure Laravel Mailer for Gmail (or ensure `.env` is set up).
2.  Create a Mailable class `ContactReceivedMail` with a structured layout for the message.
3.  Modify `ContactMessageController.php` to use `Mail::to('sdndermolo728@gmail.com')->send(new ContactReceivedMail($validated))`.
4.  Optionally, use a Queue if the server supports it, to avoid delays in form submission.
