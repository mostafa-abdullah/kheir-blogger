<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	/**
	*	Attributes to be mass filled.
	*/
    protected $fillable = [
        'user_id', 'organization_id', 'question', 'answer'
    ];

    /**
    *	Fetches the questions that would be presented in the events page.
    */
    public function index()
    {
    	
    }

    public function show($id)
    {
    	
    }


}
