<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    /**
     * Require the authenticated user to have all listed permissions (comma-separated).
     *
     * Usage: middleware(['auth', 'permission:manage_services'])
     *        middleware(['auth', 'permission:manage_users,manage_bookings'])
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $required = array_values(array_filter(array_map('trim', explode(',', $permissions))));

        if ($required === [] || ! $user->hasAllPermissions($required)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
