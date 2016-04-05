<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;


class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'timing', 'location',
        'required_contact_info', 'needed_membership'
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
        return $this->volunteers()->where('type', 1);
    }

    public function registrants()
    {
        return $this->volunteers()->where('type', 2);
    }

    public function attendees()
    {
        return $this->volunteers()->where('type', 3);
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Notification','event_notifications')
                    ->withTimestamps();
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

    public function scopeYear($query, $year)
    {
        $query->whereYear('timing', '=', $year);
    }

    public function scopeCurrentYear($query)
    {
        $query->whereYear('timing', '=', date('Y'));
    }

    public function scopeBetweenTiming($query, $start, $end)
    {
        $query->whereBetween('timing', [$start, $end]);
    }

    public function gallery($id)
    {
        return $this->hasMany('App/Image')->where('event_id',$id);
    }
}
