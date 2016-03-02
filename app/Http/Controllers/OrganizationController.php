<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Organization;
use Hash;
use Auth;

class OrganizationController extends Controller
{
    public function register(Requests\RegisterOrganizationRequest $request){

        $organization = new Organization;
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->password = bcrypt($request->password);
        $organization->save();
    }

    public function edit(){
      if(Auth::user() || auth()->guard('organization')->check()){
        $id = auth()->guard('organization')->id();
        $information = Organization::findorfail($id);
        return view('organization.edit');
      }else{
        return redirect('login_organization');
      }
    }

    public function logout(){

        Auth::guard('organization')->logout();
        Auth::guard('user')->logout();
        return redirect('/');
    }
}
