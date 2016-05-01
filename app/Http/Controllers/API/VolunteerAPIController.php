<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\VolunteerService;

use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;

use App\User;

class VolunteerAPIController extends Controller
{
    private $volunteerService;

    public function __construct()
    {
        $this->volunteerService = new volunteerService();
        $this->middleware('auth_volunteer', ['only' => [
            'showNotifications', 'unreadNotification',
            'storeFeedback', 'update'
        ]]);
    }

    /**
     * Show volunteer profile.
     */
    public function show($id)
    {
    	$volunteer = User::findOrFail($id);
        $volunteer->organizationReviews = $volunteer->organizationReviews()->get();
        $volunteer->eventReviews = $volunteer->eventReviews()->get();
        $volunteer->subscribedOrganizations = $volunteer->subscribedOrganizations()->get();
        $volunteer->followedEvents = $volunteer->followedEvents()->get();
        $volunteer->registeredEvents = $volunteer->registeredEvents()->get();
    	return response()->json($volunteer);
    }

    /**
    * Update volunteer profile.
    */
    public function update(VolunteerRequest $request, $id)
    {
    	$this->volunteerService->update($request, $id);
        return response('Success.', 200);
    }

    /**
     * Show all new notifications for the authenticated user.
     */
    public function showNotifications()
    {
        return response()->json($this->volunteerService->showNotifications());
    }

    /**
     * Mark this notification as unread.
     */
    public function unreadNotification(Request $request)
    {
        $this->volunteerService->unreadNotification();
        return response('Success.', 200);
    }

    /**
     * Send feedback to the admin.
     */
    public function storeFeedback(Request $request)
    {
        $this->volunteerService->storeFeedback($request);
        return response('Success.', 200);
    }
}
