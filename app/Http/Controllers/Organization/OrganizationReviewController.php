<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;

use App\Http\Requests\OrganizationReviewRequest;
use App\Http\Services\OrganizationService;

use App\Organization;
use App\OrganizationReview;

use Auth;

class OrganizationReviewController extends Controller
{
  private $organizationService;
    public function __construct()
    {
      $this->organizationService = new OrganizationService();
        $this->middleware('auth_volunteer', ['only' => [
            'create', 'store', 'edit', 'update', 'report'
        ]]);
    }

    /**
     * Show all reviews of a certain organization.
     */
    public function index($id)
    {
        $organization = Organization::findorfail($id);
        return view('organization.review.index', compact('organization'));
    }

    /**
     * Show a certain organization review.
     */
    public function show($organization_id, $review_id)
    {
        //TODO
    }

    /**
     * Create a new organization review.
     */
    public function create($id)
    {
        $organization = Organization::findorfail($id);
        return view ('organization.review.create', compact('organization'));
    }

    /**
     * Store the created organization review.
     */
    public function store(OrganizationReviewRequest $request, $id)
    {
        $this->organizationService->store($request,$id);
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * Edit an organization review.
     */
    public function edit($organization_id, $review_id)
    {
        //TODO
    }

    /**
     * Update the edited organization review
     */
    public function update($organization_id, $review_id)
    {
        //TODO
    }

    /**
     * Delete an organization review
     */
    public function destroy($organization_id, $review_id)
    {
        //TODO
    }

    public function report($organization_id, $review_id)
    {
        $this->organizationService->report($organization_id,$review_id);
        return redirect()->action('OrganizationController@show', [$organization_id]);
    }
}
