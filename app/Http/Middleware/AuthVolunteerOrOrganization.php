<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use JWTAuth;
use Closure;
use Auth;

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
         if ($request->ajax() || $request->wantsJson())
         {
             $token = $request->header('x-access-token');
             if(!$token)
               return response()->json(['error' => 'Unauthorized.'], 401);
             try
             {
                  JWTAuth::decode(new Token($token));
             }
             catch(TokenInvalidException $e)
             {
                  return response()->json(['error' => 'Unauthorized.'], 401);
             }
         }
         else
             if(Auth::guard($guard)->guest())
                 return redirect()->guest('login');

         // Authenticated!
         return $next($request);
     }
}
