<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Services\OrganizationService ;

use Illuminate\Http\Request;
use App\Http\Requests\RecommendationRequest;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\ReviewRequest;

use App\Organization;
use App\Recommendation;
use App\OrganizationReview;

use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;

use Hash;
use Auth;

class OrganizationController extends Controller
{

    private $organizationService;

    /**
     * Constructor.
     * Sets middlewares for controller functions and initializes organization service.
     */
    public function __construct()
    {
        $this->organizationService = new OrganizationService();

        $this->middleware('auth_volunteer', ['only' => [
            'subscribe', 'unsubscribe', 'block', 'unblock',
            'recommend', 'storeRecommendation'
        ]]);

        $this->middleware('auth_organization', ['only' => [
            'edit', 'update', 'viewRecommendations'
        ]]);

        $this->middleware('auth_admin', ['only' => [
            'destroy',
        ]]);
    }

    /**
    * Show organization profile.
    * State->auth
    * 	0 => Guest
    * 	1 => Auth is organization
    * 	2 => Auth is volunteer and subscribed to this organization
    * 	3 => Auth is volunteer and not subscribed to this organization
    * 	@param int $id organization id
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

        $canReview = Auth::user() && Auth::user()->role > 0
                  && !Auth::user()->organizationReviews()->find($organization->id);

        return view('organization.show',compact('organization', 'state', 'blocked', 'canReview'));
    }

    /**
    * Edit organization profile.
    * @param int $id organization id
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
    * @param int $id organization id
    */
    public function update(OrganizationRequest $request, $id)
    {
        $this->organizationService->update($request , $id);
        return redirect()->action('Organization\OrganizationController@show', [$id]);
    }

    /**
     * A volunteer can subscribe for an organization.
     * @param int $id organization id
     */
    public function subscribe($id)
    {
        $this->organizationService->subscribe($id, Auth::user());
        return redirect()->action('Organization\OrganizationController@show', [$id]);
    }

    /**
     * A volunteer can unsubscribe from an organization.
     * @param int $id organization id
     */
    public function unsubscribe($id)
    {
        $this->organizationService->unsubscribe($id, Auth::user());
        return redirect()->action('Organization\OrganizationController@show', [$id]);
    }

    /**
     * Recommendation Form.
     * @param int $id organization id.
     */
    public function recommend($id)
    {
        return view('organization.recommendation.create' , compact('id'));
    }

    /**
     * Store recommendation in the databse.
     * @param int $id organization id
     */
    public function storeRecommendation(RecommendationRequest $request , $id)
    {
        $this->organizationService->storeRecommendation($request, $id);
        return redirect()->action('Organization\OrganizationController@show', [$id]);
    }

    /**
     * An organization can view recommendations sent to it.
     * @param int $id organization id
     */
    public function viewRecommendations($id)
    {
        $recommendations = $this->organizationService->viewRecommendations($id);
        if($recommendations)
            return view('organization.recommendation.index', compact('recommendations'));
        return redirect('/');
    }

    /**
     * A volunteer can block an organization to stop receiving notifications.
     */
    public function block($organization_id)
    {
        $this->organizationService->block($organization_id, Auth::user());
        return redirect('/');
    }

    /**
     * A volunteer can unblock an organization.
     */
    public function unblock($organization_id)
    {
        $this->organizationService->unblock($organization_id, Auth::user());
        return redirect('/');
    }

    /**
     * Delete an organization
     * @param int $id organization id
     */
    public function destroy($id)
    {
        $this->organizationService->destroy($id);
        return redirect('/');
    }
}
