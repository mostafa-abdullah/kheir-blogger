<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Input;

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

    /**
     * Mark this notification as unread.
     * @param null $notification_id
     * @return string
     */
    public function handle($notification_id = null)
    {
        $notification = Auth::user()->notifications()->findOrFail($notification_id);
        $notification->pivot->read = 0;
        $notification->push();
        return "success";
    }
}
