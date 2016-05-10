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
    private $challengeService;
    /**
     * Constructor.
     * Sets middlewares for controller functions and initializes challenge service.
     */
    public function __construct()
    {
        $this->challengeService = new ChallengeService();
        $this->middleware('auth_volunteer');
    }

    /**
     * Get a json of all volunteer's challenges.
     */
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
        $this->challengeService->store($request);
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     *  Update the current year's edited challenge.
     */
    public function update(Request $request)
    {
        $this->challengeService->update($request);
        return response()->json('Success.', 200);
    }

    /**
     * View all attended events of the current year.
     */
    public function viewCurrentYearAttendedEvents(Request $request)
    {
        $events = $this->challengeService->viewCurrentYearAttendedEvents($request->get('volunteer'));
        return response()->json($events);
    }
}
