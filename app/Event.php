<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'description', 'timing','location','required_contact_info','needed_membership'
    ];

    /**
     * Event can have many notifications
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function  notifications()
    {
        return $this->belongsToMany('App\Notification',"user_notification")->withTimestamps();
    }

    /**
     * Events can have many volunteers
     *
     */

    public function  users (){
        return $this->belongsToMany('App\User','volunteerInEvent')->withTimestamps()->withPivot('volunteering_type');
    }

    /**
     *
     * gets all the users following the event and the volunteering_type for follwing an event equal 1
     *
     * @return mixed
     */

    public function followers (){
        return $this->users()->where('volunteering_type','=','1');
    }


    /**
     *
     * gets all the users register an event and the volunteering_type for follwing an event equal 2
     *
     * @return mixed
     */

    public function registeredUsers (){
        return $this->users()->where('volunteering_type','=','2');
    }
}
