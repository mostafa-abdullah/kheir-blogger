<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Challenge;

use Carbon\Carbon;
use Auth;

class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_volunteer');
    }

    public function index()
    {
       $currentChallenge = Auth::user()->currentYearChallenge()->first();
       $previousChallenges = Auth::user()->previousYearsChallenges()->latest('year')->get();
       return view('volunteer.challenge.index' , compact('currentChallenge' , 'previousChallenges'));
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
        $this->validate($request , ['events' => 'required|numeric|min:1']);
        $challenge = new Challenge($request->all());
        $challenge->year = Carbon::now()->year;
        Auth::user()->challenges()->save($challenge);
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
        $this->validate($request , ['events' => 'required|numeric|min:1']);
        $challenge = Auth::user()->currentYearChallenge();
        if($challenge)
            $challenge->update($request->all());
        return redirect('/');
    }

    /**
     * View all attended events of the current year.
     */
    public function viewCurrentYearAttendedEvents()
    {
        $events = Auth::user()->attendedEvents()->year(Carbon::now()->year)->get();
        return view('volunteer.challenge.achieved' , compact('events'));
    }
}
