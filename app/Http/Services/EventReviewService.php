<?php

namespace App\Http\Services;


use Illuminate\Http\Request;
use App\Http\Requests\EventReviewRequest;

use App\Event;
use App\EventReview;

use Carbon\Carbon;
use Auth;
use Validator;

class EventReviewService
{

    /*
    * Store Event Review.
    */
    public function store(EventReviewRequest $request, $id)
    {
          $review = new EventReview($request->all());
          $review->user_id = Auth::user()->id;
          $event = Event::findorfail($id);
          $event->reviews()->save($review);
    }

    /**
     * Update Event Review.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating'   => 'required|numeric|min:1|max:5',
            'review' => 'required'
        ]);

        if(!$validator->fails())
        {
            $event_review = EventReview::findorfail($id);
            $event_review->update($request->all());
        }

        return $validator;
    }

    /*
    * Report event review.
    */
    public function report($event_id, $review_id)
    {
      $review = Event::findOrFail($event_id)->reviews()->findOrFail($review_id);
      if(!$review->reportingUsers()->find(Auth::user()->id))
          Auth::user()->reportedEventReviews()->attach($review);
    }
}
