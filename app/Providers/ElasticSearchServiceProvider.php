<?php

namespace App\Providers;

use App\Elastic\Elastic;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{       


         /**
          * bind dependencies in a Service Provider
          */
         
        public function register()
        {
            $this->app->singleton(Elastic::class, function()
            {    
                $hosts = ['http://127.0.0.1:9200'];
                return new Elastic(
                                        ClientBuilder::create()
                                        ->setLogger(ClientBuilder::defaultLogger(storage_path('logs/elastic.log')))
                                        ->setHosts($hosts)
                                        ->build()
                                 );
            });
        }
}
