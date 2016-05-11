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

  /**
   * Constructor.
   * Sets middlewares for controller functions and initializes event review service.
   */
  public function __construct()
  {
      $this->eventReviewService = new EventReviewService();
      $this->middleware('auth_volunteer', ['only' => [
          'store', 'report'
      ]]);
  }

  /**
   * Create a new event review and store it in the database.
   * @param int $id event id
   */
  public function store(EventReviewRequest $request, $id)
  {
      $this->eventReviewService->store($request,$id);
      return response()->json(['message' => 'Success.'], 200);
  }

  /**
   * Report event review to admin
   */
  public function report(Request $request, $event_id, $review_id)
  {
      $this->eventReviewService->report($event_id,$review_id, $request->get('volunteer'));
      return response()->json(['message' => 'Success.'], 200);
  }
}
