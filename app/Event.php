<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{

    protected $fillable = [
        'name', 'description', 'timing', 'location',
        'required_contact_info','needed_membership'
    ];

    protected $dates = ['timing'];

    public function setTimingAttribute($timing)
    {
        $this->attributes['timing'] = Carbon::parse($timing);
    }

    public function organization()
    {
    	return $this->belongsTo('App\Organization')->first();
	}

    public function volunteers()
    {
        return $this->belongsToMany('App\User','volunteers_in_events')
                    ->withTimestamps()->withPivot('type');
    }

    public function followers()
    {
        return $this->users()->where('type','=','1');
    }

    public function registrants()
    {
        return $this->users()->where('type','=','2');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Notification','event_notifications')->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany('App\EventPost');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function reviews()
    {
        return $this->hasMany('App\EventReview');
    }
}
