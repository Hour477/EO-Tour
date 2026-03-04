<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // If user role does not match, redirect to safe page
        if (Auth::user()->role !== $role) {
            return redirect('/')->with('error', 'You are not authorized to access this page.');
        }

        // Role matches, allow request
        return $next($request);
    }
}