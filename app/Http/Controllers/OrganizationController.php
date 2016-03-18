<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Organization;
use Hash;
use Auth;
use App\Recommendation;
use App\Http\Requests\RecommendationRequest;

class OrganizationController extends Controller
{
    public function register(Requests\RegisterOrganizationRequest $request){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        $organization = new Organization;
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->password = bcrypt($request->password);
        $organization->save();
        auth()->guard('organization')->login($organization);
        return redirect('/home');
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
      return "The profile";

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
        return redirect('organization/'.$id);
    }



}
