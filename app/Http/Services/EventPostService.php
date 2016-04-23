<?php

namespace App\Http\Services;

use App\Http\Requests\EventPostRequest;

use App\Event;
use App\EventPost;
use App\Notification;


class EventPostService
{
    /*
    * Add a new post to the event (and notify users).
    */
    public function store(EventPostRequest $request, $event_id)
    {
        $organization_id = auth()->guard('organization')->user()->id;
        $eventPost = new EventPost($request->all());
        $eventPost->event_id = $event_id;
        $eventPost->organization_id = $organization_id;
        $eventPost->save();
        if($request->sendnotifications == 1)
        {
            $event = Event::find($event_id);
            $description = "Event ".($event->name)." has a new post";
            $link = "/event".$event_id;
            Notification::notify($event->volunteers, 4, $event, $description, $link);
        }
    }
}
