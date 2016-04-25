<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Services\VolunteerService;

use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;

use App\User;
use App\Location;

use Carbon\Carbon;
use Auth;
use Input;


class VolunteerController extends Controller
{
    private $volunteerService;

    public function __construct()
    {
        $this->volunteerService = new volunteerService();
        $this->middleware('auth_volunteer', ['only' => [
            'showNotifications', 'unreadNotification', 'showDashboard',
            'createFeedback', 'storeFeedback', 'edit', 'update', 'assignLocations'
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
            $checkedLocations = Auth::user()->locations()->get()->toArray();
            $locationsIDS = [];
            foreach($checkedLocations as $userLocation)
                array_push($locationsIDS,$userLocation['id']);
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
     * assign and unAssign volunteer locations
     */
    public function assignLocations(Request $request)
    {
        $this->volunteerService->assignLocations($request);
        return redirect()->action('Volunteer\VolunteerController@show', [Auth::user()->id]);
    }

    /**
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
