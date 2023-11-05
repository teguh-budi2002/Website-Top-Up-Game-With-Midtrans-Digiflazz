<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CanAccessDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role->role_name == "Reseller") {
                return redirect()->route('login')->with('invalid-login', 'Only CEO & Admin Can Access Main Dashboard');
            }
            return $next($request);
        }
        return redirect()->route('login')->with('invalid-login', 'Please Login to Access Main Dashboard');
    }
}
