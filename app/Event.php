<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'name', 'description', 'timing', 'location',
        'required_contact_info','needed_membership'
    ];

    public function organization(){

    	return $this->belongsTo('App\Organization')->first();
	}

    public function  notifications(){

        return $this->belongsToMany('App\Notification',"user_notifications")->withTimestamps();
    }

    public function  users (){

        return $this->belongsToMany('App\User','volunteers_in_events')
                    ->withTimestamps()->withPivot('type');
    }

    public function followers(){

        return $this->users()->where('type','=','1');
    }

    public function registrants(){

        return $this->users()->where('type','=','2');
    }

    public function reviews()
    {
        return $this->hasMany('App\EventReview');
    }

    public function questions(){

        return $this->hasMany('App\Question');
    }

}
