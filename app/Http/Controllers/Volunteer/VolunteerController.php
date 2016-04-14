<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Services\VolunteerService;

use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;
use App\User;

use Carbon\Carbon;
use Auth;


class VolunteerController extends Controller
{
    private $volunteerService;

    public function __construct()
    {
        $this->volunteerService = new volunteerService();
        $this->middleware('auth_volunteer', ['only' => [
            'showNotifications', 'unreadNotification',
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
            return view('volunteer.edit' , compact('volunteer'));
        }
        return redirect('/');
    }

    /**
    * Update volunteer profile.
    */
    public function update(VolunteerRequest $request, $id)
    {
        $this->volunteerService->update($request, $id);
        return redirect()->action('VolunteerController@show', [$id]);
    }

    /**
     * Show all new notifications for the authenticated user.
     */
    public function showNotifications()
    {
        $notifications = Auth::user()->notifications()->unread()->get();
        foreach($notifications as $notification)
        {
            $notification->pivot->read = 1;
            $notification->push();
        }
        return view('volunteer.notification.show', compact('notifications'));
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
     * [showDashboard  prepare the events and posts from database]
     * @return [view]           [thr view of the page]
     */
    public function showDashboard()
    {
        if(Auth::user()){
          $offset  = 2;
          $id = Auth::user()->id;
          // $attendedEvents =  Auth::user()->events;
          $events = Auth::user()->FilterInterestingEvents($id)->get();
          // $events = $events->diff($attendedEvents)->all();
          $posts  = Auth::user()->interestingPosts($id)->get();
          $data = array_merge($posts,$events);
          usort($data, array($this, "cmp"));
          $sz = count($data);

          return view('volunteer.dashboard' , compact('sz','offset','data'));
        }else
          return redirect('/login');


    }
    /**
     * [cmp comparing method for the sort]
     * @param  [type] $record1 [first record in data array]
     * @param  [type] $record2 [second record in data array]
     * @return [type]          [signal]
     */
    public function cmp($record1, $record2)
     {
         if ($record1->updated_at == $record2->updated_at) {
             return 0;
         }
         return ($record1->updated_at > $record2->updated_at) ? -1 : 1;
     }




}
