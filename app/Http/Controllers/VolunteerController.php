<?php

namespace App\Http\Controllers;

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
}
