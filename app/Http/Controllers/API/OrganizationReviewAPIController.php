<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\OrganizationReviewRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Services\OrganizationReviewService;

class OrganizationReviewAPIController extends Controller
{
  private $organizationReviewService;

  /**
   * Constructor.
   * Sets middlewares for controller functions and initializes an organization review service.
   */
  public function __construct()
  {
      $this->organizationReviewService = new OrganizationReviewService();
      $this->middleware('auth_volunteer', ['only' => [
          'store', 'report'
      ]]);
  }

  /**
   * Create an organization review and store it in the database.
   * @param  int  $id organization id
   */
  public function store(OrganizationReviewRequest $request, $id)
  {
      $this->organizationReviewService->store($request, $id);
      return response()->json(['message' => 'Success.'], 200);
  }

  /**
   * Report organization review to admin.
   */
  public function report(Request $request, $organization_id, $review_id)
  {
      $this->organizationReviewService->report($organization_id, $review_id, $request->get('volunteer'));
      return response()->json(['message' => 'Success.'], 200);
  }

}
