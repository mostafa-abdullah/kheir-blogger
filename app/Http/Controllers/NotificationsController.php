<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Auth;

class NotificationsController extends Controller
{
	public function __construct() 
	{
		$this->middleware('auth_both');
	}


    /**
     * show all notifications for the authenticated user.
     * @return string
     * @internal param $request
     */
	public function index()
    {
		$notifications = Auth::user()->notifications()->unread()->get();
        foreach($notifications as $notification)
        {
            $notification->pivot->read = 1;
            $notification->push();
        }

    	return view('notifications.show', compact('notifications'));
    }
}
