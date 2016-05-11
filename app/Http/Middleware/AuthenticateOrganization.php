<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use App\Organization;
use JWTAuth;
use Closure;

/**
 * Authenticate organizations.
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
     public function handle($request, Closure $next, $guard = null)
     {
        $authenticated = true;
        $token = $request->header('x-access-token');
        if($token)
        {
            try
            {
                $payload = JWTAuth::decode(new Token($token));
                if($payload['type'] == 'organization')
                    $request['organization'] = Organization::find($payload['sub']);
                else
                    $authenticated = false;
            }
            catch(TokenInvalidException $e)
            {
                $authenticated = false;
            }
        }
        else if(auth()->guard('organization')->check())
            $request['organization'] = auth()->guard('organization')->user();
        else
            $authenticated = false;

        if($authenticated)
            return $next($request);
        if($request->ajax() || $request->wantsJson())
           return response()->json(['error' => 'Unauthorized.'], 401);
        return redirect()->guest('login_organization');
     }
}
