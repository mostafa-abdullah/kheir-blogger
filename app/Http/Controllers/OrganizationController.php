<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterOrganizationRequest;
use App\Http\Requests\RecommendationRequest;

use App\Http\Controllers\Controller;
use App\Organization;
use App\Recommendation;

use Hash;
use Auth;


class OrganizationController extends Controller
{

    public function __construct(){
        $this->middleware('auth_volunteer', ['only' => [
            // Add all functions that are allowed for volunteers only
        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
            'register',
        ]]);

        $this->middleware('auth_both', ['only' => [
            // Add all functions that are allowed for volunteers/organizations only

        ]]);

    }

    /**
     * registers a new organization
     */
    public function register(RegisterOrganizationRequest $request){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        $organization = new Organization;
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->password = bcrypt($request->password);
        $organization->save();
        auth()->guard('organization')->login($organization);
        return redirect('home');
    }

    /**
    * edit to edit the profile of organization.
    *
    * @return view
    */
    public function edit($id){

      if(auth()->guard('organization')->check() && auth()->guard('organization')->id()==$id){
        $organization = Organization::findorfail($id);
        return view('organization.edit' , compact('organization'));
      }else{
        return redirect('login_organization');
      }
    }

    /**
    * show to show the profile of organization.
    *
    * @return view
    */
    public function show($id){

        //TODO: return a view with the organization profile (Badry)
        $organization = Organization::findOrFail($id);
        return $organization;
    }


    /**
    * update to update the profile of organization.
    *
    * @return redirect
    */
    public function update($id ,Requests\OrganizationRequest $request){
      $organization = Organization::findorfail($id);
      $organization->update($request->all());
      return redirect('organization/'.$id);
    }

    public function logout(){

        Auth::guard('organization')->logout();
        Auth::guard('user')->logout();
        return redirect('/');
    }

    /**
     * recommend to view the recommendation form
     */

    public function recommend($id)
    {

        return view('organization.recommendation' , compact('id'));
    }


    /**
     * to store the sent recommendation and insert it to the database
     */
    public function storeRecommendation(RecommendationRequest $request , $id)
    {
        $user_id = Auth::user()->id;
        $recommendation = new Recommendation;
        $recommendation->user_id = $user_id;
        $recommendation->organization_id = $id;
        $recommendation->recommendation = $request->recommendation;
        $recommendation->save();
        return redirect('organizations/'.$id);
    }



}
