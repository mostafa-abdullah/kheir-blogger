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


    public function createChallenge($id)
    {
        if(Auth::user()->id == $id)
            return view('volunteer.challenge' , compact('id'));
        return redirect('/');
    }

    public function storeChallenge(Request $request , $id)
    {
        $this->validate($request , ['challenge' => 'required|numeric|min:1' ,]);

        if(Auth::user()->id == $id)
        {

            $user_id = Auth::user()->id;
            $challenge = new Challenge($request->all());
            $challenge->user_id = $user_id;
            $challenge->save();
            return redirect()->action('VolunteerController@show' , [$user_id]);
        }
        return redirect('/');
    }

}
