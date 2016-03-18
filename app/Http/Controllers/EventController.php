<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

class EventController extends Controller
{
    //

	/**
    *	Adds a new question to the database.
    */
	public function askQuestion()
    {
    	Question::create(Request::all()$input);
    }

    public function answerQuestion()
    {
    	$input = Request::all();
    	$input['answered_at'] = Carbon::now();

    	Question::create($input);
    }
}
