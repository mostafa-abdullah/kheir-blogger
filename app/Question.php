<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	
    /**
    *	Attribute not to be mass filled.
    */
    protected $guarded = array('id','user_id', 'event_id', 'answered_at');

    protected $dates = ['answered_at']; 

    /**
    *	A question belongs to a single event.
    */
    public function event()
    {
    	return $this->belongsTo('App\Event');
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

    /**
	*	Fetches one answered question, typically used in creating hyper links.
	*/
    public function showQuestion($id)
    {
    	return Question::find($id);
    }
}
