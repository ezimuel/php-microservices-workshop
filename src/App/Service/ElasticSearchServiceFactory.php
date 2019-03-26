<?php
declare(strict_types=1);

namespace App\Service;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Interop\Container\ContainerInterface;

class ElasticSearchServiceFactory
{
    public function __invoke(ContainerInterface $container): Client
    {
        $config = $container->get('config');
        $hosts = $config['elasticsearch']['hosts'] ?? ['localhost:9200'];

        return ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }
}
