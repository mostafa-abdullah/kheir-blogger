<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\ChallengeService;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Challenge;

use Carbon\Carbon;
use Auth;

class ChallengeAPIController extends Controller
{
    public function __construct()
    {
        $this->challengeService = new ChallengeService();
        $this->middleware('auth_volunteer');
    }

    public function index(Request $request)
    {
        $challenges = $this->challengeService->index($request->get('volunteer'));
        return response()->json($challenges);
    }

    /**
     *  Store the challenge in the database.
     */
    public function store(Request $request)
    {
        return $this->getResponse($this->challengeService->store($request));
    }

    /**
     *  Update the current year's edited challenge.
     */
    public function update(Request $request)
    {
        return $this->getResponse($this->challengeService->update($request));
    }

    /**
     * View all attended events of the current year.
     */
    public function viewCurrentYearAttendedEvents(Request $request)
    {
        $events = $this->challengeService->viewCurrentYearAttendedEvents($request->get('volunteer'));
        return response()->json($events);
    }

    private function getResponse($validator){

        if($validator->fails())
            $statusCode = 400;
        else
            $statusCode = 200;

        switch($statusCode){
            case 200:
                $message = 'Success';
                break;
            case 400:
                $message = 'Bad request';
                break;
            case 403:
                $message = 'Forbidden';
                break;
            default:
                $message = 'Something wrong happened';
        }

        return response()->json( ['message' => $message] , $statusCode);
    }
}
