---
name: laravel_sanctum
description: Instructions for managing Sanctum token auth, API routes, rate limiting, and API testing in this workspace.
---

When editing API endpoints or Sanctum authentication:
1. API routes are defined in [api.php](file:///c:/laragon/www/PJBL-EUYY/routes/api.php).
2. Token expiration is configured in [sanctum.php](file:///c:/laragon/www/PJBL-EUYY/config/sanctum.php) (default is 24 hours / 1440 minutes).
3. The API login endpoint `/api/v1/login` has a strict rate limit of 5 requests/minute (`throttle:5,1`).
4. Protected write endpoints use `auth:sanctum` middleware.
5. Verify changes by running integration tests: `php artisan test --filter=ApiSanctumTest`.
