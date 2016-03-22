<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\Event;
use App\Challenge;

use Carbon\Carbon;
use Auth;


class VolunteerController extends Controller
{

    public function __construct(){

        $this->middleware('auth_volunteer', ['only' => [
            // Add all functions that are allowed for volunteers only
            'subscribe', 'unsubscribe', 'createChallenge', 'storeChallenge',
            'editChallenge', 'updateChallenge'
        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
        ]]);

        $this->middleware('auth_both', ['only' => [
            // Add all functions that are allowed for volunteers/organizations only

        ]]);
    }

    /**
     * subscribes the authenticated user for the organization with
     * the passed id
     */
    public function subscribe($id){
        Auth::user()->subscribe($id);
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * Unsubscribes the authenticated user for the organization with
     * the passed id
     */
    public function unsubscribe($id){
        Auth::user()->unsubscribe($id);
        return redirect()->action('OrganizationController@show', [$id]);
    }

    /**
     * Shows volunteer's profile
     */
    public static function show($id)
    {
        $volunteer = User::findOrFail($id);
        return view('volunteer.show', compact('volunteer'));
    }

    /**
     *  Volunteer set a challenge to himself
     */
    public function createChallenge()
    {
        $challenge = Auth::user()->currentYearChallenge();
        if($challenge->isEmpty())
            return view('volunteer.challenge.create');
        return redirect('volunteer/challenge/edit');
    }


    /**
     *  Store the challenge in the database
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
     *  Volunteer can edit challenge
     */
    public function editChallenge()
    {
        $challenge = Challenge::findOrFail();
        if($challenge->user->id == Auth::user()->id)
            return view('volunteer.challenge.edit' , compact('challenge' , 'challenge_id'));
        return redirect('home');
    }

    /**
     *  Volunteer can update challenge
     */
    public function updateChallenge(Request $request)
    {
        $this->validate($request , ['events' => 'required|numeric|min:1']);

        $challenge = Challenge::findOrFail($challenge_id);
        if($challenge->user->id == Auth::user()->id)
        {
            $challenge->update($request->all());
            return redirect()->action('VolunteerController@show' , [Auth::user()->id]);
        }
        return redirect('home');

    }



}
