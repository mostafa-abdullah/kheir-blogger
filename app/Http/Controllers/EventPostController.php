<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EventPostRequest as EventPostRequest;

class EventPostController extends Controller
{
    public function createPost()
    {
    	return view('post.createPost',compact($id));
    }

    public function storePost(EventPostRequest $request)
    {
    	echo $request->get('title');
    	echo $request->get('description');

    }
}
