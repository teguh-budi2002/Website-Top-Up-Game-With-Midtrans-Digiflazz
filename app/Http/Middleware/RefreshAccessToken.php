<?php

namespace App\Http\Middleware;

use App\Models\CustomAccessApiToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class RefreshAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customToken = CustomAccessApiToken::select("id", "token", "expired_at")->first();

        // If Token Is NULL = Craete New Token, else = RefreshToken
        if (!$customToken) {
            $customToken = new CustomAccessApiToken();
            $customToken->token = $this->refreshToken();
            $customToken->expired_at = now()->addDays(1);
            $customToken->save();
        } 

        $expirationThreshold = now()->addMinutes(5);
        if (!$customToken->expired_at || $customToken->expired_at <= $expirationThreshold) {
            $customToken->token = $this->refreshToken();
            $customToken->expired_at = now()->addDays(1);
            $customToken->save();
        }

        return $next($request);
    }

    public function refreshToken(): string {
        $tokenLength = 16;

        $randombBytes = random_bytes($tokenLength);
        $encryptToken = Crypt::encryptString($randombBytes);

        return $encryptToken;
    }
}
