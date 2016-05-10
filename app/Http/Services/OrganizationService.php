<?php

namespace App\Http\Services;
use App\Http\Services\EventService;

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
     * Store a new organization in the database.
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
     *  update organization information.
     *  @param int $id organization id
     */
    public function update(OrganizationRequest $request , $id)
    {
        $organization = Organization::findorfail($id);
        $organization->update($request->all());

        $this->indexOrganization($organization);
    }

    /**
     * Delete an organization.
     * @param int $id organization id
     */
    public function destroy($id)
    {
        $eventService = new EventService();
        $organization = Organization::find($id);

        $eventService->unindexOrganizationEvents($organization);
        $organization->delete();
        $this->unindexOrganization($id);
    }
    /**
     * Volunteer subscribe to a certain organization.
     * @param int $id organization id
     */
    public function subscribe($id, $volunteer)
    {
        $volunteer->subscribe($id);
    }

    /**
     * Volunteer unsubscribe to a certain organization.
     * @param int $id organization id
     */
    public function unsubscribe($id, $volunteer)
    {
        $volunteer->unsubscribe($id);
    }

    /**
     * Volunteer block an organization.
     * @param int $id organization id
     */
    public function block($organization_id, $volunteer)
    {
        $organization = Organization::findOrFail($organization_id);
        $organization->blockingVolunteers()->attach($volunteer);
    }

    /**
     * Volunteer unblock an organization.
     * @param int $id organization id
     */
    public function unblock($organization_id, $volunteer)
    {
        $organization = Organization::find($organization_id);
        $organization->blockingVolunteers()->detach($volunteer);
    }

    /**
     * Store a recommendation into the database
     * @param int $id organization id
     */
    public function storeRecommendation(RecommendationRequest $request, $id)
    {
        $recommendation = new Recommendation($request->all());
        $recommendation->user_id = $request->get('volunteer')->id;
        $organization = Organization::findOrFail($id);
        $organization->recommendations()->save($recommendation);
    }

    /**
     * View all recommendations sent to the organization.
     * @param int $id organization id
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
     * Delete organization from Elasticsearch server.
     * @param int $id organization id
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
