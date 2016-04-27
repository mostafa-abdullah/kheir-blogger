<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Services\ChallengeService;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Challenge;

use Carbon\Carbon;
use Auth;
use Validator;

class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->challengeService = new ChallengeService();
        $this->middleware('auth_volunteer');
    }

    public function index()
    {
        $challenges = $this->challengeService->index();
        return view('volunteer.challenge.index' , $challenges);
    }

    /**
     *  Set a challenge for the current year.
     */
    public function create()
    {
        if(Auth::user()->currentYearChallenge()->first())
            return redirect('volunteer/challenge/edit');
        return view('volunteer.challenge.create');
    }

    /**
     *  Store the challenge in the database.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $num = $input['events'];
        if($num<0)
        {
            return redirect('volunteer/challenge/create');
        }
        $this->challengeService->store($request);
        return redirect('/');
    }

    /**
     *  Edit current year's challenge.
     */
    public function edit()
    {
        $challenge = Auth::user()->currentYearChallenge()->first();
        if($challenge)
            return view('volunteer.challenge.edit' , compact('challenge'));
        return redirect('volunteer/challenge/create');
    }

    /**
     *  Update the current year's edited challenge.
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $num = $input['events'];
        if($num<0)
        {
            return redirect('volunteer/challenge/edit');
        }
        $this->challengeService->update($request);
        return redirect('/');
    }

    /**
     * View all attended events of the current year.
     */
    public function viewCurrentYearAttendedEvents()
    {
        $events = $this->challengeService->viewCurrentYearAttendedEvents();
        return view('volunteer.challenge.achieved' , $events);
    }
}
