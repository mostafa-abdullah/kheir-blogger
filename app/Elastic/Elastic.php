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
        return $this->client->index($parameters);
    }

    /**
     * Delete a single item
     */
    public function delete(array $parameters)
    {
        return $this->client->delete($parameters);
    }

    /**
     * Update a single item
     */
    public function update(array $parameters)
    {
        $this->elasticsearch->index($parameters);
    }

    /**
     * Search for items that satisfy a specific criteria
     */
    public function search(array $parameters)
    {
        return $this->client->search($parameters);
    }

    /**
     * Get client attribute of this class
     */
    public function getClient()
    {
        return $this->client;
    }
}
