<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\EventQuestionService;

use App\Http\Requests;
use Illuminate\Http\Request;

class EventQuestionAPIController extends Controller
{
    private $eventQuesionService;

    public function __construct()
    {
        $this->eventQuestionService = new EventQuestionService();
        $this->middleware('auth_volunteer', ['only' => [
            'store',
        ]]);

        $this->middleware('auth_organization', ['only' => [
             'answer', 'viewUnansweredQuestions'
        ]]);
    }

    public function store(Request $request, $id)
    {
        $result = $this->eventQuestionService->store($request, $id);
        return response()->json(['message' => 'Success.'], 200);
    }

    public function answer(Request $request, $event_id, $question_id)
    {
        $result = $this->eventQuestionService->answer($request, $event_id, $question_id);
        return response()->json(['message' => 'Success.'], 200);
    }

    public function viewUnansweredQuestions(Request $request, $event_id)
    {
        $result = $this->eventQuestionService->viewUnansweredQuestions($event_id, $request->get('organization'));
		return response()->json($result);
    }
}
