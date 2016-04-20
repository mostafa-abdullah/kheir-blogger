<?php
namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;

use App\User;
use App\Event;
use App\Challenge;
use App\Feedback;
use App\EventReview;
use Carbon\Carbon;
use Auth;

class AdminController  extends Controller{

    public function __construct()
    {
        $this->middleware('auth_admin', ['only' => ['assignValidator']]);
        $this->middleware('auth_validator');
    }

    /**
     * Admin can assign or unAssign validators.
     */
    public function assignValidator($id)
    {
        $volunteer = User::findorfail($id);
        if($volunteer->role == 5)
            $volunteer->role = 1 ;
        else
            $volunteer->role = 5 ;
        $volunteer->save();
        return redirect()->action('Volunteer\VolunteerController@show', [$id]);
    }

    /**
     * Validator can ban or unban volunteers.
     */
     public function banVolunteer($id)
     {
        $volunteer = User::findorfail($id);
        if($volunteer->role == 1)
            $volunteer->role = 0;
        else if($volunteer->role == 0)
            $volunteer->role = 1;
        $volunteer->save();
        return redirect()->action('Volunteer\VolunteerController@show', [$id]);
    }

    /**
     * Validator can view reports on event reviews.
     */
    public function viewEventReviewReports()
    {
        $reported_event_reviews = EventReview::has('reportingUsers')->get();

        foreach($reported_event_reviews as $reported_event_review)
        {
            $reported_event_review->event = Event::find($reported_event_review->event_id);
            $reported_event_review->volunteer = User::find($reported_event_review->user_id);
        }
        return view('admin.event-review-reports', compact('reported_event_reviews'));
    }

    /**
     * validator mark report to be viewed
     */
    public function toggleEventReviewReportViewed($id)
    {
        $report = EventReview::findOrFail($id);
        $report->viewed = 1 ^ $report->viewed;
        $report->save();
        return redirect()->action('AdminController@viewEventReviewReports');
    }
}
