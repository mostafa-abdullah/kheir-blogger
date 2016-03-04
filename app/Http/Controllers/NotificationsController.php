<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class NotificationsController extends Controller
{
	public function __construct() 
	{
		$this->middleware('auth_both');
	}


    public function show()
    {
    	return 'NotificationsController';
    }
}
