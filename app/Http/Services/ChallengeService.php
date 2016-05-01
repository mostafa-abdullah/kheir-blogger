<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Challenge;

use Carbon\Carbon;
use Auth;
use Validator;

class ChallengeService
{

    public function index($volunteer)
    {
       $currentChallenge = $volunteer->currentYearChallenge()->first();
       $previousChallenges = $volunteer->previousYearsChallenges()->latest('year')->get();
       return compact('currentChallenge' , 'previousChallenges');
    }

    /**
     *  Store the challenge in the database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'events' => 'required|numeric|min:1'
        ]);
        if ($validator->passes()) {
            $challenge = new Challenge($request->all());
            $challenge->year = Carbon::now()->year;
            Auth::user()->challenges()->save($challenge);
        }
        return $validator;
    }

    /**
     *  Update the current year's edited challenge.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'events' => 'required|numeric|min:1'
        ]);
        if($validator->passes())
        {
            $challenge = $request->get('volunteer')->currentYearChallenge();
            if($challenge)
            {
                $input['events'] = $request->get('events');
                $challenge->update($input);
            }
        }
        return $validator;
    }

    /**
     * View all attended events of the current year.
     */
    public function viewCurrentYearAttendedEvents($volunteer)
    {
        $events = $volunteer->attendedEvents()->year(Carbon::now()->year)->get();
        return compact('events');
    }

}
