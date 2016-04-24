<?php

namespace App\Http\Services;


use Illuminate\Http\Request;
use App\Http\Requests\EventReviewRequest;
use App\Http\Requests\EventRequest;

use App\User;
use App\Event;
use App\Notification;

use Carbon\Carbon;
use Auth;
use Validator;

class EventService
{

	/**
	 * Store the created event in the database.
	 */
	public function store(EventRequest $request)
	{
		$organization = auth()->guard('organization')->user();
		$event = $organization->createEvent($request);
		$notification_description = $organization->name." created a new event: ".$request->name;
		Notification::notify($organization->subscribers, 1, $event,
							$notification_description, "/event", $event->id);
		return $event;
	}

	/**
	 * Update the information of an edited event.
	 */
	public function update(EventRequest $request, $id)
	{
		$event = Event::findorfail($id);
		if(auth()->guard('organization')->user()->id == $event->organization()->id)
		{
			$event = Event::findOrFail($id);
			$event->update($request->all());
			Notification::notify($event->volunteers, 2, $event,
								"Event ".($event->name)." has been updated", url("/event",$id));
		}
	}

	/**
	 * Cancel an event.
	 */
	public function destroy($id)
	{
		$event = Event::findOrFail($id);
		if(auth()->guard('organization')->user()->id == $event->organization()->id)
		{
			$event->delete();
			Notification::notify($event->volunteers, 3, null,
								"Event ".($event->name)."has been cancelled", url("/"));
		}
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
}
