<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
<<<<<<< HEAD
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
=======
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Organization extends Authenticatable implements CanResetPassword
{

    use CanResetPasswordTrait;
>>>>>>> b6a2aadc9c19b1e9334ead7527587e3a8d34a229

    protected $fillable = [
        'name', 'email', 'password','bio','slogan','phone','location'
    ];

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
          $event = new Event($request->all());
          $this->events()->save($event);
          return $event;
    }

    public function recommendations()
    {
        return $this->hasMany('App\Recommendation');
    }

    public function reviews()
    {
        return $this->hasMany('App\OrganizationReview');
    }

    public function blockingVolunteers()
    {
        return $this->belongsToMany('App\User','volunteers_block_organizations')
                    ->withTimestamps();
    }

}
