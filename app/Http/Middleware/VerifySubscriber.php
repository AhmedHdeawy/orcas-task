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
            return response()->json(['status'        => 401, 'message'       => "Unauthenticated"]);
        }

        // Validate APi key
        $check = $this->verifyKey($request->header('api-key'));
        
        if (!$check) {
            return response()->json(['status'        => 401, 'message'       => "Api Key Not Valid"]);
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
