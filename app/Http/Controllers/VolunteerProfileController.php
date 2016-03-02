<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\Http\Requests;

class VolunteerProfileController extends Controller
{
    public function show($id)
    {
        return User::show($id);
    }
}
