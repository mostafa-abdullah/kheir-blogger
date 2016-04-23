<?php

namespace App\Http\Services;

use App\Http\Requests\RecommendationRequest;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizationRequest;
use App\Recommendation;
use App\Organization;

use Auth;

class OrganizationService
{

    public function update(OrganizationRequest $request , $id)
    {
        $organization = Organization::findorfail($id);
        $organization->update($request->all());
    }


    public function subscribe($id)
    {
        Auth::user()->subscribe($id);
    }


    public function unsubscribe($id)
    {
        Auth::user()->unsubscribe($id);
    }


    public function block($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        $organization->blockingVolunteers()->attach(Auth::user());
    }


    public function unblock($organization_id)
    {
        $organization = Organization::find($organization_id);
        $organization->blockingVolunteers()->detach(Auth::user());
    }


    public function storeRecommendation(RecommendationRequest $request, $id)
    {
        $recommendation = new Recommendation($request->all());
        $recommendation->user_id = Auth::user()->id;
        $organization = Organization::findOrFail($id);
        $organization->recommendations()->save($recommendation);
    }


    public function viewRecommendations($id)
    {
        $organization = Organization::findOrFail($id);
        $recommendations = $organization->recommendations()
            ->orderBy('created_at', 'desc')->get();
        return $recommendations;
    }
}