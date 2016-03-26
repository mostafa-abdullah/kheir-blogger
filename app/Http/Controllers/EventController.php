<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventReview;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Requests\PostRequest;


use Carbon\Carbon;

use App\Organization;
use App\Question;
use App\Notification;
use App\Post;

use Auth;

class EventController extends Controller
{

	public function __construct()
	{
        $this->middleware('auth_volunteer', ['only' => [
			'follow', 'unfollow', 'register', 'unregister',
			'askQuestion', 'storeQuestion',

        ]]);

        $this->middleware('auth_organization', ['only' => [
            'create', 'store', 'edit', 'update', 'destroy',
			'answerQuestion', 'viewUnansweredQuestions',
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
		// TODO: show the event's page (Hossam Ahmad)

        // $event = Event::findOrFail($id);
        // $announcement = $event->posts()->get();
        // $questions = $event->questions()->answered()->get();
        // $reviews = $event->reviews()->get();
        // return view('event.event', compact('event', 'announcement', 'questions', 'reviews'));
		$event = Event::findOrFail($id);
		$creator = null;
		if(Auth::guard('organization')->id() == $event->organization_id)
			$creator = true;
		return view('event.show', compact('event', 'creator'));
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
		$notification_description = $organization->name." created a new event ".$request->name;
		Notification::notify($organization->subscribers()->get(), $event,
							$notification_description, url("/event", $event->id));
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
			Notification::notify($event->volunteers()->get(), $event,
								"Event ".($event->name)." has been updated", url("/event",$id));
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
			Notification::notify($event->volunteers(), null,
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
		Auth::user()->registerEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

	public function unregister($id)
	{
		Auth::user()->unregisterEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}
}
