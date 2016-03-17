<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Event;

class EventController extends Controller
{
    //
	public function create()
	{
		return view('events.create');
	}
	public function store(Requests\CreateEventRequest $request)
	{
		
		Event::createEvent($request);
		
		//return redirect('/');
	}
}
