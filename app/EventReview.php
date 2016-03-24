<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventReview extends Model
{
    protected $fillable = ['review', 'rate'];

    protected $table = ['event_reviews'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

}
