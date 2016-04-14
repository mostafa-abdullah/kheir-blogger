<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Organization;
use Illuminate\Http\Request;

use App\Http\Requests;

class OrganizationAPIController extends Controller
{

    /**
     *  get json list of all organizations
     */
    public function index()
    {
        $organizations = Organization::all();
        return $organizations;
    }


    /**
     *  show a json of an organization and all its events, reviews and subscribers
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->events = $organization->events()->get();
        $organization->reviews = $organization->reviews()->get();
        $organization->subscribers = $organization->subscribers()->get();
        return $organization;
    }

}
