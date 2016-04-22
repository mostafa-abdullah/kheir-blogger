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
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Authenticatable implements CanResetPassword
{

    use CanResetPasswordTrait;
<<<<<<< HEAD
>>>>>>> b6a2aadc9c19b1e9334ead7527587e3a8d34a229
=======
    use SoftDeletes;
>>>>>>> 30923a088a30d8add374c03cc7be139a44349281

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
