<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Protect admin pages using a session flag set by /api/admin/login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('giftos_admin')) {
            abort(403);
        }

        return $next($request);
    }
}
