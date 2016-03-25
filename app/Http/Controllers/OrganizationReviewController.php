<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\OrganizationReview;

class OrganizationReviewController extends Controller
{
    /**
     * Show all reviews of a certain organization
     */
    public function index($id)
    {
        return OrganizationReview::all()->where('organization_id', '=', $id)->toArray();
    }

    /**
     * Show a certain organization review
     */
    public function show($id)
    {
        //TODO
    }

    /**
     * Create a new organization review
     */
    public function create($id)
    {
        $organization = Organization::findorfail($id);
        return view ('organization.review', compact('organization'));
    }

    /**
     * Store the created organization review
     */
    public function store(ReviewRequest $request, $id)
    {
        $review = new OrganizationReview($request->all());
        $review->user_id = Auth::user()->id;
        $organization = Organization::findorfail($id);
        $organization->reviews()->save($review);
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * Edit an organization review
     */
    public function edit()
    {
        //TODO
    }

    /**
     * Update the edited organization review
     */
    public function update()
    {
        //TODO
    }

    /**
     * Delete an organization review
     */
    public function destroy()
    {
        //TODO
    }
}
