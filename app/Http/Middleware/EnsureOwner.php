<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->isOwner()) {
            if (auth()->user()->isStaff()) {
                return redirect('/staff/dashboard')->with('error', 'You do not have permission to access that page.');
            }
            return redirect('/login');
        }

        return $next($request);
    }
}
