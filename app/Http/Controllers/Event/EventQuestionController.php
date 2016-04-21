<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Event;
use App\Question;
use App\Notification;

use Carbon\Carbon;
use Auth;

class EventQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_volunteer', ['only' => [
            'create', 'store',
        ]]);

        $this->middleware('auth_organization', ['only' => [
             'answer', 'viewUnansweredQuestions'
        ]]);
    }

    public function index($id)
    {
        $event = Event::findOrFail($id);
        return $event->questions()->answered()->get();
    }

    public function show($event_id, $question_id)
    {
        $question = Event::findOrFail($event_id)->questions()->findOrFail($question_id);
        if(!$question->answer)
            return redirect()->action('Event\EventController@show', [$event_id]);
        return view('event.question.show', compact('question'));
    }

    public function create($id)
    {
        return view('event.question.create', compact('id'));
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, ['question' => 'required']);

        $question = new Question($request->all());
        $question->user_id = Auth::user()->id;
        Event::findOrFail($id)->questions()->save($question);

        return redirect()->action('Event\EventController@show', [$id]);
    }

    public function edit($event_id, $question_id)
    {
        //TODO
    }

    public function update($event_id, $question_id)
    {
        //TODO
    }

    public function destroy($event_id, $question_id)
    {
        //TODO
    }

    public function answer(Request $request, $event_id, $question_id)
    {
	 	$this->validate($request, ['answer' => 'required']);

        $question = Question::findOrFail($question_id);
		$event = $question->event()->first();

        if($event->organization()->id != auth()->guard('organization')->user()->id)
			return redirect()->action('Event\EventController@show', [$event_id])
							 ->withErrors(['Permission' => 'You do not have Permission to answer this question']);

		$question->answer = $request['answer'];
		$question->answered_at = Carbon::now();
		$question->save();

        $description = "Your question has been answered";
        $link = url("/event/".$question->event_id."question/".$question->id);
		Notification::notify(array($question->user()->first()), 5, $event, $description, $link);

		return redirect()->action('Event\EventQuestionController@viewUnansweredQuestions', [$event_id]);
    }

    public function viewUnansweredQuestions($event_id)
    {
        $event = Event::findorfail($event_id);
		if(auth()->guard('organization')->user()->id == $event->organization_id)
		{
        	$questions = $event->questions()->Unanswered()->get();
        	return view("event.question.answer", compact('questions', 'event'));
        }
		return redirect()->action('Event\EventController@show', [$event_id])
						 ->withErrors(['Permission' => 'You do not have Permission to answer these questions']);
    }

}
