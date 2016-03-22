<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Request;
use App\Feedback;
use Illuminate\Http\Request as Req;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth_both');

    }

    public static function notify(){

        $array = [
            Auth::user()
        ];

        \App\Notification::notify($array, \App\Event::find(1), 'blaba', 'xxx');
    }


    /*
    *show the sendFeedback page
    */
    public function sendFeedback()
    {

      return view('sendFeedback');
    }

    public function storeFeedback(Req $request)
    {
      $input = Request::all();
      $this->validate($request, [
       'subject' => 'required|max:60',
       'message' => 'required|max:255',
   ]);
      $feedback = new Feedback($input);
      $feedback->user_id = Auth::user()->id;
      $feedback->save();
      \Session::flash('flash_message','feedback successfully sent!');
      return redirect('home');
    }
}
