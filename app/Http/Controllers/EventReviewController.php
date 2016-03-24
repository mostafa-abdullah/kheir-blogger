<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventReview;
use App\Event;

use Auth;
use App\Http\Requests;

class EventReviewController extends Controller
{
    //
    /**
    * Creat new review for event.
    *
    * @return view
    */

    public function create($id){
        $event = Event::findorfail($id);
        return view ('event.create_review',compact('event'));

    }
    /**
    * Find all Reviews on event.
    *
    * @return view
    */

    public function index($id){

    return  $event_review = EventReview::all()->where('event_id', '=', $id)->toArray();

    }


    /**
    * Store the evet review.
    *
    * @return view
    */

    public function store(ReviewRequest $request, $id){

        if(Auth::user()){
          $review = new EventReview($request->all());
          $review->user_id = Auth::user()->id;
          $event = Event::findorfail($id);
          $event->reviews()->save($review);

      }
        return redirect('events/'.$id);


    }



}
