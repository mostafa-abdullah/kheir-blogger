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

    /**
     * admin can assign or unAssign validators.
     */
    public function adminAssignValidator($id){
        $volunteer = User::findorfail($id);
        if($volunteer->role == 5)
            $volunteer->role = 1 ;
        else
            $volunteer->role = 5 ;

        $volunteer->save();
        return redirect()->action('VolunteerController@show', [$id]);
    }

    /**
     * admin can view organizations.
     */
    public function adminViewOrganizations(){
      $organizations = Organization::all();
      foreach ($organizations as $organization) {
        $organization->numberOfSubscribers = $organization->subscribers()->count();
        $organization->numberOfEvents = $organization->events()->count();
      }
      return view('volunteer.adminPanel.view-organizations',compact('organizations'));
    }
}
