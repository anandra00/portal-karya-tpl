<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Version checks apply to API requests
        if ($request->is('api/*')) {
            $version = $request->header('X-API-Version');

            if (!$version) {
                $acceptHeader = $request->header('Accept');
                if ($acceptHeader && preg_match('/vnd\.portaltpl\.v(\d+)\+json/', $acceptHeader, $matches)) {
                    $version = $matches[1];
                }
            }

            // Default to version 1 if not specified
            if (!$version) {
                $version = '1';
            }

            // Reject unsupported versions with a 406 Not Acceptable response
            if (!in_array($version, ['1', '1.0'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'API version not supported. Supported versions: 1'
                ], 406);
            }

            // Set the version as an attribute for reference in controllers/views
            $request->attributes->set('api_version', $version);
        }

        return $next($request);
    }
}
