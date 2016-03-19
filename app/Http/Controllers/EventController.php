<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Event;

use App\Organization;

class EventController extends Controller
{
	public function create()
	{
		if ( !auth()->guard('organization')->user() )
			die();
		return view('event.create');
	}
	public function store(Requests\EventRequest $request)
	{
		if ( !auth()->guard('organization')->user() )
			die();
		$organization = auth()->guard('organization')->user();
		$event_id = $organization->createEvent($request);


		//notifications
		
		return redirect('/event/'.$event_id);
	}
}
