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

    /**
     * Constructor.
     * Sets middlewares for controller functions and initializes volunteer service instance.
     */
    public function __construct()
    {
        $this->volunteerService = new volunteerService();
        $this->middleware('auth_volunteer', ['only' => [
            'showNotifications', 'unreadNotification',
            'storeFeedback', 'update'
        ]]);
    }

    /**
     * Volunteer's profile. All volunteer's reviews, subscribed organizations
     * and followed and registered events are encapsulated within the response.
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
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * Show all notifications for the authenticated volunteer.
     */
    public function showNotifications(Request $request)
    {
        return response()->json($this->volunteerService->showNotifications($request->get('volunteer')));
    }

    /**
     * Mark notification as unread.
     */
    public function unreadNotification(Request $request)
    {
        $this->volunteerService->unreadNotification();
        return response()->json(['message' => 'Success.'], 200);
    }

    /**
     * Send feedback to the admin.
     */
    public function storeFeedback(Request $request)
    {
        $this->volunteerService->storeFeedback($request);
        return response()->json(['message' => 'Success.'], 200);
    }
}
