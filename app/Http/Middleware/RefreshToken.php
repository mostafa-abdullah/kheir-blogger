<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Token;

use JWTAuth;
use Closure;

class RefreshToken
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
        $token = $request->header('x-access-token');
        $response = $next($request);
        if($token)
        {
            try
            {
                $token = JWTAuth::refresh(new Token($token));
                $response->headers->set('x-access-token', $token);
            }
            catch(TokenInvalidException $e)
            {

            }
        }
        return $response;
    }
}
