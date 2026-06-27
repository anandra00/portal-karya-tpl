---
name: l5_swagger
description: Instructions for updating, scanning, and generating interactive OpenAPI/Swagger docs in this workspace.
---

When modifying routes, inputs, or outputs of the API:
1. Always update the PHP 8 Attributes annotations in [ApiController.php](file:///c:/laragon/www/PJBL-EUYY/Modules/Core/app/Http/Controllers/api/ApiController.php).
2. Scan paths are configured in [l5-swagger.php](file:///c:/laragon/www/PJBL-EUYY/config/l5-swagger.php) to target modular monolith directories.
3. Access to `/api/documentation` is protected and restricted to administrators.
4. Regenerate Swagger documentation json by running: `php artisan l5-swagger:generate`.
