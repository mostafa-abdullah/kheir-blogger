<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\PostRequest;

use Carbon\Carbon;
use App\Event;
use App\Organization;
use App\Question;
use App\Notification;
use App\Post;

use Auth;

class EventController extends Controller
{
	public function __construct()
	{
        $this->middleware('auth_volunteer', ['only' => [
			'follow', 'unfollow', 'register', 'unregister',
			'askQuestion', 'storeQuestion',

        ]]);

        $this->middleware('auth_organization', ['only' => [
            'create', 'store', 'edit', 'update', 'destroy',
			'answerQuestion', 'viewUnansweredQuestions',
        ]]);
    }

/*
|==========================================================================
| Event CRUD Functions
|==========================================================================
|
*/
	public function show($id)
	{
		// TODO: show the event's page (Hossam Ahmad)
		return Event::find($id);
	}

	public function create()
	{
		return view('event.create');
	}

	public function store(EventRequest $request)
	{
		$organization = auth()->guard('organization')->user();
		$event = $organization->createEvent($request);
		$notification_description = $organization->name." created a new event ".$request->name;
		Notification::notify($organization->subscribers()->get(), $event,
							$notification_description, url("/event", $event->id));
		return redirect()->action('EventController@show', [$event->id]);
	}

	public function edit($id)
	{
		$event = Event::findOrFail($id);
		if(auth()->guard('organization')->user()->id == $event->organization()->id)
			return view('event.edit', compact('event'));
		return redirect()->action('EventController@show', [$id]);
	}

	public function update(EventRequest $request, $id)
	{
		$event = Event::findorfail($id);
		if(auth()->guard('organization')->user()->id == $event->organization()->id)
		{
			$event = Event::findOrFail($id);
			$event->update($request->all());
			Notification::notify($event->volunteers()->get(), $event,
								"Event ".($event->name)." has been updated", url("/event",$id));
		}
		return redirect()->action('EventController@show', [$id]);
	}

/*
|==========================================================================
| Volunteers' Interaction with Event
|==========================================================================
|
*/
	public function follow($id)
	{
		Auth::user()->followEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

	public function unfollow($id)
	{
		Auth::user()->unfollowEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

	public function register($id)
	{
		Auth::user()->registerEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

	public function unregister($id)
	{
		Auth::user()->unregisterEvent($id);
		return redirect()->action('EventController@show', [$id]);
	}

/*
|==========================================================================
| Event Questions
|==========================================================================
|
*/
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
