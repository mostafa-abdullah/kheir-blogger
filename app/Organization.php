<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Elastic\Elastic as elasticsearch;

class Organization extends Authenticatable implements CanResetPassword
{

    use CanResetPasswordTrait;

    use SoftDeletes;


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
          /**
           * adding new event to Elasticsearch in order to keep Elasticsearch in sync with our database
           */

          // requiring Elsaticsearch class and store it into $elastic variable
          $elastic = $this->app->make(App\Elastic\Elastic::class);
          $parameters = [
            'index' => 'events',
            'type' => 'event',
            'id' => $event->id,
            'body' => $event->toArray()   // return new $event eleoquent model created as an array  
        ]; 
               
            //Indexing the new create event eloquent model
     
           $elastic.index($parameters);
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
