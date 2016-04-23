<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests\OrganizationReviewRequest;

use App\Organization;
use App\OrganizationReview;

use Auth;

class OrganizationReviewService
{
  /**
   * Store the created organization review.
   */
  public function store(OrganizationReviewRequest $request, $id)
  {
      $review = new OrganizationReview($request->all());
      $review->user_id = Auth::user()->id;
      $organization = Organization::findorfail($id);
      $organization->reviews()->save($review);
  }

  public function report($organization_id, $review_id)
  {
      $review = Organization::findOrFail($organization_id)->reviews()->findOrFail($review_id);
      if(!$review->reportingUsers()->find(Auth::user()->id))
          Auth::user()->reportedOrganizationReviews()->attach($review);
  }
}
