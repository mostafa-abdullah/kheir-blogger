<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;

use App\Http\Requests;
use App\Event;

use Validator;

class searchController extends Controller
{
    public function searchPage()
    {
        return view('search.query');
    }

    public function searchAll(Request $request)
    {
        // $satisfiedSearchOrganizations = $this->searchForOrganizations($request);
        $satisfiedSearchEvents = $this->searchForEvents($request);
        return compact('satisfiedSearchOrganizations', 'satisfiedSearchEvents');
    }

    /**
     *  Get a list of all events that have a substring in its name or description
     *  equal to searched criteria
     */
    public function searchForEvents(Request $request)
    {
        $validator = Validator::make($request->all(), ['searchText' => 'required']);

    	$client = new Elasticsearch(elasticClientBuilder::create()->build());
        $searchCriteria = $request->searchText;

		$parameters = [
            'index' => 'events',
            'type' => 'event',
	        'body'  => [
	            'query' =>[
                    'multi_match' => [
                        'query' => $searchCriteria,
                      	'fields' => ['name^3', 'description^2','location'],
                      	'fuzzy' => [
                          	'fuzziness' => 2,
                          	'prefix_length' => 0,
        					"max_expansions" => 100
                      	 ]
                    ]
	         	]
	   		]
        ];

        $satisfiedSearchEvents = $client->search($parameters);
        return $satisfiedSearchEvents;
    }

    /**
     *  Get a list of all organizations that have a substring in its name
     *  email, slogan, location, phone equal to searched criteria
     */
    public function searchForOrganizations(Request $request)
    {
        $validator = Validator::make($request->all(), ['searchText' => 'required']);

        $searchCriteria = $request->searchText;
        $client = new Elasticsearch(elasticClientBuilder::create()->build());

        $parameters = [
		    'index' => 'organizations',
			'type' => 'organization',
			'body' => [
			    'query'=>[
                    'multi_match' => [
                      	'query' => $searchCriteria,
                      	'fields' => ['name^3', 'email^2', 'slogan',
                                    'location', 'phone'],
                      	'fuzzy' => [
	                        'fuzziness' => 2,
	                        'prefix_length' => 0,
	            			'max_expansions' => 100
                        ]
                    ]
			    ]
		    ]
        ];
        $satisfiedSearchOrganizations = $client->search($parameters);
        return $satisfiedSearchOrganizations;
    }
}
