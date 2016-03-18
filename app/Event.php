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


    public function followers (){
        return $this->users()->where('volunteering_type','=','1');
    }

    public function registeredUsers (){
        return $this->users()->where('volunteering_type','=','2');
    }
}
