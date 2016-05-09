<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\RecommendationRequest;
use App\Http\Services\OrganizationService;
use App\Organization;
use Illuminate\Http\Request;


class OrganizationAPIController extends Controller
{

    private $organizationService;

    public function __construct()
    {
        $this->organizationService = new OrganizationService();

        $this->middleware('auth_volunteer', ['only' => [
            'subscribe', 'unsubscribe',
            'recommend', 'storeRecommendation',
            'block', 'unblock'
        ]]);

        $this->middleware('auth_organization', ['only' => [
            'edit', 'update', 'viewRecommendations'
        ]]);

        $this->middleware('auth_admin', ['only' => [
            'destroy',
        ]]);
    }

    /**
     *  get json list of all organizations
     */
    public function index()
    {
        $organizations = Organization::all();
        return response()->json($organizations);
    }


    /**
     *  show a json of an organization and all its events, reviews count and subscribers
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->events = $organization->events()->get();
        $organization->reviews = count($organization->reviews()->with('user')->get());
        $organization->subscribers = $organization->subscribers()->get();
        $organization->rating = round($organization->rating , 1);
        return response()->json($organization);
    }

    /**
     * show a json of all reviews of an ORganization
     */
    public function reviews($id){
        $organization = Organization::findOrFail($id);
        $reviews = $organization->reviews()->with('user')->get();
        return response()->json($reviews);
    }

    /**
     *  update organization information
     */
    public function update(OrganizationRequest $request , $id)
    {
        $this->organizationService->update($request , $id);
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     *  volunteer subscribe to a certain organization
     */
    public function subscribe(Request $request, $id)
    {
        $this->organizationService->subscribe($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     *  volunteer unsubscribe to a certain organization
     */
    public function unsubscribe(Request $request, $id)
    {
        $this->organizationService->unsubscribe($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * volunteer block an organization
     */
    public function block(Request $request, $organization_id)
    {
        $this->organizationService->block($organization_id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * volunteer unblock an organization
     */
    public function unblock(Request $request, $organization_id)
    {
        $this->organizationService->unblock($organization_id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     *  store a recommendation into the database
     */
    public function storeRecommendation(RecommendationRequest $request, $id)
    {
        $this->organizationService->storeRecommendation($request, $id);
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     *  view all recommendations sent to the organization
     */
    public function viewRecommendations($id)
    {
        $recommendations = $this->organizationService->viewRecommendations($id);
        return response()->json($recommendations);
    }


}
