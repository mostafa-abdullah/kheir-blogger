<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VolunteerRequest;

use App\User;

class VolunteerApiController extends Controller
{	
	
    public function show($id)
    {
    	$volunteer = User::findOrFail($id);

    	return response()->json(['organizationReviews' => $volunteer->organizationReviews()->get(), 'eventReviews' => $volunteer->eventReviews()->get(), 'followedEvents' => $volunteer->followedEvents()->get(), 'registeredEvents' => $volunteer->registeredEvents()->get(), 'user' => $volunteer]);
    }

    public function update(VolunteerRequest $request, $id)
    {
    	$volunteer = User::findorfail($id);
        $volunteer->update($request->all());
        return redirect()->action('VolunteerApiController@show', [$id]);
    }

    public function store(VolunteerRequest $request, $id)
    {
        $volunteer = User::findorfail($id);
        $volunteer->update($request->all());
        return redirect()->action('VolunteerApiController@show', [$id]);
    }
}
	