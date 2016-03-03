<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;

class EventController extends Controller
{
    /**
     * show method to show an event 
     * @param $id : the id of a certain event
     * @return A view to show a certain event
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.event', compact('event'));
    }

}
