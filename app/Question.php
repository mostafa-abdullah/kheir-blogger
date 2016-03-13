<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	/**
	*	Attributes to be mass filled.
	*/
    protected $fillable = [
        'user_id', 'organization_id', 'event_id', 'question', 
        'question_body', 'answer', 'answered_at'
    ];
    /**
    *	Attribute(s) not to be mass filled.
    */
    protected $guarded = array('id');

    /**
    *	A question belongs to a single event.
    */
    public function event()
    {
    	return $this->belongsTo('Event');
    }

    /**
    *	Fetches the answered questions that would be presented in the events page.
    */
    public function showQuestions()
    {
    	// may be changed to take(10) depending on the layout of the 'event' view.
    	return DB::table('questions')
    					->whereNotNull('answer')
    					->get();
    }

    /**
	*	Fetches one answered question, typically used in creating hyper links.
	*/
    public function showQuestion($id)
    {
    	return Question::find($id);
    }

    /**
    *	Adds a new question to the database by taking individual attributes.
    */
    public function askQuestion($user_id, $organization_id, $event_id,
    	$question, $question_body)
    {
    	Question::create(array('user_id' => $user_id, 'organization_id' => $organization_id, 'event_id' => $event_id, 'question' => $question,
    		'question_body' => $question_body));
    }
}
