<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_volunteer');
    }

    /**
     *  Set a challenge for the current year.
     */
    public function createChallenge()
    {
        if(Auth::user()->currentYearChallenge())
            return redirect('volunteer/challenge/edit');
        return view('volunteer.challenge.create');
    }

    /**
     *  Store the challenge in the database.
     */
    public function storeChallenge(Request $request)
    {
        $this->validate($request , ['events' => 'required|numeric|min:1']);
        $challenge = new Challenge($request->all());
        $challenge->year = Carbon::now()->year;
        Auth::user()->challenges()->save($challenge);
        return redirect('home');
    }

    /**
     *  Edit current year's challenge.
     */
    public function editChallenge()
    {
        $challenge = Auth::user()->currentYearChallenge();
        if($challenge)
            return view('volunteer.challenge.edit' , compact('challenge'));
        return redirect('volunteer/challenge/create');
    }

    /**
     *  Update the current year's edited challenge.
     */
    public function updateChallenge(Request $request)
    {
        $this->validate($request , ['events' => 'required|numeric|min:1']);
        $challenge = Auth::user()->currentYearChallenge();
        if($challenge)
            $challenge->update($request->all());
        return redirect('home');
    }
}
