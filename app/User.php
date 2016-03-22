<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Users represent the volunteers
 */
class User extends Authenticatable
{

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get list of Organizations which the user is subscribed to.
     */
    public function subscribedOrganizations()
    {
      return $this->belongsToMany('App\Organization',
        'volunteers_subscribe_organizations')->withTimestamps();
    }

    /**
     * Subscribe to an organization.
     */
    public function subscribe($organization_id){

        if(!$this->subscribedOrganizations()->find($organization_id))
            $this->subscribedOrganizations()->attach($organization_id);
    }

    /**
     * Unsubscribe from an organization.
     */
    public function unsubscribe($organization_id)
    {
        return $this->subscribedOrganizations()->detach($organization_id);
    }
    public function recommendations(){

        return $this->hasMany('App\Recommendation');
    }

    public function organizationReviews(){

        return $this->hasMany('App\OrganizationReview');
    }

    public function notifications (){

        return $this->belongsToMany('App\Notification', 'user_notifications')
                    ->withTimestamps()->withPivot('read');
    }

    public function events(){

        return $this->belongsToMany('App\Event','volunteers_in_events')
                    ->withTimestamps()->withPivot('type');
    }

    public function eventReviews(){

        return $this->hasMany('App\Review');
    }

    public function eventQuestions(){
        return $this->hasMany('App\Question');
    }


}
