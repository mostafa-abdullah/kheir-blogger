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
        $volunteer->update($request->except('birth_date'));
        if($request->has('birth_date'))
        {
            $volunteer->birth_date = $request->get('birth_date');
            $volunteer->save();
        }
    }

    public function assignLocations(Request $request)
    {

        $input = $request->all();

        if(Input::has('locations'))
            $newLocations = $input['locations'];
        else
            $newLocations = [];

        $volunteerLocations = $request->get('volunteer')->locations()->get()->toArray();
        $oldLocations = [];
        foreach($volunteerLocations as $volunteerLocation)
            array_push($oldLocations, $volunteerLocation['id']);

        foreach($oldLocations as $oldLocation)
            if(!in_array($oldLocation, $newLocations))
            {
                $deleteLocation = $request->get('volunteer')->locations()->findOrFail($oldLocation);
                $deleteLocation['pivot']->delete();
            }

        foreach($newLocations as $newLocation)
            if(!in_array($newLocation, $oldLocations))
                $request->get('volunteer')->locations()->save(Location::findOrFail($newLocation));

    }

    /**
     * Show all new notifications for the authenticated user.
     */
    public function showNotifications($volunteer)
    {
        $oldNotifications = $volunteer->notifications()->read()->get();
        $newNotifications = $volunteer->notifications()->unread()->get();
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
        $notification = $request->get('volunteer')->notifications()->findOrFail($request['notification_id']);
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
        $request->get('volunteer')->feedbacks()->save($feedback);
    }
}
