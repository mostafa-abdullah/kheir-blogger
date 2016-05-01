<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Services\OrganizationReviewService;

class OrganizationReviewAPIController extends Controller
{
  private $organizationReviewService;

  public function __construct()
  {
      $this->organizationReviewService = new OrganizationReviewService();
      $this->middleware('auth_volunteer', ['only' => [
          'store', 'update', 'report'
      ]]);
  }

  public function store(OrganizationReviewRequest $request, $id)
  {
      $this->organizationReviewService->store($request,$id);
      return response('Success.', 200);
  }

  public function report($organization_id, $review_id)
  {
      $this->organizationReviewService->report($organization_id,$review_id);
      return response('Success.', 200);
  }

}
