<?php

namespace App\Http\Controllers\Organization;

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
    * State->auth
    * 	0 => Guest
    * 	1 => Auth is organization
    * 	2 => Auth is volunteer and subscribed to this organization
    * 	3 => Auth is volunteer and not subscribed to this organization
    */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        $state = 0;
        $blocked = 0;
        if(auth()->guard('organization')->check())
            $state = 1;
        else if (Auth::user())
        {
            $blocked = Auth::user()->blockedOrganizations()->find($id);
            if(Auth::user()->subscribedOrganizations()->find($id))
                $state = 2;
            else
                $state = 3;
        }
        $events=$organization->events();
        return view('organization.show',compact('organization','state','events', 'blocked'));
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
        return redirect()->action('Organization\OrganizationController@show', [$id]);
    }

    /**
     * A volunteer can subscribe for an organization.
     */
    public function subscribe($id)
    {
        Auth::user()->subscribe($id);
        return redirect()->action('Organization\OrganizationController@show', [$id]);
    }

    /**
     * A volunteer can unsubscribe from an organization.
     */
    public function unsubscribe($id)
    {
        Auth::user()->unsubscribe($id);
        return redirect()->action('Organization\OrganizationController@show', [$id]);
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
        return redirect()->action('Organization\OrganizationController@show', [$id]);
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
    public function block($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        $organization->blockingVolunteers()->attach(Auth::user());
        return redirect('/');
    }

    /**
     * A volunteer can unblock an organization.
     */
    public function unblock($organization_id)
    {
        $organization = Organization::find($organization_id);
        $organization->blockingVolunteers()->detach(Auth::user());
        return redirect('/');
    }
}
