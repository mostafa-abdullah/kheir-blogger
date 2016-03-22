<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterOrganizationRequest;
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

    public function __construct(){
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
     * logout the logged-in organization
     */
    public function logout(){

        Auth::guard('organization')->logout();
        Auth::guard('user')->logout();
        return redirect('/');
    }

    /**
    * show the profile of organization.
    */
    public function show($id){

        //TODO: return a view with the organization profile (Badry)
        $organization = Organization::findOrFail($id);
        return $organization;
    }


    /**
    * edit the profile of organization.
    */
    public function edit($id){
        
      if(auth()->guard('organization')->id()==$id){
          $organization = Organization::findorfail($id);
          return view('organization.edit' , compact('organization'));
      }
      else{
        return redirect('home');
      }
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

    /**
     * returns a view to rate and review the organization
     */
    public function createReview($id){

        $organization = Organization::findorfail($id);
        return view ('organization.review', compact('organization'));
    }

    /**
     * store the organization review and insert it to the database
     */
    public function storeReview(ReviewRequest $request, $id){

        $review = new OrganizationReview($request->all());
        $review->user_id = Auth::user()->id;
        $organization = Organization::findorfail($id);
        $organization->reviews()->save($review);
        return redirect()->action('OrganizationController@show', [$id]);
    }

   public function viewRecommendations($id)
    {
        if(auth()->guard('organization')->id == $id){
            $organization = Organization::findorfail($id);
            $recommendations = $organization->recommendations();
            return view("organization.recommendation", compact('recommendations'));
        }
        return redirect('/');
    }
}
