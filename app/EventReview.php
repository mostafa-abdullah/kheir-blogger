<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventReview extends Model
{

    use SoftDeletes;

    protected $fillable = ['review', 'rating'];

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
        return $this->belongsTohMany('App\User', 'event_review_reports', 'review_id', 'user_id')
                    ->withTimestamps()->withPivot('viewed');;
    }
}
