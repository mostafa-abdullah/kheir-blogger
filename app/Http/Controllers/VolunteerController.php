<?php

namespace App\Http\Controllers;

use App\Organization;
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
            'createChallenge', 'storeChallenge',
            'editChallenge', 'updateChallenge',
            'showNotifications', 'unreadNotification',
        ]]);

        $this->middleware('auth_organization', ['only' => [
            // Add all functions that are allowed for organizations only
        ]]);

        $this->middleware('auth_both', ['only' => [
            // Add all functions that are allowed for volunteers/organizations only

        ]]);
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
        if(Auth::user()->currentYearChallenge())
            return redirect('volunteer/challenge/edit');
        return view('volunteer.challenge.create');
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
        $challenge = Auth::user()->currentYearChallenge();
        if($challenge)
            return view('volunteer.challenge.edit' , compact('challenge'));
        return redirect('volunteer/challenge/create');
    }

    /**
     *  Volunteer can update challenge
     */
    public function updateChallenge(Request $request)
    {
        $this->validate($request , ['events' => 'required|numeric|min:1']);
        $challenge = Auth::user()->currentYearChallenge();
        if($challenge)
            $challenge->update($request->all());
        return redirect('home');
    }

    /**
     * show all notifications for the authenticated user.
     */
	public function showNotifications()
    {
		$notifications = Auth::user()->notifications()->unread()->get();
        foreach($notifications as $notification)
        {
            $notification->pivot->read = 1;
            $notification->push();
        }
    	return view('notifications.show', compact('notifications'));
    }

    /**
     * Mark this notification as unread.
     */
    public function unreadNotification(Request $request)
    {
        $notification = Auth::user()->notifications()->findOrFail($request['notification_id']);
        $notification->pivot->read = 0;
        $notification->push();
    }

    /**
      *  User blocks an organization
      */
    public function blockAnOrganization ($organization_id){
        $organization = Organization::find($organization_id);
        Auth::user()->blockOrganisation()->attach($organization);

    }
}
