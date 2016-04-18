<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Services\EventReviewService;

use App\Photo;
use App\Event;

class EventReviewAPIController extends Controller
{
  private $eventReviewService;

  public function __construct()
  {
      $this->eventReviewService = new EventReviewService();
      $this->middleware('auth_volunteer', ['only' => [
          'create', 'store', 'edit', 'update', 'report'
      ]]);
  }

  public function report($event_id, $review_id)
  {
      $this->eventReviewService->report($event_id,$review_id);
  }

  public function store(EventReviewRequest $request, $id)
  {
      $this->eventReviewService->store($request,$id);
  }

}
