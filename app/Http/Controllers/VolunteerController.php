<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

use Auth;

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
     * Passes User's id to volunteer's view
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public static function show($id)
    {
        $volunteer = User::findOrFail($id);
        return view('volunteer.show', compact('volunteer'));
    }


}
