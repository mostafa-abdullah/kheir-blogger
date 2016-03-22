<?php

namespace App\Http\Controllers;

use App\Challenge;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

use App\Event;
use Illuminate\Support\Facades\Auth;


class VolunteerController extends Controller
{

    public function __construct(){

        $this->middleware('auth_volunteer', ['only' => [
            // Add all functions that are allowed for volunteers only
            'subscribe', 'unsubscribe',
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
            return view('volunteer.challenge');

    }


    /**
     *  Store the challenge in the database
     */
    public function storeChallenge(Request $request)
    {
        $this->validate($request , ['events' => 'required|numeric|min:1' ,]);

        $user_id = Auth::user()->id;
        $challenge = new Challenge($request->all());
        $challenge->user_id = $user_id;
        $user = User::findOrFail($user_id);
        $user->challenges()->save($challenge);
        return redirect()->action('VolunteerController@show' , [$user_id]);

    }

    /**
     *  The volunteer edit a challenge
     */

    public function editChallenge($challenge_id)
    {
        $challenge = Challenge::findOrFail($challenge_id);
        if($challenge->user->id == Auth::user()->id)
            return view('volunteer.editChallenge' , compact('challenge' , 'challenge_id'));
        return redirect('/');
    }



    /**
     *  Store the edited challenge in the database
     */
    public function updateChallenge(Request $request , $challenge_id)
    {
        $this->validate($request , ['events' => 'required|numeric|min:1']);

        $challenge = Challenge::findOrFail($challenge_id);
        if($challenge->user->id == Auth::user()->id)
        {
            $challenge->update($request->all());
            return redirect()->action('VolunteerController@show' , [Auth::user()->id]);
        }
        return redirect('/');

    }



}
