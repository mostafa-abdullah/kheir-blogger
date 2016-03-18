<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Organization extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password','bio','slogan','phone','location',
    ];

    /**
     * Get list of Users subscribed to an Organization.
     */
    public function subscribers()
    {
      return $this->belongsToMany("App\User",
        "volunteers_subscribe_organizations")->withTimestamps();
    }

    public function events()
    {
      return $this->hasMany('App\Event');
    }

    public function createEvent($request)
    {
      # code...
      $organization_id = $this->id;

      $event = new Event;
      $event =
      [
        name => $request->name,
        description => $request->description,
        location => $request->location,
        timing => $request->timing,
        organization_id => $organization_id
      ];
      $event->save();
      return $event->id;
      //print_r($request->all());
    }
}
