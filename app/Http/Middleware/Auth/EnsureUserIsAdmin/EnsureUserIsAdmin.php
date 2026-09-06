<?php

namespace App\Http\Middleware\Auth\EnsureUserIsAdmin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to login page and authentication routes without admin check
        if ($request->routeIs('filament.admin.auth.login') ||
            $request->routeIs('filament.admin.auth.*') ||
            $request->is('admin/login') ||
            $request->is('admin/login/*')) {
            return $next($request);
        }

        // If user is authenticated, check if they are admin
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        // If user is not authenticated, let Filament's Authenticate middleware handle the redirect
        // This middleware only blocks authenticated non-admin users
        return $next($request);
    }
}
