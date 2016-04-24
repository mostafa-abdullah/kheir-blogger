<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Event;
use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;
class searchController extends Controller
{
   
      // requiring Elsaticsearch class and store it into $elastic variable
    // protected  $client = elasticClientBuilder::create()->build();
     
    public function loadSearchPage(){

    return view('Search');
    }

    /**
     *  get json list of all events that have a substring in its name or description equal to searched criteria 
     */
    public function searchForEvents(Request $request)
    {   
         /**
          * intializing a new instanse of elastic.php class
          */

    	$client = new Elasticsearch(elasticClientBuilder::create()->build());

         /**
          * getting searched criteria from the request
          */
           
           $searchCriteria = $request->txtSearch;

        /**
         * the search can match event's name and/or description and/or location 
         */
				$parameters = [
			    'index' => 'events',
			    'type' => 'event',
			    'body' => [
			          'query'=>[
                      	   
                              'multi_match' => [
                              	'query' => $searchCriteria,
                              	'fields' => ['name^3', 'description^2','location'],   

                              	'fuzzy' => [
	                              	'fuzziness' => 2,
	                              	'prefix_length' => 0,
	            					"max_expansions" => 100
                              	]

                              ],

                              

                      	   	
			         	 ]	
			   		 ]
                ];
         /**
          * calling search function of elastic.php class and returning the value
          */
             $satisfiedSearchEvents =  $client->search($parameters);
             //dd($satisfiedSearchEvents);
             return $satisfiedSearchEvents;
    }

        public function searchForOrganizations(Request $request)
    {
       	/**
         * getting searched criteria from the request
         */
        $searchCriteria = $request->txtSearch;

         /**
          * intializing a new instanse of elastic.php class
          */
         $client = new Elasticsearch(elasticClientBuilder::create()->build());

         /**
          * the search can match organization's name and/or email and/or location and/or rate and/or phone
          */    $parameters = [
			    'index' => 'organizations',
			    'type' => 'organization',
			    'body' => [
			          'query'=>[
                      	   
                              'multi_match' => [
                              	'query' => $searchCriteria,
                              	'fields' => ['name^3', 'email^2','location','rate','phone'],  
                              	'fuzzy' => [
	                              	'fuzziness' => 2,
	                              	'prefix_length' => 0,
	            					"max_expansions" => 100
                              	]

                              ]
			         	 ]	
			   		 ]
                ];

		 /**
          * calling search function of elastic.php class and returning the value
          */
             $satisfiedSearchOrganizations=  $client->search($parameters);
             
             return $satisfiedSearchOrganizations;
    }


	public function searchAll(Request $request){
	  $satisfiedSearchOrganizations = $this->searchForOrganizations($request);
	  $satisfiedSearchEvents = $this->searchForEvents($request);
	
	   $results = array(
	   					"satisfiedSearchOrganizations" => $satisfiedSearchOrganizations,
	   					"satisfiedSearchEvents"=>$satisfiedSearchEvents
	   				);

  	   print_r($results['satisfiedSearchEvents']['hits']['total']);
	   print_r("<br><br>");
	   print_r($results['satisfiedSearchOrganizations']['hits']['total']);
	 //	 return $result;
	}


}
