<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Services\EventService;

use App\Photo;
use App\Event;

class EventReviewAPIController extends Controller
{
  private $eventService;
  public function __construct()
  {
      $this->eventService = new EventService();
      $this->middleware('auth_volunteer', ['only' => [
          'create', 'store', 'edit', 'update', 'report'
      ]]);
  }

  public function report($event_id, $review_id)
  {
    $this->eventService->report($event_id,$review_id);
  }

  public function store(EventReviewRequest $request, $id)
  {
    $this->eventService->store($request,$id);
  }

}
