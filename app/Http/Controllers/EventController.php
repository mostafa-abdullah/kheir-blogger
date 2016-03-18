<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Organization;
use App\Question;

class EventController extends Controller
{

	/**
    *	Adds a new question to the database.
    */
	public function askQuestion()
    {
        if(Auth::user()){
            $input = Input::all();
            $question = new Question;
            $question->user_id = Auth::user()->id;
            $question->event_id = $input['event_id'];
            $question->question = $input['question'];
            $question->question_body = $input['question_body'];
            $question->save();
            // redirect to the event view
        }else{
            // redirect to the same page but with informing them with their
            // inability to answer.
        }
    	
    }
    
    public function answerQuestion($id)
    {
    	$input = Request::all();
    	$input['answered_at'] = Carbon::now();
        if(auth()->guard('organization')->check()){     // I need to check if the organization is answering a question related to it
            $question = Question::findorfail($id);
            $question->answer = $input['answer'];
            $question->answered_at = $input['answered_at'];
            $question->save();
            // redirect the organization to the page that contains the un-answered questions
            //notify the asker using his 'user_id'
        }else{
            //redirect to the event page
        }
    }
	public function create()
	{
		return view('events.create');
	}
}
