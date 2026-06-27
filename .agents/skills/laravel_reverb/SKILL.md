---
name: laravel_reverb
description: Instructions for managing real-time notifications via Laravel Reverb and Echo in this workspace.
---

When working with real-time features, broadcasting, or notifications:
1. Verify Reverb configuration in `.env` (VITE_REVERB_* variables).
2. Broadcast notifications use the database + Reverb driver.
3. Event listeners are located in [navbar.blade.php](file:///c:/laragon/www/PJBL-EUYY/resources/views/partials/navbar.blade.php).
4. Run `php artisan reverb:start --debug` to debug WebSocket connections locally.
5. Notification classes are stored in `Modules/Karya/app/Notifications/`.
6. Broadcast client-side configuration is in [echo.js](file:///c:/laragon/www/PJBL-EUYY/resources/js/echo.js).
