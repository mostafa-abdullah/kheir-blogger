<?php

namespace App\Http\Services;


use Illuminate\Http\Request;
use App\Http\Requests\EventReviewRequest;

use App\User;
use App\Event;
use App\Challenge;
use App\Feedback;

use Carbon\Carbon;
use Auth;
use Validator;

class EventService
{
    /**
    * Update volunteer profile.
    */
    public function update(VolunteerRequest $request, $id)
    {
    	 $volunteer = User::findorfail($id);
        $volunteer->update($request->all());
    }

    /**
     * Send feedback to the admin.
     */
    public function storeFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|max:60',
            'message' => 'required',
        ]);
        $feedback = new Feedback($request->all());
        $feedback->user_id = Auth::user()->id;
        $feedback->save();
    }

  /*
  |==========================================================================
  | Volunteers' Interaction with Event
  |==========================================================================
  |
  */
    public function follow($id)
    {
      Auth::user()->followEvent($id);
    }

    public function unfollow($id)
    {
      Auth::user()->unfollowEvent($id);
    }

    public function register($id)
    {
      $event = Event::findOrFail($id);
      if($event->timing > carbon::now())
        Auth::user()->registerEvent($id);
    }

    public function unregister($id)
    {
      Auth::user()->unregisterEvent($id);
    }

    public function attend($id)
    {
      $event = Event::findOrFail($id);
      if($event->timing < carbon::now())
        Auth::user()->attendEvent($id);
    }

    public function unattend($id)
    {
      $event = Event::findOrFail($id);
  		if($event->timing < carbon::now())
  			Auth::user()->unattendEvent($id);
    }


    /*
    |==========================================================================
    | Event Review
    |==========================================================================
    |
    */

    /*
    * Report event review.
    */
    public function report($event_id, $review_id)
    {
      $review = Event::findOrFail($event_id)->reviews()->findOrFail($review_id);
      if(!$review->reportingUsers()->find(Auth::user()->id))
          Auth::user()->reportedEventReviews()->attach($review);
    }

    /*
    * Event Review.
    */
    public function store(EventReviewRequest $request, $id)
    {
          $review = new EventReview($request->all());
          $review->user_id = Auth::user()->id;
          $event = Event::findorfail($id);
          $event->reviews()->save($review);
    }
}
