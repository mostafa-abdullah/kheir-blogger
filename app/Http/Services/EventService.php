<?php

namespace App\Http\Services;


use Illuminate\Http\Request;
use App\Http\Requests\EventReviewRequest;
use App\Http\Requests\EventRequest;

use App\User;
use App\Event;
use App\Notification;

use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;

use Carbon\Carbon;
use Auth;

class EventService
{

	/**
	 * Store the created event in the database.
	 */
	public function store(EventRequest $request)
	{
		$organization = $request->get('organization');
		$event = $organization->createEvent($request);
		$notification_description = $organization->name." created a new event: ".$request->name;
		Notification::notify($organization->subscribers, 1, $event,
							$notification_description, "/event/".$event->id);
		$this->indexEvent($event);
		return $event;
	}

	/**
	 * Update the information of an edited event.
	 */
	public function update(EventRequest $request, $id)
	{
		$event = Event::findorfail($id);
		if($request->get('organization')->id == $event->organization()->id)
		{
			$event = Event::findOrFail($id);
			$event->update($request->all());
			Notification::notify($event->volunteers, 2, $event,
								"Event ".($event->name)." has been updated", url("/event",$id));
		}
		$this->indexEvent($event);
	}

	/**
	 * Organization cancel an event.
	 */
	public function organization_cancel($id, $organization)
	{
		$event = Event::findOrFail($id);
		if($organization->id == $event->organization()->id)
		{
			$event->delete();
			Notification::notify($event->volunteers, 3, null,
								"Event ".($event->name)."has been cancelled", url("/"));
			$this->unindexEvent($event->id);
		}
	}

	/**
	 * Admin cancel an event.
	 */
	public function admin_cancel($id, $user)
	{
		$event = Event::findOrFail($id);
		if($user->role >= 8)
		{
			$event->delete();
			Notification::notify($event->volunteers, 3, null,
				"Event ".($event->name)."has been cancelled", url("/"));
			$this->unindexEvent($event->id);
		}
	}

	/**
	 * Delete an event permanently.
	 */
	public function destroy($id ,$user)
	{
		$event = Event::findOrFail($id);
		if($user->role >= 8)
		{
			$event->forceDelete();
			Notification::notify($event->volunteers, 3, null,
				"Event ".($event->name)."has been cancelled", url("/"));
			$this->unindexEvent($event->id);
		}
	}


/*
|==========================================================================
| Volunteers' Interaction with Event
|==========================================================================
|
*/
    public function follow($id, $volunteer)
    {
      $volunteer->followEvent($id);
    }

    public function unfollow($id, $volunteer)
    {
      $volunteer->unfollowEvent($id);
    }

    public function register($id, $volunteer)
    {
      $event = Event::findOrFail($id);
      if($event->timing > carbon::now())
        $volunteer->registerEvent($id);
    }

    public function unregister($id, $volunteer)
    {
      $volunteer->unregisterEvent($id);
    }

    public function attend($id, $volunteer)
    {
      $event = Event::findOrFail($id);
      if($event->timing < carbon::now())
        $volunteer->attendEvent($id);
    }

    public function unattend($id, $volunteer)
    {
        $event = Event::findOrFail($id);
  	    if($event->timing < carbon::now())
  		    $volunteer->unattendEvent($id);
    }

	/**
	 * Add new event to Elasticsearch in order to keep Elasticsearch
	 * in sync with our database
	 */
	public function indexEvent($event)
	{
	 	$client = new Elasticsearch(elasticClientBuilder::create()->build());
		$parameters = [
		  'index'	=> 'events',
		  'type'	=> 'event',
		  'id' 		=> $event->id,
		  'body' 	=> [
							'name' 		  => $event->name,
							'description' => $event->description,
							'location'    => $event->location
						]
	  	];

	  	try
		{
			$client->index($parameters);
		}
		catch (Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e)
		{
			echo "Error";
			$last = $elastic->transport->getLastConnection()->getLastRequestInfo();
			$last['response']['error'] = [];
			dd($last);
		}
	}

	/**
	 * Delete event from Elasticsearch server
	 * @param  [Integer] $event_id [the id of the event to be deleted]
	 */
	public function unindexEvent($event_id)
	{
		$client = new Elasticsearch(elasticClientBuilder::create()->build());
		$params = [
			'index' => 'events',
			'type' => 'event',
			'id' => $event_id
		];

		$client->delete($params);
	}

	/**
	 * Delete all events of an organization from Elasticsearch server
	 * @param  [Organization] $organization [the organization to delete its events]
	 */
	public function unindexOrganizationEvents($organization)
	{
		$events = $organization->events()->get();
		foreach ($events as $event)
			$this->unindexEvent($event->id);
	}
}
