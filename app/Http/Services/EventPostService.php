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
        $organization_id = $request->get('organization')->id;
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

    /**
	 * Update the information of an edited event post.
	 */
	public function update(EventPostRequest $request, $id, $post_id)
	{
		$event = Event::findorfail($id);
		if($request->get('organization')->id == $event->organization()->id)
		{
			$post = EventPost::findOrFail($post_id);
			$post->update($request->all());
		}
	}
}
