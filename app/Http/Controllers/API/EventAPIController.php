<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use Illuminate\Http\Request;

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
        return response()->json(['message' => 'Success.'], 200);
    }

  	/**
  	 * Update the information of an edited event.
  	 */
  	public function update(EventRequest $request, $id)
  	{
  		  $this->eventService->update($request, $id);
        return response()->json(['message' => 'Success.'], 200);
  	}

  	/**
  	 * Cancel an event.
  	 */
  	public function destroy(Request $request, $id)
  	{
  		  $this->eventService->destroy($id, $request->get('organization'));
        return response()->json(['message' => 'Success.'], 200);
  	}

/*
|==========================================================================
| Volunteers' Interaction with Event
|==========================================================================
|
*/
    public function follow(Request $request, $id)
    {
        $this->eventService->follow($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    public function unfollow(Request $request, $id)
    {
        $this->eventService->unfollow($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    public function register(Request $request, $id)
    {
        $validator = $this->eventService->register($id, $request->get('volunteer'));
        if($validator->passes())
            return response()->json(['message' => 'Success.'], 200);
        return response()->json(['message' => 'Registration Failed.', 'errors' => $validator->errors()], 400);
    }

    public function unregister(Request $request, $id)
    {
        $this->eventService->unregister($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    public function attend(Request $request, $id)
    {
        $this->eventService->attend($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }

    public function unattend(Request $request, $id)
    {
        $this->eventService->unattend($id, $request->get('volunteer'));
        return response()->json(['message' => 'Success.'], 200);
    }
}
