---
name: laravel_modules
description: Guidelines for managing the Modular Monolith structure and modules in this workspace.
---

When developing or adding new features:
1. Follow the **Modular Monolith** structure via `nwidart/laravel-modules`.
2. Core domains are split into:
   - `Modules/Core`: Dashboard, visitor logs, static pages.
   - `Modules/Auth`: Authentication, RBAC.
   - `Modules/Karya`: Karya uploads, reviews, ratings.
   - `Modules/Akademik`: Dosen, mata kuliah, berita.
3. Use Module-specific artisan commands:
   - `php artisan module:make-controller ControllerName ModuleName`
   - `php artisan module:make-model ModelName ModuleName`
   - `php artisan module:make-migration migration_name ModuleName`
4. Run migrations using `php artisan module:migrate` and seeders via `php artisan module:seed`.
