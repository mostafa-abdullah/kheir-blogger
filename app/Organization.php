<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Organization extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password','bio','slogan','phone','location'
    ];

    /**
     * Get list of volunteers subscribed to an organization.
     */
    public function subscribers(){

      return $this->belongsToMany("App\User",
        "volunteers_subscribe_organizations")->withTimestamps();
    }

    public function events(){

      return $this->hasMany('App\Event');
    }

    public function createEvent($request){

      $event = new Event($request->all());
      $this->events()->save($event);
      return $event;
    }

    public function recommendations(){

        return $this->hasMany('App\Recommendation');
    }

    public function reviews(){

        return $this->hasMany('App\OrganizationReview');
    }


}
