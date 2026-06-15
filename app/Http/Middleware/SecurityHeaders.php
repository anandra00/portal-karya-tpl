<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com https://translate.google.com https://translate.googleapis.com https://translate-pa.googleapis.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://www.gstatic.com https://translate.googleapis.com; font-src 'self' https://cdn.jsdelivr.net https://fonts.gstatic.com; img-src 'self' data: https://ui-avatars.com https://translate.google.com https://translate.googleapis.com https://fonts.gstatic.com https://www.gstatic.com https://www.google.com; connect-src 'self' https://cdn.jsdelivr.net https://unpkg.com https://translate.googleapis.com https://translate-pa.googleapis.com; frame-src 'self' https://translate.google.com; object-src 'none';";

        if (config('app.env') === 'local') {
            $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:5173 http://127.0.0.1:5173 https://cdn.jsdelivr.net https://unpkg.com https://translate.google.com https://translate.googleapis.com https://translate-pa.googleapis.com; style-src 'self' 'unsafe-inline' http://localhost:5173 http://127.0.0.1:5173 https://cdn.jsdelivr.net https://fonts.googleapis.com https://www.gstatic.com https://translate.googleapis.com; font-src 'self' https://cdn.jsdelivr.net https://fonts.gstatic.com; img-src 'self' data: http://localhost:5173 http://127.0.0.1:5173 https://ui-avatars.com https://translate.google.com https://translate.googleapis.com https://fonts.gstatic.com https://www.gstatic.com https://www.google.com; connect-src 'self' http://localhost:5173 http://127.0.0.1:5173 ws://localhost:5173 ws://127.0.0.1:5173 https://cdn.jsdelivr.net https://unpkg.com https://translate.googleapis.com https://translate-pa.googleapis.com; frame-src 'self' https://translate.google.com; object-src 'none';";
        }

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
