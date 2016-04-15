<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

use App\Http\Requests;

class OrganizationPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests by organizations
    | and uses a simple trait to include this behavior.
    |
    */

    use ResetsPasswords;

    /**
     * Determine the guard requesting password reset
     * @var string
     */
    protected $guard = 'organization';

    /**
     * Determine the broker for the password reset
     * @var string
     */
    protected $broker = 'organizations';


    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        if (property_exists($this, 'linkRequestView'))
        {
            return view($this->linkRequestView);
        }

        if (view()->exists('auth.passwords.email_organization'))
        {
            return view('auth.passwords.email_organization');
        }

        return view('auth.password');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */

    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token))
        {
            return $this->getEmail();
        }

        $email = $request->input('email');

        if (property_exists($this, 'resetView'))
        {
            return view($this->resetView)->with(compact('token', 'email'));
        }

        if (view()->exists('auth.passwords.reset_organization'))
        {
            return view('auth.passwords.reset_organization')->with(compact('token', 'email'));
        }

        return view('auth.reset')->with(compact('token', 'email'));
    }

    /**
     * Specify the failure message if the email does not exist
     * @param $response
     * @return $this
     */

    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return redirect()->back()->withErrors(['email' => 'Couldn\'t find an organization with that email.']);
    }


    /**
    * Specify the return path after resetting the password.
    * @return $this
    */

    public function redirectPath()
    {
        return '/';
    }
}
