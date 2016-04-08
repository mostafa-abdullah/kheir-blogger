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

  public function adminViewOrganizations(){
    $organization = Organization::all();
    return view('admin.organizations',compact('organization'));
  }
}
