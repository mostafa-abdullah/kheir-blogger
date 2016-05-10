<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Token;
use Validator;

/**
 * API Authentication Controller for organizations
 *
 */
class AuthAPIController extends Controller
{

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users|unique:organizations',
            //Password confirmation is done on the device
            'password' => 'required|min:6',
            //TODO: Check for correct date input
            'birth_date' => 'date',
            'phone' => 'max:255',
            'address' => 'max:255',
            'city' => 'max:255',
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
            return response()->json($validator->errors(), 302);
        $this->create($request->all());

        return response()->json(['message' => 'Registered successfully.'], 200);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $temp = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']
            )];

        if(isset($data['birth_date']))
            $temp['birth_date'] = $data['birth_date'];

        if(isset($data['phone']))
            $temp['phone'] = $data['phone'];

        if(isset($data['address']))
            $temp['address'] = $data['address'];

        if(isset($data['city']))
            $temp['city'] = $data['city'];

        return User::create($temp);
    }

    /**
     * Login for a volunteer
     * @param  Request $request: must contain email and password of the volunteer
     * @return json response containing an error in case of invalid credentials or
     * a server error or the token in case of valid credentials
     */
    public function login(Request $request)
    {
        // verify the credentials
        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials, false, false))
            return response()->json(['error' => 'Invalid Credentials'], 401);

        //create token
        try
        {
            $volunteer = User::where('email','=',$credentials['email'])->first();
            $customClaims = ['type' => 'volunteer',
                             'sub'  => $volunteer->id,
                             'role' => $volunteer->role];
            $payload = JWTFactory::make($customClaims);
            $token = JWTAuth::encode($payload);
        }
        catch (JWTException $e)
        {
            // something went wrong
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // no errors, return the token
        return Response::json(['token' => $token->get() , 'user_id' => $volunteer->id]);
    }

    /**
     * Logout for a volunteer.
     */
     public function logout(Request $request)
     {
         try
         {
             if($request->header('x-access-token'))
                 JWTAuth::setToken(new Token($request->header('x-access-token')))->invalidate();
         }
         catch(TokenInvalidException $e)
         {
             // Invalid token
         }
         return response()->json(['message' => 'Logged out.'], 200);
     }
}
