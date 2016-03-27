<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;

use App\Organization;
use App\Notification;
use App\Event;

use Carbon\Carbon;
use Auth;

class EventController extends Controller
{

	public function __construct()
	{
        $this->middleware('auth_volunteer', ['only' => [
			'follow', 'unfollow', 'register', 'unregister',
			'confirm', 'unconfirm'
        ]]);

        $this->middleware('auth_organization', ['only' => [
            'create', 'store', 'edit', 'update', 'destroy',
        ]]);
    }

/*
|==========================================================================
| Event CRUD Functions
|==========================================================================
|
*/
	/**
	 * Show all events of a certain organization.
	 */
	public function index($organization_id)
	{
		$organization = Organization::findOrFail($organization_id);
		return $organization->events;
	}

	/**
	 * Show Event's page.
	 */
	public function show($id)
	{
        $event = Event::findOrFail($id);
        $posts = $event->posts;
        $questions = $event->questions()->answered()->get();
        $reviews = $event->reviews;
		$creator = null;
		if(Auth::guard('organization')->id() == $event->organization_id)
			$creator = true;
		return view('event.show',
			compact('event', 'posts', 'questions', 'reviews', 'creator'));
	}

	/**
	 * Create a new event.
	 */
	public function create()
	{
		return view('event.create');
	}

	/**
	 * Store the created event in the database.
	 */
	public function store(EventRequest $request)
	{
		$organization = auth()->guard('organization')->user();
		$event = $organization->createEvent($request);
		$description = $organization->name." created a new event ".$request->name;
		$link = url("/event", $event->id);
		Notification::notify($organization->subscribers, 1, $event, $description, $link);
		return redirect()->action('EventController@show', [$event->id]);
	}

	/**
	 * Edit the information of a certain event.
	 */
	public function edit($id)
	{
		$event = Event::findOrFail($id);
		if(auth()->guard('organization')->user()->id == $event->organization()->id)
			return view('event.edit', compact('event'));
		return redirect()->action('EventController@show', [$id]);
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
			$description = "Event ".($event->name)." has been updated";
			$link = url("/event",$id);
			Notification::notify($event->volunteers, 2, $event, $description, $link);
		}
		return redirect()->action('EventController@show', [$id]);
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
			Notification::notify($event->volunteers(), 3, null,
								"Event ".($event->name)."has been cancelled", url("/"));
		}
		return redirect('/');
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
		return redirect()->action('EventController@show', [$id]);
	}

	public function unfollow($id)
	{
		Auth::user()->unfollowEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

	public function register($id)
	{
		$event = Event::findOrFail($id);
		if($event->timing > carbon::now())
			Auth::user()->registerEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

	public function unregister($id)
	{
		Auth::user()->unregisterEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

	public function confirm($id)
	{
		$event = Event::findOrFail($id);
		if($event->timing < carbon::now())
			Auth::user()->attendEvent($id);
		return redirect()->action('EventController@show',[$id]);
	}

	public function unconfirm($id)
	{
		$event = Event::findOrFail($id);
		if($event->timing < carbon::now())
			Auth::user()->unattendEvent($id);
		return redirect()->action('EventController@show',[$id]);
	}
}
