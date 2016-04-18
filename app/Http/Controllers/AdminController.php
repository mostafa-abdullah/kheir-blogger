<?php
namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;

use App\User;
use App\Event;
use App\Challenge;
use App\Feedback;

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
     * admin can view organizations.
     */
    public function adminViewOrganizations(){
      // only access to admin.
      if(Auth::User()->role == 8) {
        $organizations = Organization::all();
        foreach ($organizations as $organization) {
          // get the number of subscribers for this organization.
          $organization->numberOfSubscribers = $organization->subscribers()->count();

          // get the number of events held by this organization.
          $organization->numberOfEvents = $organization->events()->count();

          //get the number of cancelled events by this organization.
          $organization->numberOfCancelledEvents = $organization->events()->withTrashed()->count();

          //get the rate of this organization.
          if($organization->rate)
              $organization-> rate  = number_format($organization->rate, 1);
          else
              $organization->rate = "-";

          // calculate the cancellation rate of this organization.
          $organization->cancellationRate = $organization->numberOfEvents - $organization->numberOfCancelledEvents;
        }
        return view('volunteer.adminPanel.view-organizations',compact('organizations'));
      }
      else {
        return redirect('/');
      }
    }
}
