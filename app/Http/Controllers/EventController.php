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
use App\Notification;

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
            return redirect(url('/events/'.$input['event_id']));
        }else{
            return redirect(url('/events/'.$input['event_id']))->withErrors(['Permission' => 'You have to be logged in to ask a question']);
        }
    	
    }
    
    public function answerQuestion($id)
    {
    	$input = Request::all();
    	$input['answered_at'] = Carbon::now();
        $question = Question::findorfail($id);
        if(auth()->guard('organization')->check() && $question->event()->organization()->id == auth()->guard('organization')->check()->id){ 
                $question->answer = $input['answer'];
                $question->answered_at = $input['answered_at'];
                $question->save();
                $notification = new Notification;
                $notification->addNotification(compact($question->user_id), $question->event_id, "Your question has been answered", "/events/".$question->event_id . "/" . $question->id);
                return redirect(url('/events/unansweredQuestions/'$input['event_id']));    
        }else{
            return redirect(url('/events'$input['event_id']))->withErrors(['Permission' => 'You do not have Permission to answer this question']);
        }
    }

	public function create()
	{
		return view('event.create');
	}
}
