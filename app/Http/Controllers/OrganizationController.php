<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\RecommendationRequest;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\ReviewRequest;

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
            'subscribe', 'unsubscribe',
            'recommend', 'storeRecommendation',
            'block', 'unblock'
        ]]);

        $this->middleware('auth_organization', ['only' => [
            'edit', 'update', 'viewRecommendations'
        ]]);
    }

    /**
    * Show organization profile.
    */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        $state = 0;
        if(auth()->guard('organization')->check())
            $state = 1;
        else if (Auth::user())
                if (Auth::user()->isSubscribed($id))
                    $state = 2;
                else
                    $state = 3;
        $events=$organization->events();
        return view('organization.show',compact('organization','state','events'));
    }

    /**
    * Edit organization profile.
    */
    public function edit($id)
    {
        if(auth()->guard('organization')->id() == $id)
        {
            $organization = Organization::findorfail($id);
            return view('organization.edit' , compact('organization'));
        }
        return redirect('/');
    }

    /**
    * Update organization profile.
    */
    public function update(OrganizationRequest $request, $id)
    {
        $organization = Organization::findorfail($id);
        $organization->update($request->all());
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * A volunteer can subscribe for an organization.
     */
    public function subscribe($id)
    {
        Auth::user()->subscribe($id);
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * A volunteer can unsubscribe from an organization.
     */
    public function unsubscribe($id)
    {
        Auth::user()->unsubscribe($id);
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * Recommendation Form.
     */
    public function recommend($id)
    {
        return view('organization.recommendation.create' , compact('id'));
    }

    /**
     * A volunteer can send a recommendation to an organization.
     */
    public function storeRecommendation(RecommendationRequest $request , $id)
    {

        $recommendation = new Recommendation($request->all());
        $recommendation->user_id = Auth::user()->id;
        $organization = Organization::findorfail($id);
        $organization->recommendations()->save($recommendation);
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * An organization can view recommendations sent to it.
     */
    public function viewRecommendations($id)
    {
        if(auth()->guard('organization')->id() == $id)
        {
            $organization = Organization::findorfail($id);
            $recommendations = $organization->recommendations()
                                            ->orderBy('created_at', 'desc')->get();
            return view('organization.recommendation.index', compact('recommendations'));
        }
        return redirect('/');
    }


    /**
     * A volunteer can block an organization to stop receiving notifications.
     */
    public function block($organization_id){
        $organization = Organization::find($organization_id);
        Auth::user()->blockOrganisation()->attach($organization);
    }


    /**
     * A volunteer can unblock an organization.
     */
    public function unblock($organization_id){
        $organization = Organization::find($organization_id);
        Auth::user()->blockOrganisation()->detach($organization);
    }
}
