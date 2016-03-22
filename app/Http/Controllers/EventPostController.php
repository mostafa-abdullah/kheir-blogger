<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Requests\EventPostRequest as EventPostRequest;
use App\EventPost as EventPost;
use App\Notification as Notification;

class EventPostController extends Controller
{
	/*
	* Return view for creating Post.
	* 
	*/
    public function createPost($event_id)
    {
    	return view('post.createPost')->with('id',$event_id);
    }

    /* 
	* Add a new Post to the Event and Notify Users.
	* 
	*/
    public function storePost(EventPostRequest $request)
    {

       
    	$organization_id = auth()->guard('organization')->user()->id;
    	$eventPost = new EventPost;
    	$eventPost->title = $request->title;
    	$eventPost->description = $request->description;
    	$eventPost->event_id = $request->event_id;
    	$eventPost->organization_id = $organization_id;
    	$eventPost->save();
         if($request->sendnotifications == 1){
            $notf = new Notification;
            $notf->addNotification([1],$request->event_id,$request->description,"Hello");
         }
        return redirect('home');

    }
}
