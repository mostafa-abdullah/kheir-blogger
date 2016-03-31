<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Elasticquent\ElasticquentTrait;

class Organization extends Authenticatable

{

    use ElasticquentTrait;


    protected $mappingProperties = array(
        'name' => array(
            'type' => 'string',
            'analyzer' => 'standard'
        )
    );

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


    /**
     *  An orgaization can be blocked by many users
     */

    public function blockedByUser (){
      return $this->belongsToMany('App\User','usersBlockedOrganiztion')->withTimestamps();
    }

}
