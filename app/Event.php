<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
   use Illuminate\Database\Eloquent\SoftDeletes;
class Event extends Model
{
 use SoftDeletes;
    protected $fillable = [
        'name', 'description', 'timing', 'location',
        'required_contact_info','needed_membership'
    ];

    public function organization(){

    	return $this->belongsTo('App\Organization')->first();
	}

    public function  notifications(){

        return $this->belongsToMany('App\Notification','event_notifications')->withTimestamps();
    }

    public function  users (){

        return $this->belongsToMany('App\User','volunteers_in_events')
                    ->withTimestamps()->withPivot('type');
    }

    public function followers(){

        return $this->users()->where('type','=','1')->get();
    }

    public function registrants(){

        return $this->users()->where('type','=','2')->get();
    }

    public function reviews()
    {
        return $this->hasMany('App\EventReview');
    }

    public function questions(){

        return $this->hasMany('App\Question');
    }

    public function scopeCurrentYearAttendedEvents($query)
    {
        $query->where('type' , '=' , '3')->whereYear('timing', '=', date('Y'));
    }

}
