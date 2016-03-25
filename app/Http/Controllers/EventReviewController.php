<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventReviewRequest;

use App\EventReview;
use App\Event;

use Auth;


class EventReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_volunteer', ['only' => [
            'create', 'store', 'edit', 'update'
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
    public function show($id)
    {
        //TODO
    }

    /**
     * Create a new event review
     */
    public function create($id)
    {
        $event = Event::findorfail($id);
        return view ('event.review.create',compact('event'));
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
          return redirect()->action('EventController@show', [$id]);
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
    public function destroy()
    {
        //TODO
    }
}
