<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class EventPostController extends Controller
{
    public function createPost()
    {
    	return view('post.createPost');
    }

    public function storePost()
    {
    	
    }
}
