<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use App\Http\Requests\EventReviewRequest;

use App\EventReview;
use App\Event;

use Auth;


class EventReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_volunteer', ['only' => [
            'create', 'store', 'edit', 'update', 'report'
        ]]);
    }

    /**
     * Show all reviews of a certain event
     */
    public function index($event_id)
    {
        $event = Event::findOrFail($event_id);
        return $event->reviews;
    }

    /**
     * Show a certain event review
     */
    public function show($event_id, $review_id)
    {
        return Event::findOrFail($event_id)->reviews()->find($review_id);
    }

    /**
     * Create a new event review
     */
    public function create($id)
    {
        $event = Event::findorfail($id);
        if(!$event->attendees()->find(Auth::user()->id))
            return redirect()->action('Event\EventController@show', [$id]);
        if($event->reviews()->where('user_id', Auth::user()->id))
            return redirect()->action('Event\EventController@show', [$id]);
        return view ('event.review.create', compact('event'));
    }

    /**
     * Store the created event review
     */
    public function store(EventReviewRequest $request, $id)
    {
          $review = new EventReview($request->all());
          $review->user_id = Auth::user()->id;
          $event = Event::findorfail($id);
          $event->reviews()->save($review);
          return redirect()->action('Event\EventController@show', [$id]);
    }

    /**
     * Edit an event review
     */
    public function edit()
    {
        //TODO
    }

    /**
     * Update the edited event review
     */
    public function update()
    {
        //TODO
    }

    /**
     * Delete an event review
     */
    public function destroy($event_id, $review_id)
    {
        //TODO
    }

    public function report($event_id, $review_id)
    {
        $review = Event::findOrFail($event_id)->reviews()->findOrFail($review_id);
        if(!$review->reportingUsers()->find(Auth::user()->id))
            Auth::user()->reportedEventReviews()->attach($review);
        return redirect()->action('Event\EventController@show', [$event_id]);
    }
}
