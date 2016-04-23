<?php

namespace App\Providers;

use App\Elastic\Elastic;
use Elasticsearch\Client;
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
                return new Elastic(new Client());
            });
        }
}
