<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Question extends Model
{

    /**
    *	Attribute not to be mass filled.
    */
    protected $guarded = array('id','user_id', 'event_id');

    protected $dates = ['answered_at'];

    /**
    *	A question belongs to a single event.
    */
    public function event(){

    	return $this->belongsTo('App\Event')->first();
    }

    public function user(){

    	return $this->belongsTo('App\User');
    }

    /**
    *	Fetches the answered questions that would be presented in the events page.
    */
    public function scopeAnswered($query) {
    	$query->whereNotNull('answer');
    }

    /**
    *	Fetches the unanswered questions to be displayed to the organization with
    *	the intention to answer them.
    */
    public function scopeUnanswered($query)
    {
    	$query->whereNull('answer');
    }
}
