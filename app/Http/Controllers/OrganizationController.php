<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RecommendationRequest;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\ReviewRequest;

use App\Http\Controllers\Controller;
use App\Organization;
use App\Recommendation;
use App\OrganizationReview;

use Hash;
use Auth;


class OrganizationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth_volunteer', ['only' => [
            // Add all functions that are allowed for volunteers only
            'recommend', 'storeRecommendation',
            'createReview', 'storeReview',
        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
            'edit', 'update', 'viewRecommendations'
        ]]);

        $this->middleware('auth_both', ['only' => [
            // Add all functions that are allowed for volunteers/organizations only

        ]]);
    }

    /**
    * show the profile of organization.
    */
    public function show($id){
        $organization = Organization::findOrFail($id);
        $state=0;
          if (auth()->guard('organization')->check())$state=1;
         else if (Auth::user()){
             if (Auth::user()->is_subscribed($id))$state=2;
             else $state=3;
         }
        $events=$organization->events();
        return view('organization.profile',compact('organization','state','events'));
    }


    /**
    * edit the profile of organization.
    */
    public function edit($id)
    {
        if(auth()->guard('organization')->id()==$id)
        {
            $organization = Organization::findorfail($id);
            return view('organization.edit' , compact('organization'));
        }
        return redirect('/');
    }

    /**
    * update the profile of organization.
    */
    public function update(OrganizationRequest $request, $id){

        $organization = Organization::findorfail($id);
        $organization->update($request->all());
        return redirect()->action('OrganizationController@show', [$organization->id]);
    }

    /**
     * returns a form to send a recommendation to the organization
     * with the specified id
     */
    public function recommend($id){

        return view('organization.recommend' , compact('id'));
    }

    /**
     * store the sent recommendation and insert it to the database
     */
    public function storeRecommendation(RecommendationRequest $request , $id){

        $recommendation = new Recommendation($request->all());
        $recommendation->user_id = Auth::user()->id;
        $organization = Organization::findorfail($id);
        $organization->recommendations()->save($recommendation);
        return redirect()->action('OrganizationController@show', [$id]);
    }

   public function viewRecommendations($id)
    {
        if(auth()->guard('organization')->id == $id){
            $organization = Organization::findorfail($id);
            $recommendations = $organization->recommendations();
            return view("organization.recommendation", compact('recommendations'));
        }else
            return redirect('/');

    }
}
