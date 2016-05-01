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
          'store', 'update', 'report'
      ]]);
  }

  public function store(EventReviewRequest $request, $id)
  {
      $this->eventReviewService->store($request,$id);
      return response('Success.', 200);
  }


  public function report($event_id, $review_id)
  {
      $this->eventReviewService->report($event_id,$review_id);
      return response('Success.', 200);
  }
}
