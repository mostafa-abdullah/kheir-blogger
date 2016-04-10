<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class VolunteerApiController extends Controller
{	
	
    public function show($id)
    {
    	$volunteer = User::findOrFail($id);

    	return response()->toJson(['organizationReviews' => $volunteer->organizationReviews(), 'eventReviews' => $volunteer->eventReviews(), 'followedEvents' => $volunteer->followedEvents(), 'registeredEvents' => $volunteer->registeredEvents()]);
    }
}
