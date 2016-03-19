<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event_Review;
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

        return view ('event.create_review',compact('id'));

    }
    /**
    * Find all Reviews on event.
    *
    * @return view
    */

    public function index($id){

    return  $event_review = Event_Review::all()->where('event_id', '=', $id)->toArray();

    }

    /**
    * Store the evet review.
    *
    * @return view
    */

    public function store( $id,Request $request){

        $user_id = Auth::user()->id;

        if($user_id){
        $this->validate($request,['rate'=>'required|numeric|min:1|max:5']);

        $review = new Event_Review;

        $review->event_id = $id;
        $review->user_id = $user_id;
        $review->review = $request->review;
        $review->rate = $request->rate;
        $review->save();

        return redirect('events/'.$id);
      }


    }



}
