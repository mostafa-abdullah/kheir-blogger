<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Organization;

class LoginController extends Controller
{
//    public function userLogin(){
//        $input = Input::all();
//        if(count($input) > 0){
//            $auth = auth()->guard('user');
//
//            $credentials = [
//                'email' =>  $input['email'],
//                'password' =>  $input['password'],
//            ];
//
//            if ($auth->attempt($credentials)) {
//                $user = User::where('email','=',$input['email'])->first();
//                Auth::login($user);
//                return redirect('/home');
//            } else {
//                echo 'Error';
//            }
//        } else {
//            return view('auth.login');
//        }
//    }

    public function organizationLogin(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        $input = Input::all();
        if(count($input) > 0){
            $auth = auth()->guard('organization');

            $credentials = [
                'email' =>  $input['email'],
                'password' =>  $input['password'],
            ];


            if ($auth->attempt($credentials)) {
                $organization = Organization::where('email','=',$input['email'])->first();
                auth()->guard('organization')->login($organization);
                return redirect('/home');
            } else {
                return redirect('/login_organization')->withErrors(['Login'=>'These credentials do not match our records.']);
            }
        } else {
            return redirect('/login_organization');
        }
    }

    public function profile(){
        if(auth()->guard('admin')->check()){
            pr(auth()->guard('admin')->user()->toArray());
        }
        if(auth()->guard('user')->check()){
            pr(auth()->guard('user')->user()->toArray());
        }
    }
}
