<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder as elasticClientBuilder;

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
            $client = new Elasticsearch(elasticClientBuilder::create()->build());

          $parameters = [
            'index' => 'events',
            'type' => 'event',
            'id' => $event->id,
            'body' => [    
                              'name'=>$event->name,
                              'description'=>$event->description,
                              'location'=>$event->location    
                  ]   
        ]; 
               
        try {

          /**
           * indexing new event and added it to elastic search server
           */
               
              $newEvent = $client->index($parameters);
               return $event;
              //dd($docs);
          }
            catch (Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) {
                echo "error";
              $last = $elastic->transport->getLastConnection()->getLastRequestInfo();
              $last['response']['error'] = [];
              dd($last);
            }
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
