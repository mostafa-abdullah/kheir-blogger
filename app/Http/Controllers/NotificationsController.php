<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

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
	public function show()
    {
		$notifications = Auth::user()->notifications()->unseen()->get();

    	return $notifications;
    }
}
