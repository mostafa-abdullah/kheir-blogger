<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Authentication Controller for both volunteers
 */
class AuthAPIController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try
        {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials))
                return response()->json(['error' => 'invalid_credentials'], 401);
        }
        catch (JWTException $e)
        {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // no errors, return the token
        return response()->json(compact('token'));
    }
}
