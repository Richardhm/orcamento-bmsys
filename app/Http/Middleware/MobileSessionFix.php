<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MobileSessionFix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        config([
            'session.path' => '/',
            'session.domain' => null,
            'session.secure' => false,
            'session.same_site' => 'lax'
        ]);

        return $next($request);
    }
}
