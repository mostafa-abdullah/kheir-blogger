<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Elastic\Elastic as Elasticsearch;
use Elasticsearch\ClientBuilder as elasticClientBuilder;

class ElasticSearchDeleteIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:delete {index name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an index from elastic search';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Elasticsearch(elasticClientBuilder::create()->build());
        $deleteParams = [
            'index' => $this->argument('index name')
        ];
        $response = $client->getClient()->indices()->delete($deleteParams);
        $this->info("Index deleted successfully.");
    }
}
