<?php

namespace App\Http\Services;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Event;
use App\Question;
use App\Notification;

use Carbon\Carbon;
use Auth;
use Validator;

class EventQuestionService
{

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required'
        ]);

        $question = new Question($request->all());
        $question->user_id = Auth::user()->id;
        Event::findOrFail($id)->questions()->save($question);
    }

    public function answer(Request $request, $event_id, $question_id)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required'
        ]);

        $question = Question::findOrFail($question_id);
		$event = $question->event()->first();

        if($event->organization()->id != auth()->guard('organization')->user()->id)
			return redirect()->action('Event\EventController@show', [$event_id])
							 ->withErrors(['Permission' => 'You do not have Permission to answer this question']);

		$question->answer = $request['answer'];
		$question->answered_at = Carbon::now();
		$question->save();

        $description = "Your question has been answered";
        $link = "/event/".$question->event_id."/question/".$question->id;
		Notification::notify(array($question->user()->first()), 5, $event, $description, $link);
    }

    public function viewUnansweredQuestions($event_id)
    {
        $event = Event::findorfail($event_id);
		if(auth()->guard('organization')->user()->id == $event->organization_id)
		{
        	$questions = $event->questions()->Unanswered()->get();
        	return compact('questions', 'event');
        }
        return null;
    }
}
