<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Services\EventService;

use App\Photo;
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
        $event->photos = $event->photos()->get();
        return $event;
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
    }

    public function unfollow($id)
    {
        $this->eventService->unfollow($id);
    }

    public function register($id)
    {
        $this->eventService->register($id);
    }

    public function unregister($id)
    {
        $this->eventService->unregister($id);
    }

    public function attend($id)
    {
        $this->eventService->attend($id);
    }

    public function unattend($id)
    {
        $this->eventService->unattend($id);
    }
}
