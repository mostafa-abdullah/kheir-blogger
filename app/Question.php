<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Question extends Model
{

    protected $guarded = array('id','user_id', 'event_id');

    protected $dates = ['answered_at'];

    public function event()
    {
    	return $this->belongsTo('App\Event');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function scopeAnswered($query)
    {
    	$query->whereNotNull('answer');
    }

    public function scopeUnanswered($query)
    {
    	$query->whereNull('answer');
    }
}
