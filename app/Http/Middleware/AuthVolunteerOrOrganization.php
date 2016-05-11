<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use JWTAuth;
use Closure;
use Auth;

/**
 * Authenticate volunteers and organizations.
 */
class AuthVolunteerOrOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $guard = null)
     {
        $authenticated = true;
        $token = $request->header('x-access-token');
        if($token)
        {
            try
            {
                JWTAuth::decode(new Token($token));
            }
            catch(TokenInvalidException $e)
            {
                $authenticated = false;
            }
        }
        else if(Auth::guard($guard)->guest())
            $authenticated = false;

        if($authenticated)
            return $next($request);
        if($request->ajax() || $request->wantsJson())
           return response()->json(['error' => 'Unauthorized.'], 401);
        return redirect()->guest('login');
     }
}
