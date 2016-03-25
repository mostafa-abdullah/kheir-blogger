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
     * to check if the user already subscribed an organization
     */
    public function isSubscribed($id){
        if(!$this->subscribedOrganizations()->find($id))
           return false;
        return true;
    }

    /**
     * Unsubscribe from an organization.
     */
    public function unsubscribe($organization_id)
    {
        return $this->subscribedOrganizations()->detach($organization_id);
    }

    public function followEvent($event_id)
    {
        if (!$this->events()->find($event_id))
            $this->events()->attach($event_id,['type' => 1]); 
        else
           $this->events()->find($event_id)->type = 1; 
    }
    public function unfollowEvent($event_id)
    {
        $this->events()->detach($event_id);
    }
    public function registerEvent($event_id)
    {   
        if (!$this->events()->find($event_id))
            $this->events()->attach($event_id,['type' => 2]); 
        else
           $this->events()->find($event_id)->type = 2; 
    }
    public function unregisterEvent($event_id)
    {
        $this->events()->detach($event_id);
    }
    public function recommendations(){

        return $this->hasMany('App\Recommendation');
    }

    public function organizationReviews(){

        return $this->hasMany('App\OrganizationReview');
    }

    public function reportedOrganizationReviews()
    {
        return $this->belongsToMany('App\OrganizationReview',
                        'organization_review_reports', 'user_id', 'review_id')->withTimestamps();
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

    public function reportedEventReviews()
    {
        return $this->belongsToMany('App\EventReview',
            'event_review_reports', 'user_id', 'review_id')->withTimestamps();
    }

    public function eventQuestions(){
        return $this->hasMany('App\Question');
    }

    public function challenges(){

        return $this->hasMany('App\Challenge');
    }

    public function currentYearChallenge(){

        return $this->challenges()->currentYear()->first();
    }

    /**
     *  A user can block many organiztions
     */
    public function blockOrganisation (){
        return $this->belongsToMany('App\Organization','usersBlockedOrganiztion')->withTimestamps();
    }


}
