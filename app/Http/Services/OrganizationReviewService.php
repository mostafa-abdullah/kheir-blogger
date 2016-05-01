<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests\OrganizationReviewRequest;

use App\Organization;
use App\OrganizationReview;

use Auth;
use Validator;

class OrganizationReviewService
{
  /**
   * Store the created organization review.
   */
  public function store(OrganizationReviewRequest $request, $id)
  {
      $review = new OrganizationReview($request->all());
      $review->user_id = $request->get('volunteer')->id;
      $organization = Organization::findorfail($id);
      $organization->reviews()->save($review);
  }

  /**
   * Update Organization Review.
   */
  public function update(Request $request, $id)
  {
      $validator = Validator::make($request->all(), [
          'rating'   => 'required|numeric|min:1|max:5',
          'review' => 'required'
      ]);

      if(!$validator->fails())
      {
          $organization_review = OrganizationReview::findorfail($id);
          $organization_review->update($request->all());
      }

      return $validator;
  }

  public function report($organization_id, $review_id)
  {
      $review = Organization::findOrFail($organization_id)->reviews()->findOrFail($review_id);
      if(!$review->reportingUsers()->find(Auth::user()->id))
          Auth::user()->reportedOrganizationReviews()->attach($review);
  }
}
