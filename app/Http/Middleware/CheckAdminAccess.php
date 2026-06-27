<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Only allow users where is_admin = true
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'You are not authorized to access this area.');
        }

        return $next($request);
    }
}