<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Services\OrganizationService;

class OrganizationReviewAPIController extends Controller
{
  private $organizationService;
  public function __construct()
  {
      $this->organizationService = new OrganizationService();
      $this->middleware('auth_volunteer', ['only' => [
          'create', 'store', 'edit', 'update', 'report'
      ]]);
  }

  public function store(OrganizationReviewRequest $request, $id)
  {
      $this->organizationService->store($request,$id);
  }

  public function report($organization_id, $review_id)
  {
      $this->organizationService->report($organization_id,$review_id);
  }

}
