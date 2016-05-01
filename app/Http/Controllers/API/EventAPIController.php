<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\EventService;

use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;

use App\Event;

class EventAPIController extends Controller
{
  private $eventService;

  public function __construct()
  {
      $this->eventService = new EventService();
      $this->middleware('auth_volunteer', ['only' => [
        'follow', 'unfollow', 'register', 'unregister',
        'attend', 'unattend'
      ]]);

      $this->middleware('auth_organization', ['only' => [
    	   'store', 'update', 'destroy',
      ]]);
  }

/*
|==========================================================================
| Event CRUD Functions
|==========================================================================
|
*/
    /**
     *  get json list of all organizations
     */
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }


    /**
     *  show a json of an organization and all its events, reviews and subscribers
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        $event->posts = $event->posts()->get();
        $event->reviews = $event->reviews()->with('user')->get();
        $event->questions = $event->questions()->with('user')->get();
        $event->photos = $event->photos()->get();
        return response()->json($event);
    }

    /**
     * Store the created event in the database.
     */
    public function store(EventRequest $request)
    {
        $this->eventService->store($request);
        return response('Success.', 200);
    }

  	/**
  	 * Update the information of an edited event.
  	 */
  	public function update(EventRequest $request, $id)
  	{
  		  $this->eventService->update($request, $id);
        return response('Success.', 200);
  	}

  	/**
  	 * Cancel an event.
  	 */
  	public function destroy($id)
  	{
  		  $this->eventService->destroy($id);
        return response('Success.', 200);
  	}

/*
|==========================================================================
| Volunteers' Interaction with Event
|==========================================================================
|
*/
    public function follow($id)
    {
        $this->eventService->follow($id);
        return response('Success.', 200);
    }

    public function unfollow($id)
    {
        $this->eventService->unfollow($id);
        return response('Success.', 200);
    }

    public function register($id)
    {
        $this->eventService->register($id);
        return response('Success.', 200);
    }

    public function unregister($id)
    {
        $this->eventService->unregister($id);
        return response('Success.', 200);
    }

    public function attend($id)
    {
        $this->eventService->attend($id);
        return response('Success.', 200);
    }

    public function unattend($id)
    {
        $this->eventService->unattend($id);
        return response('Success.', 200);
    }
}
