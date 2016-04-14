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
