<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Log only normal GET requests that are not AJAX, JSON, Admin, API, or static assets
        if ($request->isMethod('GET')
            && !$request->ajax()
            && !$request->wantsJson()
            && !str_starts_with($request->path(), 'admin')
            && !str_starts_with($request->path(), 'api')
            && !str_starts_with($request->path(), '_') // e.g. _debugbar, _vite
            && !str_contains($request->path(), '.')) {
            
            try {
                $user = Auth::user();
                Visitor::create([
                    'nama' => $user ? $user->name : 'Tamu',
                    'email' => $user ? $user->email : 'guest@tpl.svipb.ac.id',
                    'ip_address' => $request->ip() ?? '127.0.0.1',
                    'user_agent' => $request->userAgent() ?? '',
                    'page_visited' => $request->fullUrl(),
                    'visited_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Keep it silent to prevent crashing user page if DB fails, log error
                logger('Failed to log visitor: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
