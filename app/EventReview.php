<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EventReview extends Model
{

    use SoftDeletes;

    protected $fillable = ['review', 'rate'];

    protected $table = 'event_reviews';
     
    protected $dates = ['deleted_at'];

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
                    ->withTimestamps();
    }
}
