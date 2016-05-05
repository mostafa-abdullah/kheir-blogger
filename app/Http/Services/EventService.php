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
use Validator;

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
	 * Cancel an event.
	 */
	public function destroy($id, $organization)
	{
		$event = Event::findOrFail($id);
		if($organization->id == $event->organization()->id)
		{
			$event->delete();
			Notification::notify($event->volunteers, 3, null,
								"Event ".($event->name)."has been cancelled", url("/"));
		}
		$this->unindexEvent($event->id);
	}


/*
|==========================================================================
| Volunteers' Interaction with Event
|==========================================================================
|
*/
    public function follow($id)
    {
      Auth::user()->followEvent($id);
    }

    public function unfollow($id)
    {
      Auth::user()->unfollowEvent($id);
    }

    public function register($id)
    {
	  $validator = Validator::make(
	  [
		'phone' => Auth::user()->phone,
		'address' => Auth::user()->address,
		'city' => Auth::user()->city
	  ]
	  ,
	  [
		'phone' => 'required',
		'address' => 'required',
		'city' => 'required'
	  ]);
	  if($validator->passes())
	  {
		$event = Event::findOrFail($id);
		if ($event->timing > carbon::now())
			Auth::user()->registerEvent($id);
	  }
	  return $validator;
    }

    public function unregister($id)
    {
      Auth::user()->unregisterEvent($id);
    }

    public function attend($id)
    {
      $event = Event::findOrFail($id);
      if($event->timing < carbon::now())
        Auth::user()->attendEvent($id);
    }

    public function unattend($id)
    {
        $event = Event::findOrFail($id);
  	    if($event->timing < carbon::now())
  		    Auth::user()->unattendEvent($id);
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
