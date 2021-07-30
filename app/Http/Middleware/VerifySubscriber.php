<?php

namespace App\Http\Middleware;

use Closure;

class VerifySubscriber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Check that the api key is provided
        if (!$request->hasHeader('api-key')) {
            return response()->json(['message'       => "Unauthenticated"], 401);
        }

        // Validate APi key
        $check = $this->verifyKey($request->header('api-key'));
        
        if (!$check) {
            return response()->json(['message'       => "Api Key Not Valid"], 401);
        }

        return $next($request);
    }

    /**
     * @param string $apiKey
     * 
     * @return bool
     */
    private function verifyKey(string $apiKey)
    {
        $cipherKey = config('orcas.subscribe_key');
        $hashed = hash_hmac("sha256", "", $cipherKey);

        return hash_equals($apiKey, $hashed);
    }
}
