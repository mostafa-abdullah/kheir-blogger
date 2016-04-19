<?php

namespace App\Http\Controllers;

use App\EventReviewReport;
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
            return redirect()->action('EventController@show', [$id]);
        if($event->reviews()->where('user_id', Auth::user()->id))
            return redirect()->action('EventController@show', [$id]);
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
    public function destroy($event_id, $review_id)
    {
        //TODO
    }

    public function report($event_id, $review_id)
    {
        $review = Event::findOrFail($event_id)->reviews()->findOrFail($review_id);
        if(!$review->reportingUsers()->find(Auth::user()->id))
            Auth::user()->reportedEventReviews()->attach($review);
        return redirect()->action('EventController@show', [$event_id]);
    }

    /**
     * validator can view reports on events.
     */
    public function validatorViewReports (){
            /* check if the loogedd in user is a validator */
            if(Auth::user()->role == 5){
                /*get all Event review reports */
                $event_reviews_reports = EventReviewReport::all();
                /*for each report get its event and review to pass them to the view */
                foreach($event_reviews_reports as $event_reviews_report) {
                    $event_review = EventReview::findOrFail($event_reviews_report->review_id);
                    $event_id = $event_review->event_id;
                    $user_id = $event_review->user_id ;
                    $event_reviews_report->event_id = $event_id ;
                    $event_reviews_report->user_id = $user_id;
                }

                return view('volunteer.validator.eventReviewsReports',compact('event_reviews_reports'));

            }
    }
        /**
         * validator assign report to be viewed
         */
        public function reportViewed($id){
            /* if view button is clicked change the viewed attribute of the report to 1 which means it is viewed */
            $report = EventReviewReport::findOrFail($id);
            $report->viewed = 1 ;
            $report->save();
            return redirect()->action('EventReviewController@validatorViewReports');

        }



}
