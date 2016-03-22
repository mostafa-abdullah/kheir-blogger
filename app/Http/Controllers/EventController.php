<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;

use Carbon\Carbon;
use App\Event;
use App\Organization;
use App\Question;
use App\Notification;

use Auth;

class EventController extends Controller
{
	public function __construct(){

        $this->middleware('auth_volunteer', ['only' => [
            // Add all functions that are allowed for volunteers only
            'askQuestion', 'storeQuestion',

        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
            'create', 'store', 'answerQuestion', 'viewUnansweredQuestions'
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
        // hint: to display question use the scope methods in the Question model
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
		$event = $organization->createEvent($request);
		$subscribers = $organization->subscribers()->get();
		$notification_description = $organization->name." created a new event ".$request->name;
		Notification::notify($subscribers, $event, $notification_description, url("/event", $event->id));
		return redirect()->action('EventController@show', [$event->id]);
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

	public function askQuestion($id)
	{
		return view('event.question.ask', compact('id'));
	}

    public function storeQuestion(Request $request, $id)
    {
		$this->validate($request, [ 'question' => 'required' ]);

        $question = new Question($request->all());
        $question->user_id = Auth::user()->id;
		Event::findOrFail($id)->questions()->save($question);

        return redirect()->action('EventController@show', [$id]);
    }

    public function answerQuestion(Request $request, $id, $q_id)
    {
	 	$this->validate($request, [ 'answer' => 'required' ]);

        $question = Question::findOrFail($q_id);
		$event = $question->event();

        if($event->organization()->id != auth()->guard('organization')->user()->id){
			return redirect()->action('EventController@show', [$id])
							 ->withErrors(['Permission' => 'You do not have Permission to answer this question']);
        }

		$question->answer = $request->get('answer');
		$question->answered_at = Carbon::now();
		$question->save();
		Notification::notify(array($question->user()), $event, "Your question has been answered", url("/event/".$question->event_id."question/".$question->id));

		return redirect()->action('EventController@viewUnansweredQuestions', [$id]);
    }

	public function showQuestion($event_id, $question_id)
	{
		$question = Question::findOrFail($question_id);
		if($question->event_id != $event_id)
			abort(404);
		if(!$question->answer)
			return redirect()->action('EventController@show', [$event_id]);
		return view('event.question.show', compact('question'));
	}

    public function viewUnansweredQuestions($id)
    {
        $event = Event::findorfail($id);
		if(auth()->guard('organization')->user()->id == $event->organization_id)
		{
        	$questions = $event->questions()->Unanswered()->get();
        	return view("event.question.answer", compact('questions'));
        }
		return redirect()->action('EventController@show', [$id])
						 ->withErrors(['Permission' => 'You do not have Permission to answer these questions']);
    }
}
