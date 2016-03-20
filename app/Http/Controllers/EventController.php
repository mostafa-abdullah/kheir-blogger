<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Event;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Organization;
use App\Question;
use App\Notification;

class EventController extends Controller
{

class EventController extends Controller
{
	public function __construct(){

        $this->middleware('auth_volunteer', ['only' => [
            // Add all functions that are allowed for volunteers only

        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
            'create', 'store'
        ]]);

        $this->middleware('auth_both', ['only' => [
            // Add all functions that are allowed for volunteers/organizations only

        ]]);
    }

	/**
	 * show the event's page
	 */
	public function show($id){
		// TODO: show the event's page (Hossam Ahmad)
		return Event::find($id);
	}

	/**
	 * returns a form to create a new event
	 */
	public function create(){

		return view('event.create');
	}

	/**
	 * store the created event in the database
	 */
	public function store(EventRequest $request){

		$organization = auth()->guard('organization')->user();
		$event_id = $organization->createEvent($request);
		//TODO: notify subscribers and nearby volunteers (Esraa)
		return redirect()->action('EventController@show', [$event_id]);
	}

	public function follow($id){

		// TODO: a volunteer can follow an unfollowed event (Hatem)
		//
		return redirect()->action('EventController@show', [$id]);
	}

	public function unfollow($id){

		// TODO: a volunteer can unfollow an already followed event (Hatem)
		//
		return redirect()->action('EventController@show', [$id]);
	}

	public function register($id){

		// TODO: a volunteer can regiseter for an event only once (Hatem)
		//
		return redirect()->action('EventController@show', [$id]);
	}

	public function unregister($id){

		// TODO: a volunteer can unregiser from an already registered event (Hatem)
		// 
		return redirect()->action('EventController@show', [$id]);
	}

    /**
    *   Adds a new question to the database.
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
        if(auth()->guard('organization')->check() && $question->event()->organization()->id == auth()->guard('organization')->id){ 
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

}
