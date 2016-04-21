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
}