<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\OrganizationReviewRequest;
use App\Http\Services\OrganizationReviewService;
use Illuminate\Http\Request;

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

  public function index($id)
  {
    $organization = Organization::findOrFail($id);
    $reviews = $organization->reviews()->with('user')->get();
    return response()->json($reviews);
  }

  public function store(OrganizationReviewRequest $request, $id)
  {
      $this->organizationReviewService->store($request, $id);
      return response()->json(['message' => 'Success.'], 200);
  }

  public function report(Request $request, $organization_id, $review_id)
  {
      $this->organizationReviewService->report($organization_id,$review_id, $request->get('volunteer'));
      return response()->json(['message' => 'Success.'], 200);
  }

}
