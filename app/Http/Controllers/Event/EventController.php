<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryCaptionRequest;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use App\Organization;
use App\Notification;
use App\Event;
use App\Photo;

use Carbon\Carbon;
use Auth;
use Input;
use Validator;
use Session;

class EventController extends Controller
{
	private $eventService;

	/**
	 * Constructor.
	 * Sets middlewares for controller functions and initializes event service.
	 */
	public function __construct()
	{
		$this->eventService = new EventService();
        $this->middleware('auth_volunteer', ['only' => [
			'follow', 'unfollow', 'register', 'unregister',
			'attend', 'unattend'
        ]]);

        $this->middleware('auth_organization', ['only' => [
            'create', 'store', 'edit', 'update', 'cancel'
        ]]);

	    $this->middleware('auth_admin', ['only' => ['destroy']]);
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
		$events = $organization->events()->latest()->get();
		return view('event.index', compact('organization', 'events'));
	}

	/**
	 * Show Event's page.
	 * @param int $id event id.
	 */
	public function show($id)
	{
    	$event = Event::findOrFail($id);
		$creator = null;
		if(Auth::guard('organization')->id() == $event->organization_id)
			$creator = true;
		$volunteerState = 0;
		if(Auth::user())
		{
			$record = Auth::user()->events()->find($id);
			if($record)
				$volunteerState = $record->pivot->type;
		}
		return view('event.show', compact('event', 'creator', 'volunteerState'));
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
		$event = $this->eventService->store($request);
		return redirect()->action('Event\EventController@show', [$event->id]);
	}

	/**
	 * Edit the information of a certain event.
	 * @param int $id event id.
	 */
	public function edit($id)
	{
		$event = Event::findOrFail($id);
		if(auth()->guard('organization')->user()->id == $event->organization()->id)
			return view('event.edit', compact('event'));
		return redirect()->action('Event\EventController@show', [$id]);
	}

	/**
	 * Update the information of an edited event.
	 * @param int $id event id.
	 */
	public function update(EventRequest $request, $id)
	{
		$this->eventService->update($request, $id);
		return redirect()->action('Event\EventController@show', [$id]);
	}

	/**
	 * Organization cancel an event
	 * @param int $id event id.
	 */
	public function cancel($id)
	{
		$this->eventService->cancel($id, auth()->guard('organization')->user());
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
		$this->eventService->follow($id, Auth::user());
		return redirect()->action('Event\EventController@show', [$id]);
	}

	public function unfollow($id)
	{
		$this->eventService->unfollow($id, Auth::user());
		return redirect()->action('Event\EventController@show', [$id]);
	}

	public function register($id)
	{
		$validator = $this->eventService->register($id, Auth::user());
		if($validator->passes() || !(Event::findorfail($id)->required_contact_info))
			return redirect()->action('Event\EventController@show', [$id]);
		return redirect()->action('Event\EventController@show', [$id])->withErrors($validator);
	}

	public function unregister($id)
	{
		$this->eventService->unregister($id, Auth::user());
		return redirect()->action('Event\EventController@show', [$id]);
	}

	public function attend($id)
	{
		$this->eventService->attend($id, Auth::user());
		return redirect()->action('Event\EventController@show',[$id]);
	}

	public function unattend($id)
	{
		$this->eventService->unattend($id, Auth::user());
		return redirect()->action('Event\EventController@show',[$id]);
	}
}
