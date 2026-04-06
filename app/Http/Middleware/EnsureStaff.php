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

        if (!auth()->user()->isStaff() && !auth()->user()->isOwner()) {
            return redirect('/login')->with('error', 'You do not have permission.');
        }

        return $next($request);
    }
}
