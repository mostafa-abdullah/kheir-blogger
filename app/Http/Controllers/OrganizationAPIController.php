<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

use App\Http\Requests;

class OrganizationAPIController extends Controller
{

    /**
     *  get json list of all organizations
     */
    public function showList()
    {
        $organizations = Organization::all();
        return response()->json($organizations);
    }

}
