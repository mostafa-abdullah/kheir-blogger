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

    	return response()->toJson(['organizationReviews' => $volunteer->organizationReviews()->get(), 'eventReviews' => $volunteer->eventReviews()->get(), 'followedEvents' => $volunteer->followedEvents()->get(), 'registeredEvents' => $volunteer->registeredEvents()->get(), 'user' => $volunteer]);
    }
}
	