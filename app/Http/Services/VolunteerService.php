<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;

use App\User;
use App\Event;
use App\Challenge;
use App\Feedback;

use Carbon\Carbon;
use Auth;
use Validator;

class VolunteerService
{
    /**
    * Update volunteer profile.
    */
    public function update(VolunteerRequest $request, $id)
    {
    	$volunteer = User::findorfail($id);
        $volunteer->update($request->all());
    }


    /**
     * Show all new notifications for the authenticated user.
     */
    public function showNotifications()
    {
        $oldNotifications = Auth::user()->notifications()->read()->get();
        $newNotifications = Auth::user()->notifications()->unread()->get();
        foreach($newNotifications as $notification)
        {
            $notification->pivot->read = 1;
            $notification->push();
        }
        return compact('oldNotifications', 'newNotifications');
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
     * Send feedback to the admin.
     */
    public function storeFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|max:60',
            'message' => 'required',
        ]);
        $feedback = new Feedback($request->all());
        $feedback->user_id = Auth::user()->id;
        $feedback->save();
    }
}
