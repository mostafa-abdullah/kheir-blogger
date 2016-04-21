<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Organization extends Authenticatable implements CanResetPassword
{

    use CanResetPasswordTrait;

    protected $fillable = [
        'name', 'email', 'password','bio','slogan','phone','location'
    ];

    protected $hidden = ['password', 'remember_token'];

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
