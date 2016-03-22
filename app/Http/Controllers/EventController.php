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
            'askQuestion',

        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
            'create', 'store', 'answerQuestion',
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
		Notification::notify($subscribers, $event, $notification_description, url("/events", $event->id));
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

	public function askQuestion($id){

		//TODO: returns a form for writing a question (Youssef)
		//
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
		$event = Event::findOrFail($id);

        if($question->event()->organization()->id != auth()->guard('organization')->id){
			return redirect()->action('EventController@show', [$id])
							 ->withErrors(['Permission' => 'You do not have Permission to answer this question']);
        }

		$question->answer = $request->get('answer');
		$question->answered_at = Carbon::now();
		$question->save();

		Notification::notify(array($question->user_id), $event, "Your question has been answered", url("/events/", $question->event_id, "/", $question->id));

		//TODO: redirect to unanswered questions when this view is compelete (Youssef)
		return redirect()->action('EventController@show', [$id]);
    }

	public function editEvent($id)
	{
		$organization_auth_id = auth()->guard('organization')->id;
		$organization_create_event_id=Event::find($id)->organization()->id;
		if($organization_auth_id==$organization_create_event_id) {
			$event=Event::findorfail($id);
			return view('event.edit')->with('event',$event);
		}else{
			return redirect('home');
		}

	}

	public function update(EventRequest $req, $id)
	{
		$event=Event::findorfail($id);
		$event->update($req->all());
		$users=$event->users()->toArray();
		Notification::notify($users,$event,"Event ".($event->name)."info has been updated",url("/events/",$id));

		return redirect()->action('EventController@show', [$event->id]);

	}


}
