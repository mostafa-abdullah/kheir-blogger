<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Event;

class searchController extends Controller
{
   
      // requiring Elsaticsearch class and store it into $elastic variable
    protected $elastic = $this->app->make(App\Elastic\Elastic::class);

    /**
     *  get json list of all events that have a substring in its name or description equal to searched criteria 
     */
    public function searchForEvents($searchCriteria)
    {
         /**
          * the search can match event's name and/or description and/or location
          */
				$parameters = [
			    'index' => 'events',
			    'type' => 'event',
			    'body' => [
			          'query'=>[
                      	   'bool'=>[
                              'match'=>['name'=>$searchCriteria],
                              'match'=>['description'=>$searchCriteria],
                              'match'=>['location'=>$searchCriteria]

                      	   	]
			         	 ]	
			   		 ],
			   	'fuzziness' => 'AUTO',	 //Allowing for misspellings
                'fields' => ['name^3', 'description^2','location'],  // setting periorties to fields 
                ];
             $satisfiedSearchEvents =  $elastic->search($parameters);
             
             return $satisfiedSearchEvents;
    }
}
