<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Users represent the volunteers
 */
class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get list of Organizations which the user is subscribed to.
     */
    public function subscribedOrganizations()
    {
      return $this->belongsToMany("App\Organization",
        "volunteers_subscribe_organizations")->withTimestamps();

    }

    /**
     * Subscribe to an Organization.
     */
    public function subscribe($organization_id)
    {
      return $this->subscribedOrganizations()->attach($organization_id);
    }

    /**
     * Unsubscribe from an Organization.
     */
    public function unsubscribe($organization_id)
    {
      return $this->subscribedOrganizations()->detach($organization_id);

    }


    public function recommendations()
    {
        return $this->hasMany('App\Recommendation');
    }


    /**
     * users can receive many notifications and there are property read which specifies if user read notification or still not
     * @return $this
     */

    public function notifications (){
        return $this->belongsToMany('App\Notification',"user_notification")->withTimestamps()->withPivot('read');
    }

    /*
     * users can volunteer in many events
     *
     */


    public function events (){
        return $this->belongsToMany('App\Event','volunteerInEvent')->withTimestamps()->withPivot('volunteering_type');

    }




}
