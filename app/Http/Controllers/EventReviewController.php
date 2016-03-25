<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventReview;
use App\Event;
use App\Http\Requests\EventReviewRequest;

use Auth;
use App\Http\Requests;

class EventReviewController extends Controller
{
    /**
     * Show all reviews of a certain event
     */
    public function index($event_id)
    {
        return EventReview::all()->where('event_id', '=', $id)->toArray();
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
        if(Auth::user()){
          $review = new EventReview($request->all());
          $review->user_id = Auth::user()->id;
          $event = Event::findorfail($id);
          $event->reviews()->save($review);

      }
        return redirect('events/'.$id);
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
