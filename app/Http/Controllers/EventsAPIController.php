<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;

class EventsAPIController extends Controller
{

    /**
     *  get json list of all organizations
     */
    public function index()
    {
        $events = Event::all();
        return $events;
    }


    /**
     *  show a json of an organization and all its events, reviews and subscribers
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        $event->posts = $event->posts()->get();
        $event->reviews = $event->reviews()->get();
        $event->questions = $event->questions()->get();
        return $event;
    }

}
