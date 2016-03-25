<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class EventPostController extends Controller
{
    
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);
        $organization_id = auth()->guard('organization')->user()->id;
        if($event->organization()->id == $organization_id)
            return view('event.post.create')->with('event_id', $event_id);
        return redirect()->action('EventController@show', [$event_id]);
    }

    /*
    * Add a new Post to the Event and Notify Users.
    *
    */
    public function store(PostRequest $request, $event_id)
    {
        $organization_id = auth()->guard('organization')->user()->id;
        $eventPost = new Post($request->all());
        $eventPost->event_id = $event_id;
        $eventPost->organization_id = $organization_id;
        $eventPost->save();
        if($request->sendnotifications == 1)
        {
            $event = Event::find($event_id);
            Notification::notify($event->registrants(), $event, "Event ".($event->name)." has new posts",url("/event",$id));
            Notification::notify($event->followers(), $event, "Event ".($event->name)." has new posts",url("/event",$id));
        }
        return redirect()->action('EventController@show', [$event_id]);
    }
}
