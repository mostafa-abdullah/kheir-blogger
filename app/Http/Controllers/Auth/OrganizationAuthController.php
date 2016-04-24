<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterOrganizationRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use App\Organization;

use Auth;
use Input;
use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;
class OrganizationAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:organization', ['except' => 'logout']);
    }

    public function register(RegisterOrganizationRequest $request)
    {
        $organization = new Organization;
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->password = bcrypt($request->password);
        $organization->save();
          /**
           * adding new orgainzation to Elasticsearch in order to keep Elasticsearch in sync with our database
           */
            $client = new Elasticsearch(elasticClientBuilder::create()->build());

          $parameters = [
            'index' => 'organizations',
            'type' => 'organization',
            'id' => $organization->id,
            'body' => [    
                              'name'=>$organization->name,
                              'email'=>$organization->email,
                              'location'=>$organization->location,
                              'rate'=>$organization->rate,
                              'phone'=>$organization->phone
                  ]   
        ]; 
               
        try {
          /**
           * indexing new event and added it to elastic search server
           */
              $newOrganization = $client->index($parameters);
             
             // dd($newOrganization);
          }
            catch (Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) {
                echo "error";
              $last = $elastic->transport->getLastConnection()->getLastRequestInfo();
              $last['response']['error'] = [];
              dd($last);
            }

        auth()->guard('organization')->login($organization);
        return redirect('/');
    }

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

    public function logout()
    {
        Auth::guard('organization')->logout();
        Auth::guard('user')->logout();
        return redirect('/');
    }
}
