<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecommendationRequest;
use App\Http\Services\OrganizationService;
use App\Organization;
use Illuminate\Http\Request;

use App\Http\Requests\OrganizationRequest;


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
     *  show a json of an organization and all its events, reviews and subscribers
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->events = $organization->events()->get();
        $organization->reviews = $organization->reviews()->get();
        $organization->subscribers = $organization->subscribers()->get();
        return response()->json($organization);
    }

    /**
     *  update organization information
     */
    public function update(OrganizationRequest $request , $id)
    {
        $this->organizationService->update($request , $id);
    }

    /**
     *  volunteer subscribe to a certain organization
     */
    public function subscribe($id)
    {
        $this->organizationService->subscribe($id);
    }

    /**
     *  volunteer unsubscribe to a certain organization
     */
    public function unsubscribe($id)
    {
        $this->organizationService->unsubscribe($id);
    }

    /**
     * volunteer block an organization
     */
    public function block($organization_id)
    {
        $this->organizationService->block($organization_id);
    }

    /**
     * volunteer unblock an organization
     */
    public function unblock($organization_id)
    {
        $this->organizationService->unblock($organization_id);
    }

    /**
     *  store a recommendation into the database
     */
    public function storeRecommendation(RecommendationRequest $request, $id)
    {
        $this->organizationService->storeRecommendation($request, $id);
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
