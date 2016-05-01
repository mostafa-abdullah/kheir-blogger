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

    public function index()
    {
        $challenges = $this->challengeService->index();
        return response()->json($challenges);
    }

    /**
     *  Store the challenge in the database.
     */
    public function store(Request $request)
    {
        $this->challengeService->store($request);
        return response('Success.', 200);
    }

    /**
     *  Update the current year's edited challenge.
     */
    public function update(Request $request)
    {
        $this->challengeService->update($request);
        return response('Success.', 200);
    }

    /**
     * View all attended events of the current year.
     */
    public function viewCurrentYearAttendedEvents()
    {
        $events = $this->challengeService->viewCurrentYearAttendedEvents();
        return response()->json($events);
    }
}
