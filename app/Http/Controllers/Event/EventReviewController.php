<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\EventReviewRequest;
use App\Http\Services\EventReviewService;

use App\EventReview;
use App\Event;
use App\Notification;
use Auth;


class EventReviewController extends Controller
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
            'create', 'store', 'edit', 'update', 'report'
        ]]);

        $this->middleware('auth_validator', ['only' => 'destroy']);
    }

    /**
     * Show all reviews of a certain event.
     */
    public function index($event_id)
    {
        $event = Event::findOrFail($event_id);
        return $event->reviews;
    }

    /**
     * Show a certain event review.
     */
    public function show($event_id, $review_id)
    {
        return Event::findOrFail($event_id)->reviews()->find($review_id);
    }

    /**
     * Create a new event review.
     * @param int $id event id
     */
    public function create($id)
    {
        $event = Event::findorfail($id);
        if(!$event->attendees()->find(Auth::user()->id))
            return redirect()->action('Event\EventController@show', [$id]);
        if($event->reviews()->where('user_id', Auth::user()->id)->first())
            return redirect()->action('Event\EventController@show', [$id]);
        return view ('event.review.create', compact('event'));
    }

    /**
     * Store the created event review.
     * @param int $id event id
     */
    public function store(EventReviewRequest $request, $id)
    {
          $this->eventReviewService->store($request,$id);
          return redirect()->action('Event\EventController@show', [$id]);
    }

    /**
     * Edit an event review.
     */
    public function edit($event_id, $review_id)
    {
        $event_review = Auth::user()->eventReviews()->find($review_id);
        $event_name = Event::find($event_id)->name;
        if($event_review)
            return view('event.review.edit', compact('event_name', 'event_review'));
        return redirect('/');
    }

    /**
     * Update the edited event review.
     */
    public function update(Request $request, $event_id, $review_id)
    {
        if(Auth::user()->eventReviews()->find($review_id))
        {
             $validator = $this->eventReviewService->update($request,$review_id);
             if($validator->fails())
                return redirect()->action('Event\EventReviewController@edit',
                        [$event_id, $review_id])->withErrors($validator)->withInput();
        }
        return redirect()->action('Event\EventController@show', [$event_id]);
    }

    /**
     * Delete an event review.
     */
    public function destroy($event_id, $review_id)
    {
        $event = Event::findOrFail($event_id);
        $review = $event->reviews()->findOrFail($review_id);
        $volunteer = $review->user()->get();
        $review->delete();
        Notification::notify($volunteer, 7, null,
                 "your review on event: ". $event->name." has been deleted",
                 "/event/".$event_id);
       return redirect()->action('Event\EventController@show', [$event_id]);
    }

    /**
     * Report event review to the admin.
     */
    public function report($event_id, $review_id)
    {
        $this->eventReviewService->report($event_id,$review_id, Auth::user());
        return redirect()->action('Event\EventController@show', [$event_id]);
    }


}
