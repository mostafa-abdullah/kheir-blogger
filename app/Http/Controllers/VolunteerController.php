<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;

use App\User;
use App\Event;
use App\Challenge;
use App\Feedback;

use Carbon\Carbon;
use Auth;


class VolunteerController extends Controller
{
    public function __construct(){

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
        $volunteer = User::findorfail($id);
        $volunteer->update($request->all());
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
        $this->validate($request, [
            'subject' => 'required|max:60',
            'message' => 'required',
        ]);
        $feedback = new Feedback($request->all());
        $feedback->user_id = Auth::user()->id;
        $feedback->save();
        \Session::flash('flash_message','feedback successfully sent!');
        return redirect('/');
    }
    /**
     * [showDashboard  prepare the events and posts from database]
     * @return [view]           [thr view of the page]
     */
    public function showDashboard()
    {
      $id = Auth::user()->id;
      $events = Auth::user()->interestingEvents($id)->get();


      // $posts = Auth::user()->previousYearsChallenges()->latest('year')->get();
      return view('volunteer.dashboard' , compact('events'));
    }


}
