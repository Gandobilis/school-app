<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $authRole = auth()->user()->role;
        if (in_array($authRole, $roles) && $authRole === 'admin') {
            return $next($request);
        }

        abort(404, $authRole . "'s has no permission to this action.");
    }
}
