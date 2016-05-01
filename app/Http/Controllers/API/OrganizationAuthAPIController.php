<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterOrganizationRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use App\Organization;
use JWTAuth;
use JWTFactory;
use Response;

/**
 * API Authentication Controller for organizations
 *
 */
class OrganizationAuthAPIController extends Controller
{
    /**
     * Register a new organization.
     */
    public function register(RegisterOrganizationRequest $request)
    {
        $organization = $this->organizationService->store($request);
        return response('Registered Successfully.', 200);
    }

    /**
     * Login for an organization
     * @param  Request $request: must contain email and password of the organization
     * @return json response containing an error in case of invalid credentials or
     * a server error or the token in case of valid credentials
     */
    public function login(Request $request)
    {
        // verify the credentials
        $credentials = $request->only('email', 'password');
        if(!auth()->guard('organization')->attempt($credentials))
            return response()->json(['error' => 'Invalid Credentials'], 401);

        //create token
        try
        {
            $organization = Organization::where('email','=',$credentials['email'])->first();
            $customClaims = ['type' => 'organization', 'sub' => $organization->id];
            $payload = JWTFactory::make($customClaims);
            $token = JWTAuth::encode($payload);
        }
        catch (JWTException $e)
        {
            // something went wrong
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // no errors, return the token
        return Response::json(['token' => $token->get()]);
    }

    public function authenticate(Request $request)
    {
        try
        {
            return JWTAuth::decode(new Token($request->get('token')));
        }
        catch(TokenInvalidException $e)
        {
            return response()->json(['error' => 'Invalid Token'], 401);
        }
    }

    /**
     * Logout for an organization.
     */
    public function logout(Request $request)
    {
        try
        {
            JWTAuth::setToken(new Token($request->get('token')))->invalidate();
        }
        catch(TokenInvalidException $e)
        {
            // Invalid token
        }
        return response()->json(['message' => 'Logged out.'], 200);
    }
}
