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
            'update', 'viewRecommendations'
        ]]);
    }

    /**
     *  Get json list of all organizations.
     */
    public function index()
    {
        $organizations = Organization::all();
        return response()->json($organizations);
    }


    /**
     *  Show a json of an organization and all its events, reviews and subscribers.
     *  @param int $id organization id
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->events = $organization->events()->get();
        $organization->reviews = $organization->reviews()->with('user')->get();
        $organization->subscribers = $organization->subscribers()->get();
        return response()->json($organization);
    }

    /**
     *  Update organization information.
     *  @param int $id organization id
     */
    public function update(OrganizationRequest $request , $id)
    {
        $this->organizationService->update($request , $id);
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     *  Volunteer subscribe to a certain organization.
     *  @param int $id organization id
     */
    public function subscribe(Request $request, $id)
    {
        $this->organizationService->subscribe($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     *  Volunteer unsubscribe from a certain organization.
     *  @param int $id organization id
     */
    public function unsubscribe(Request $request, $id)
    {
        $this->organizationService->unsubscribe($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * Volunteer block an organization.
     */
    public function block(Request $request, $organization_id)
    {
        $this->organizationService->block($organization_id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * Volunteer unblock an organization.
     */
    public function unblock(Request $request, $organization_id)
    {
        $this->organizationService->unblock($organization_id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * Store a recommendation into the database.
     */
    public function storeRecommendation(RecommendationRequest $request, $id)
    {
        $this->organizationService->storeRecommendation($request, $id);
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * View all recommendations sent to the organization.
     *  @param int $id organization id
     */
    public function viewRecommendations($id)
    {
        $recommendations = $this->organizationService->viewRecommendations($id);
        return response()->json($recommendations);
    }


}
