<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'description', 'timing','location','required_contact_info','needed_membership'
    ];




    public function  notifications()
    {
        return $this->belongsToMany('App\Notification',"user_notification")->withTimestamps();
    }

    public function organization()
    {
    	return $this->belongsTo('App\Organization');
    }
}
