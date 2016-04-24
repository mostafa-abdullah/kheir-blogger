<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Services\EventQuestionService;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Event;

class EventQuestionController extends Controller
{
    private $eventQuestionService;

    public function __construct()
    {
        $this->eventQuestionService = new EventQuestionService();
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
        $result = $this->eventQuestionService->store($request, $id);
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
	 	$result = $this->eventQuestionService->answer($request, $event_id, $question_id);
		return redirect()->action('Event\EventQuestionController@viewUnansweredQuestions', [$event_id]);
    }

    public function viewUnansweredQuestions($event_id)
    {
        $result = $this->eventQuestionService->viewUnansweredQuestions($event_id);
		if($result)
        	return view("event.question.answer", $result);
		return redirect()->action('Event\EventController@show', [$event_id])
						 ->withErrors(['Permission' => 'You do not have Permission to answer these questions']);
    }

}
