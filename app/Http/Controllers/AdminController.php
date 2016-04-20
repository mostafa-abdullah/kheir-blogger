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
use App\EventReviewReport;
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
        $event_reviews_reports = EventReviewReport::all();
        /*for each report get its event and review to pass them to the view */
        foreach($event_reviews_reports as $event_reviews_report)
        {
            $event_review = EventReview::find($event_reviews_report->review_id);
            if($event_review)
            {
                $event_reviews_report->event = Event::find($event_review->event_id);
                $event_reviews_report->volunteer = User::find($event_review->user_id);
            }
        }
        return view('admin.event-review-reports',compact('event_reviews_reports'));
    }

    /**
     * validator mark report to be viewed
     */
    public function toggleEventReviewReportViewed($id)
    {
        $report = EventReviewReport::findOrFail($id);
        $report->viewed = 1 ^ $report->viewed;
        $report->save();
        return redirect()->action('AdminController@viewEventReviewReports');
    }
}
