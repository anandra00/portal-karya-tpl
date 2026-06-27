---
name: caveman_debugging
description: Guidelines for fast, raw debugging in Laravel (dd, Log::info, reverb debugging, and client console checks).
---

When debugging issues in this workspace:

1. **HTTP/Controller Debugging**:
   - Use `dd($var)` or `dump($var)` to quickly inspect state.
   - For API routes, return raw JSON response to avoid breaking frontend AJAX calls:
     ```php
     return response()->json(['debug' => $var], 500);
     ```

2. **Laravel Logging**:
   - Write logs with `Log::info('msg', [...])` or `Log::error(...)`.
   - Read logs in real-time via `php artisan pail` or checking `storage/logs/laravel.log`.

3. **WebSocket/Reverb Debugging**:
   - Start Reverb with debug output: `php artisan reverb:start --debug`.
   - Test Echo instance in browser console: `console.log(window.Echo.connector.channels)`.

4. **Activity & Visitor Logs**:
   - View visitor logs at `/admin/lihat-pengunjung`.
   - View admin activity logs at `/admin/activity-logs`.
