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
            'subscribe', 'unsubscribe', 'createChallenge', 'storeChallenge',
            'editChallenge', 'updateChallenge',
            'showNotifications', 'unreadNotification', 'reportOrganizationReview',
            'reportEventReview'
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


    /*
     * Report an organization's review
     * @param Request $request
     */
    public function reportOrganizationReview(Request $request)
    {
        $reviews = Auth::user()->reportedOrganizationReviews->toArray();
        $found = 0;
        foreach($reviews as $review)
        {
            if ($review['id'] == $request['r_id'])
                $found = 1;
        }

        if ($found == 0)
            Auth::user()->reportedOrganizationReviews()->attach($request['r_id']);
        else {
            // show a message to the user that he is trying to report a review he already reported before.
        }
    }

    /**
     * Report an event's review
     * @param Request $request
     */
    public function reportEventReview(Request $request)
    {
        $reviews = Auth::user()->reportedEventReviews->toArray();
        $found = 0;
        foreach($reviews as $review)
        {
            if ($review['id'] == $request['r_id'])
                $found = 1;
        }

        if ($found == 0)
            Auth::user()->reportedEventReviews()->attach($request['r_id']);
        else {
            // show a message to the user that he is trying to report a review he already reported before.
        }
    }

}
