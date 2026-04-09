<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->isOwner()) {
            return redirect('/owner/dashboard')->with('error', 'You do not have permission to access that page.');
        }

        if (!auth()->user()->isStaff()) {
            return redirect('/login')->with('error', 'You do not have permission.');
        }

        return $next($request);
    }
}
