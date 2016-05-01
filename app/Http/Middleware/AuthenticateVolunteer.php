<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use App\User;
use JWTAuth;
use Closure;
use Auth;
/**
 * Handles requests that are only allowed for volunteers
 */
class AuthenticateVolunteer
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
                 if($payload['type'] != 'volunteer' || !$payload['role'])
                     return response()->json(['error' => 'Unauthorized.'], 401);
             }
             catch(TokenInvalidException $e)
             {
                 return response()->json(['error' => 'Invalid token.'], 401);
             }
             $request['volunteer'] = User::find($payload['sub']);
         }
         else
            if(!Auth::user() || !Auth::user()->role)
                 return redirect()->guest('login');
            else
                $request['volunteer'] = Auth::user();
         // Authenticated!
         return $next($request);
     }
}
