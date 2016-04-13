<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VolunteerRequest;

use App\User;

class VolunteerApiController extends Controller
{	
	/** 
    * Shows a user's personal info and their activities in relation to other entities
    */
    public function show($id)
    {
    	$volunteer = User::findOrFail($id);
        //Returns a plain json response based on the input array
    	return response()->json(['organizationReviews' => $volunteer->organizationReviews()->get(), 'eventReviews' => $volunteer->eventReviews()->get(), 'followedEvents' => $volunteer->followedEvents()->get(), 'registeredEvents' => $volunteer->registeredEvents()->get(), 'user' => $volunteer]);
    }

    /** 
    * Updates a user's profile
    */
    public function update(VolunteerRequest $request, $id)
    {
    	$volunteer = User::findorfail($id);
        $volunteer->update($request->all());
        return redirect()->action('VolunteerApiController@show', [$id]);
    }

    /**
    * Stores a user's feedback
    */
    public function store(VolunteerRequest $request, $id)
    {
        $volunteer = User::findorfail($id);
        $volunteer->update($request->all());
        return redirect()->action('VolunteerApiController@show', [$id]);
    }
}
	