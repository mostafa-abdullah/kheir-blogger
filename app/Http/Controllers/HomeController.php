<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_both');
    }

    /*
    *show the sendFeedback page
    */
    public function sendFeedback()
    {
      return view('feedback');
    }

    public function storeFeedback(Req $request)
    {
        $input = Request::all();
        $this->validate($request, [
            'subject' => 'required|max:60',
            'message' => 'required',
        ]);
      $feedback = new Feedback($input);
      $feedback->user_id = Auth::user()->id;
      $feedback->save();
      \Session::flash('flash_message','feedback successfully sent!');
      return redirect('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
