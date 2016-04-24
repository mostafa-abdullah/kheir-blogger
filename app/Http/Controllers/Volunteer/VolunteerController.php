<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Services\VolunteerService;

use App\Location;
use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;
use App\User;

use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Input;


class VolunteerController extends Controller
{
    private $volunteerService;

    public function __construct()
    {
        $this->volunteerService = new volunteerService();
        $this->middleware('auth_volunteer', ['only' => [
            'showNotifications', 'unreadNotification', 'showDashboard',
            'createFeedback', 'storeFeedback', 'edit', 'update'
        ]]);
    }

    /**
     * Show volunteer profile.
     */
    public static function show($id)
    {
        $volunteer = User::findOrFail($id);
        $can_update = Auth::user()->id == $id;
        return view('volunteer.show', compact('volunteer', 'can_update'));
    }

    /**
    * Edit volunteer profile.
    */
    public function edit($id)
    {
        if(Auth::user()->id == $id)
        {
            $volunteer = User::findorfail($id);
            $sentLocations = Location::all();
            /* getting all locations which assigned to this user */
            $checkedLocations = Auth::user()->locations()->get()->toArray();
            /* seprating the locations ids into separate array */
            $locationsIDS = [];
            foreach($checkedLocations as $userLocation){
                array_push($locationsIDS,$userLocation['id']);
            }
            return view('volunteer.edit' , compact('volunteer','sentLocations','locationsIDS'));
        }
        return redirect('/');
    }

    /**
    * Update volunteer profile.
    */
    public function update(VolunteerRequest $request, $id)
    {
        $this->volunteerService->update($request, $id);
        return redirect()->action('Volunteer\VolunteerController@show', [$id]);
    }

    /**
     * assign and unAssign user locations
     */
    public function assign_locations(Request $request){

        $input = $request->all();
        /* locations is array of all locations id which the user checked */
        if(Input::has('locations'))
        $checkedLocations = $input['locations'];
        else
            $checkedLocations = [];

        $userLocations = Auth::user()->locations()->get()->toArray();

        $locationsIDS = [];
        /* seprating locations id from the old userLocations list */
        foreach($userLocations as $userLocation){
            array_push($locationsIDS,$userLocation['id']);
        }
        /* check if the user unAssign location so we delete it from pivot table */
        foreach($locationsIDS as $unUpdatedLocation){
        /* check if there is a location id found in the non updated pivot table and not found in the updated check list */
            if(!in_array($unUpdatedLocation,$checkedLocations)){
                $newLocation = Auth::user()->locations()->findOrFail($unUpdatedLocation);
                $newLocation['pivot']->delete();
            }
        }

        /* check if the user Assign location so we delete it from pivot table */
        foreach($checkedLocations as $checkedLocation){
            if(!in_array($checkedLocation,$locationsIDS)) {
                $newLocation = Location::findOrFail($checkedLocation);
                Auth::user()->locations()->save($newLocation);
            }
        }
        return redirect('/');
    }

    /*1*
     * Show all new notifications for the authenticated user.
     */
    public function showNotifications()
    {
        $notifications = $this->volunteerService->showNotifications();
        return view('volunteer.notification.show', $notifications);
    }

    /**
     * Mark this notification as unread.
     */
    public function unreadNotification(Request $request)
    {
        $this->volunteerService->unreadNotification($request);
    }

    /**
     * Feedback Page.
     */
    public function createFeedback()
    {
      return view('feedback');
    }

    /**
     * Send feedback to the admin.
     */
    public function storeFeedback(Request $request)
    {
        $this->volunteerService->storeFeedback($request);
        return redirect('/');
    }

    /**
     * Show all my events
     */
    public function showAllEvents()
    {
        $user = Auth::user();
        $followedAndRegisteredEvents = $user->events()->get()->toArray();
        $subscribedOrganizationEvents = $user->interestingEvents($user->id)->get();
        $allEvents = array_merge($followedAndRegisteredEvents,$subscribedOrganizationEvents);
        usort($followedAndRegisteredEvents, array($this, "cmp"));
        usort($subscribedOrganizationEvents, array($this, "cmp"));
        usort($allEvents, array($this, "cmp"));
        return view('dashboard.events',compact('allEvents','followedAndRegisteredEvents','subscribedOrganizationEvents'));
    }
    /**
     * Shows the logged-in volunteer's dashboard
     * @return [view]           [the dashboard view]
     */
    public function showDashboard()
    {
        $offset  = 2;
        $id = Auth::user()->id;
        $events = Auth::user()->FilterInterestingEvents($id)->get();
        $posts  = Auth::user()->interestingPosts($id)->get();
        $data = array_merge($posts, $events);
        usort($data, array($this, "compare"));
        $size = count($data);
        return view('volunteer.dashboard' , compact('size','offset','data'));
    }

    /**
     * Comparator used for sorting events and posts
     * @param  [type] $record1 [first record in data array]
     * @param  [type] $record2 [second record in data array]
     * @return [type]          [signal]
     */
    public function compare($record1, $record2)
    {
         if ($record1->updated_at == $record2->updated_at)
             return 0;
         return ($record1->updated_at > $record2->updated_at) ? -1 : 1;
    }
}
