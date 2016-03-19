<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Requests\EventPostRequest as EventPostRequest;
use App\EventPost as EventPost;

class EventPostController extends Controller
{
    public function createPost($id)
    {
    	return view('post.createPost')->with('id',$id);
    }

    public function storePost(EventPostRequest $request)
    {
    	$organization_id = auth()->guard('organization')->user()->id;
    	$eventPost = new EventPost;
    	echo($request->event_id);
    	$eventPost->title = $request->title;
    	$eventPost->description = $request->description;
    	$eventPost->event_id = $request->event_id;
    	$eventPost->organization_id = $organization_id;
    	$eventPost->save();

    }
}
