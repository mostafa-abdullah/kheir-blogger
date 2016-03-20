<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\EventRequest;

use App\Event;
use App\Organization;

class EventController extends Controller
{
	public function __construct(){

        $this->middleware('auth_volunteer', ['only' => [
            // Add all functions that are allowed for volunteers only

        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
            'create', 'store'
        ]]);

        $this->middleware('auth_both', ['only' => [
            // Add all functions that are allowed for volunteers/organizations only

        ]]);
    }

	/**
	 * show the event's page
	 */
	public function show($id){
		// TODO: show the event's page (Hossam Ahmad)
		return Event::find($id);
	}

	/**
	 * returns a form to create a new event
	 */
	public function create(){

		return view('event.create');
	}

	/**
	 * store the created event in the database
	 */
	public function store(EventRequest $request){

		$organization = auth()->guard('organization')->user();
		$event_id = $organization->createEvent($request);
		//TODO: notify subscribers and nearby volunteers (Esraa)
		return redirect()->action('EventController@show', [$event_id]);
	}

	public function follow($id){

		// TODO: a volunteer can follow an unfollowed event (Hatem)
		//
		return redirect()->action('EventController@show', [$id]);
	}

	public function unfollow($id){

		// TODO: a volunteer can unfollow an already followed event (Hatem)
		//
		return redirect()->action('EventController@show', [$id]);
	}

	public function register($id){

		// TODO: a volunteer can regiseter for an event only once (Hatem)
		//
		return redirect()->action('EventController@show', [$id]);
	}

	public function unregister($id){

		// TODO: a volunteer can unregiser from an already registered event (Hatem)
		// 
		return redirect()->action('EventController@show', [$id]);
	}
}
