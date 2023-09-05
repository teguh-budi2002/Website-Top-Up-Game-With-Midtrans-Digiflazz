<?php

namespace App\Http\Middleware;

use App\Models\CustomAccessApiToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class ApiAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenFromFrontEnd = $request->header('X-Custom-Token');
        $checkTokenIfExists = CustomAccessApiToken::select("id", "token", "expired_at")->where('token', $tokenFromFrontEnd)->exists();

        if (!$checkTokenIfExists) {
            return response()->json([
                'message' => "You Not Allowed Access This Route API",
                'status'  => "401",
                'token'   => $checkTokenIfExists
                ], 401);
        }

        return $next($request);
    }
}
