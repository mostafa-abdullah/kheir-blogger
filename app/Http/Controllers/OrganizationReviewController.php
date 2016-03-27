<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationReviewRequest;

use App\Organization;
use App\OrganizationReview;

use App\User;
use Auth;

class OrganizationReviewController extends Controller
{
    public function __construct()
    {
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
        return $organization->reviews;
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
        $review = new OrganizationReview($request->all());
        $review->user_id = Auth::user()->id;
        $organization = Organization::findorfail($id);
        $organization->reviews()->save($review);
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
        $review = Organization::findOrFail($organization_id)->reviews()->findOrFail($review_id);
        if(!$review->reportingUsers()->find(Auth::user()->id))
            Auth::user()->reportedOrganizationReviews()->attach($review);
        return redirect()->action('OrganizationController@show', [$organization_id]);
    }

    public function organizationReviews($organization_id){
        $reviews = OrganizationReview::where('organization_id' , $organization_id)->get();
        if($reviews != null){
            $organization_name = Organization::find($organization_id)->name;
            return view('organization\review\reviews')->with('reviews' , $reviews)
                ->with('organization_name' ,$organization_name);
        }
    }
}
