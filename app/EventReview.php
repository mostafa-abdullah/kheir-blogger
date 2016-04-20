<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventReview extends Model
{
    protected $fillable = ['review', 'rate'];

    protected $table = 'event_reviews';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function reportingUsers()
    {
        return $this->belongsToMany('App\User', 'event_review_reports', 'review_id', 'user_id')
                    ->withTimestamps()->withPivot('viewed');;
    }
}
