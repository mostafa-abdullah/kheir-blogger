<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\RegisterOrganizationRequest;
use App\Organization;
use Auth;
use Hash;


class OrganizationController extends Controller
{
    public function register(RegisterOrganizationRequest $request){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        $organization = new Organization;
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->password = bcrypt($request->password);
        $organization->save();
        auth()->guard('organization')->login($organization);
        return redirect('home');
    }

    /**
     * edit to edit the profile of organization.
     *
     * @param $id
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
    * show to show the profile of organization.
    *
    * @return view
    */
    public function show($id){
      return "The profile";
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
