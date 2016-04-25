<?php

namespace App\Http\Services;

use App\Http\Requests\RecommendationRequest;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\RegisterOrganizationRequest;

use App\Recommendation;
use App\Organization;

use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;

use Auth;

class OrganizationService
{

    /**
     * Store a new organization in the database
     */
    public function store(RegisterOrganizationRequest $request)
    {
        $organization = new Organization;
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->password = bcrypt($request->password);
        $organization->save();

        $this->indexOrganization($organization);

        return $organization;
    }

    /**
     *  update organization information
     */
    public function update(OrganizationRequest $request , $id)
    {
        $organization = Organization::findorfail($id);
        $organization->update($request->all());

        $this->indexOrganization($organization);
    }

    /**
     * Delete an organization
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        $organization->delete();

        $this->unindexOrganization($id);
    }
    /**
     *  volunteer subscribe to a certain organization
     */
    public function subscribe($id)
    {
        Auth::user()->subscribe($id);
    }

    /**
     *  volunteer unsubscribe to a certain organization
     */
    public function unsubscribe($id)
    {
        Auth::user()->unsubscribe($id);
    }

    /**
     * volunteer block an organization
     */
    public function block($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        $organization->blockingVolunteers()->attach(Auth::user());
    }

    /**
     * volunteer unblock an organization
     */
    public function unblock($organization_id)
    {
        $organization = Organization::find($organization_id);
        $organization->blockingVolunteers()->detach(Auth::user());
    }

    /**
     *  store a recommendation into the database
     */
    public function storeRecommendation(RecommendationRequest $request, $id)
    {
        $recommendation = new Recommendation($request->all());
        $recommendation->user_id = Auth::user()->id;
        $organization = Organization::findOrFail($id);
        $organization->recommendations()->save($recommendation);
    }

    /**
     *  view all recommendations sent to the organization
     */
    public function viewRecommendations($id)
    {
        if(auth()->guard('organization')->id() == $id)
        {
            $organization = Organization::findOrFail($id);
            $recommendations = $organization->recommendations()
                ->orderBy('created_at', 'desc')->get();
            return $recommendations;

        }
        return null;
    }

    /**
     * Insert/Update organization in Elasticsearch server.
     */
    public function indexOrganization($organization)
    {
        $client = new Elasticsearch(elasticClientBuilder::create()->build());

        $parameters = [
          'index' => 'organizations',
          'type'  => 'organization',
          'id'    => $organization->id,
          'body'  => [
                        'name'     => $organization->name,
                        'email'    => $organization->email,
                        'slogan'   => $organization->slogan,
                        'location' => $organization->location,
                        'phone'    => $organization->phone
                     ]
        ];

        try
        {
            $client->index($parameters);
        }
        catch(Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e)
        {
            echo "Error";
            $last = $elastic->transport->getLastConnection()->getLastRequestInfo();
            $last['response']['error'] = [];
            dd($last);
        }
    }

    /**
     * Delete organization from Elasticsearch server
     */
    public function unindexOrganization($id)
    {
        $client = new Elasticsearch(elasticClientBuilder::create()->build());

        $params = [
            'index' => 'organizations',
            'type' => 'organization',
            'id' => $id
        ];

        $client->delete($params);
    }

}
