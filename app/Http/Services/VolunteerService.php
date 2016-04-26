<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;

use App\User;
use App\Event;
use App\Challenge;
use App\Feedback;
use App\Location;

use Carbon\Carbon;
use Auth;
use Validator;
use Input;

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

    public function assignLocations(Request $request)
    {

        $input = $request->all();

        if(Input::has('locations'))
            $newLocations = $input['locations'];
        else
            $newLocations = [];

        $volunteerLocations = Auth::user()->locations()->get()->toArray();
        $oldLocations = [];
        foreach($volunteerLocations as $volunteerLocation)
            array_push($oldLocations, $volunteerLocation['id']);

        foreach($oldLocations as $oldLocation)
            if(!in_array($oldLocation, $newLocations))
            {
                $deleteLocation = Auth::user()->locations()->findOrFail($oldLocation);
                $deleteLocation['pivot']->delete();
            }

        foreach($newLocations as $newLocation)
            if(!in_array($newLocation, $oldLocations))
                Auth::user()->locations()->save(Location::findOrFail($newLocation));

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
        Auth::user()->feedbacks()->save($feedback);
    }
}
