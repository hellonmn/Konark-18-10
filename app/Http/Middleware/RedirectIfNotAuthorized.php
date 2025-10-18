<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthorized
{
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!auth()->check()) {
        // Laravel will handle redirection via 'auth' middleware
        abort(401, 'Not logged in');
    }

    $userRole = auth()->user()->role;

    if (!in_array($userRole, $roles)) {
        abort(403, "Access denied for role: {$userRole}");
    }

    return $next($request);
}

}
