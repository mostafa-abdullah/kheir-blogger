<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\Http\Requests;

class VolunteerProfileController extends Controller
{
    public function show($id)
    {

        $volunteer = User::findOrFail($id);
        return view('volunteer.show', compact('volunteer'));
    }
}
