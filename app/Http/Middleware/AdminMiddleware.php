<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(403, 'Not logged in');
        }

        if (auth()->user()->role !== 'admin') {
            abort(403, 'You are not admin');
        }

        return $next($request);
    }
}
