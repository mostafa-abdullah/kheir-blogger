<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use JWTAuth;
use Closure;

/**
 * Handles requests that are only allowed for volunteers
 */
class AuthenticateOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax() || $request->wantsJson())
        {

            $token = $request->header('x-access-token');
            if(!$token)
                return response()->json(['error' => 'No token provided.'], 401);

            try
            {
                $payload = JWTAuth::decode(new Token($token));
                if($payload['type'] != 'organization')
                    return response()->json(['error' => 'Unauthorized.'], 401);
            }
            catch(TokenInvalidException $e)
            {
                return response()->json(['error' => 'Invalid token.'], 401);
            }
        }
        else
            if(!auth()->guard('organization')->check())
                return redirect()->guest('login_organization');
                
        // Authenticated!
        return $next($request);
    }
}
