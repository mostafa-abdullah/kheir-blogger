<?php


namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Services\EventReviewService;
use Illuminate\Http\Request;

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

  public function index($id)
  {
      $event = Event::findOrFail($id);
      $reviews = $event->reviews()->with('user')->get();
      return response()->json($reviews);
  }

  public function store(EventReviewRequest $request, $id)
  {
      $this->eventReviewService->store($request,$id);
      return response()->json(['message' => 'Success.'], 200);
  }


  public function report(Request $request, $event_id, $review_id)
  {
      $this->eventReviewService->report($event_id,$review_id, $request->get('volunteer'));
      return response()->json(['message' => 'Success.'], 200);
  }
}
