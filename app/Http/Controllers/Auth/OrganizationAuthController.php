<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\OrganizationService ;

use App\Http\Requests\RegisterOrganizationRequest;
use App\Http\Requests;

use App\User;
use App\Organization;

use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;

use Auth;
use Input;

class OrganizationAuthController extends Controller
{
    private $organizationService;

    /**
     * Constructor.
     * Sets middlewares for controller functions and initializes organization service.
     */
    public function __construct()
    {
        $this->organizationService = new OrganizationService();
        $this->middleware('guest:organization', ['except' => 'logout']);
    }

    /**
     * Register a new organization.
     */
    public function register(RegisterOrganizationRequest $request)
    {
        $organization = $this->organizationService->store($request);
        auth()->guard('organization')->login($organization);
        return redirect('/');
    }

    /**
     * Login for an organization.
     */
    public function login()
    {
        $input = Input::all();
        if(count($input) > 0)
        {
            $auth = auth()->guard('organization');

            $credentials = [
                'email' =>  $input['email'],
                'password' =>  $input['password'],
            ];

            if ($auth->attempt($credentials))
            {
                $organization = Organization::where('email','=',$input['email'])->first();
                auth()->guard('organization')->login($organization);
                return redirect('/');
            }
            return redirect('/login_organization')
                    ->withErrors(['Login'=>'These credentials do not match our records.']);
        }
        return redirect('/login_organization');
    }

    /**
     * Logout for an organization.
     */
    public function logout()
    {
        Auth::guard('organization')->logout();
        Auth::guard('user')->logout();
        return redirect('/');
    }

    /**
     * Add new orgainzation to Elasticsearch in order to keep Elasticsearch
     * in sync with our database.
     */
    public function addToElastic($organization)
    {

        $client = new Elasticsearch(elasticClientBuilder::create()->build());

        $parameters = [
          'index' => 'organizations',
          'type'  => 'organization',
          'id'    => $organization->id,
          'body'  => [
                        'name'     => $organization->name,
                        'email'    => $organization->email,
                        'slogan'   => $organization->slogan,
                        'location' => $organization->location,
                        'phone'    => $organization->phone
                     ]
        ];

        try
        {
            $client->index($parameters);
        }
        catch(Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e)
        {
            echo "Error";
            $last = $elastic->transport->getLastConnection()->getLastRequestInfo();
            $last['response']['error'] = [];
            dd($last);
        }
    }
}
