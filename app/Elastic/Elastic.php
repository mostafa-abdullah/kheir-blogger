<?php
namespace App\Elastic;
use Elasticsearch\Client;
class Elastic
{
    protected $client;
    public function __construct(Client $client)
    {   
        $this->client = $client;

    }

    /**
     * Index a single item
     */

    public function index(array $parameters)
    {
        echo "in index function";
       $result =  $this->client->index($parameters);
        
       return $result;
    }

    /**
     * Delete a single item
     */
    public function delete(array $parameters)
    {
        return $this->client->delete($parameters);
    }
    
    /**
     * update a single item
     */
   
   public function updated(array $parameters)
    {
        $this->elasticsearch->index($parameters);
    }
    
    /**
     * search for items that satisfy a specific criteria 
     */
    public function search(array $parameters)
    {
        return $this->client->search($parameters);
    }

    /**
     * get function to return client attribute of this class
     */
    public function getClient()
    {
        return $this->client;
    }
}