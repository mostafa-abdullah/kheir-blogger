<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Event\EventController;
use App\Http\Services\EventPostService;

use App\Http\Requests\EventPostRequest;

use App\Event;
use App\EventPost;
use App\Notification;
use App\Organization;
use Auth;

class EventPostController extends Controller
{
    private $eventPostService;

    public function __construct()
    {
        $this->eventPostService = new EventPostService();
        $this->middleware('auth_organization', ['only' => [
            'create', 'store', 'edit', 'update'
        ]]);
    }

    /**
     * Show all posts of a certain event
     */
    public function index($id)
    {
        $event = Event::findOrFail($id);
        return $event->posts()->get();
    }

    /**
     * Show a certain event post
     */
    public function show($id)
    {
        //TODO
    }

    /**
     * Create a new event post
     */
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);
        if($event->organization()->id == auth()->guard('organization')->id())
            return view('event.post.create', compact('event_id'));
        return redirect()->action('EventController@show', [$event_id]);
    }

    /*
    * Add a new post to the event (and notify users).
    */
    public function store(EventPostRequest $request, $event_id)
    {
        $this->eventPostService->store($request, $event_id);
        return redirect()->action('Event\EventController@show', [$event_id]);
    }

    /**
     * Edit an event post
     */
    public function edit($id, $post_id)
    {
        $event = Event::findOrFail($id);
        $post = EventPost::findOrFail($post_id);

        if(auth()->guard('organization')->user()->id == $event->organization()->id)
            return view('event.post.edit', compact('post','event'));

        return redirect()->action('Event\EventController@show', [$id]);
    }

    /**
     * Update the edited event post
     */
    public function update(EventPostRequest $request, $id, $post_id)
   	{
   		$this->eventPostService->update($request, $id, $post_id);
   		return redirect()->action('Event\EventController@show', [$id]);
   	}

    /**
     * Delete an event post
     */
    public function destroy($id,$post_id)
    {
        $event = Event::findOrFail($id);
        $post  = EventPost::findOrFail($post_id);

		if((Auth::user() && Auth::user()->role >= 8) || auth()->guard('organization')->user()->id == $event->organization()->id)
		{
			$post->delete();
		}
        return redirect()->action('Event\EventController@show', [$id]);
    }
}
