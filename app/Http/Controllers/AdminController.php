<?php
namespace App\Http\Controllers;

use App\Http\Services\OrganizationService;
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

class AdminController  extends Controller
{

    private $organizationService;

    public function __construct()
    {
        $this->organizationService = new OrganizationService();
        $this->middleware('auth_admin', ['only' => ['assignValidator', 'viewDeletedOrganizations', 'restoreOrganization']]);
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
     * Admin show removed organizations
     */
    public function viewDeletedOrganizations()
    {
        $organizations =  Organization::onlyTrashed()->get();
        return view('admin.view-removed-organizations', compact('organizations'));
    }

    public function restoreOrganization($id)
    {
        $this->organizationService->restore($id);
        return redirect()->action('AdminController@viewDeletedOrganizations');
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
     * Validator can view organizations.
     */
    public function viewOrganizations()
    {
        $organizations = Organization::all();
        foreach ($organizations as $organization)
        {
          // get the number of subscribers for this organization.
          $organization->numberOfSubscribers = $organization->subscribers()->count();

          // get the number of events held by this organization.
          $organization->numberOfEvents = $organization->events()->count();

          //get the number of cancelled events by this organization.
          $organization->numberOfCancelledEvents = $organization->events()->withTrashed()->count();

          //get the rating of this organization.
          if($organization->rating)
              $organization->rating = number_format($organization->rating, 1);
          else
              $organization->rating = "-";

          // calculate the cancellation rate of this organization.
          $organization->cancellationRate = $organization->numberOfEvents - $organization->numberOfCancelledEvents;
        }
        return view('admin.view-organizations',compact('organizations'));

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
              $reported_event_review->viewed = count($reported_event_review->reportingUsers()->wherePivot('viewed', '1')->get());
              $reported_event_review->reporters = count($reported_event_review->reportingUsers()->get());
          }
          return view('admin.event-review-reports', compact('reported_event_reviews'));
      }

      /**
       * validator mark report to be viewed
       */
      public function setEventReviewReportViewed($id, $viewed)
      {
          $reports = EventReview::find($id)->reportingUsers()->wherePivot('viewed', (1^$viewed))->get();
          foreach($reports as $report)
          {
              $report->pivot->viewed = $viewed;
              $report->pivot->push();
          }
          return redirect()->action('AdminController@viewEventReviewReports');
      }

      public function viewFeedbacks()
      {
          $feedbacks = Feedback::latest()->get();
          return view('admin.feedback', compact('feedbacks'));
      }
}
