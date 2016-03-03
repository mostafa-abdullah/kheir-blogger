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

    /**
    * edit to edit the profile of organization.
    *
    * @return view
    */
    public function edit($id){

      if(auth()->guard('organization')->check() && auth()->guard('organization')->id()==$id){
        $organization = Organization::findorfail($id);
        return view('organization.edit' , compact('organization'));
      }else{
        return redirect('login_organization');
      }
    }

    /**
    * update to update the profile of organization.
    *
    * @return redirect
    */
    public function update($id ,Requests\OrganizationRequest $request){

      $organization = Organization::findorfail($id);
      $organization->update($request->all());
      return redirect('organization/'.$id);
    }

    public function logout(){

        Auth::guard('organization')->logout();
        Auth::guard('user')->logout();
        return redirect('/');
    }
}
