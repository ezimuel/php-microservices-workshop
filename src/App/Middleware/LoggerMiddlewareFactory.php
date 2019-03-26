<?php

namespace App\Middleware;

use Elasticsearch\Client;
use Interop\Container\ContainerInterface;

class LoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): LoggerMiddleware
    {
        return new LoggerMiddleware(
            $container->get(Client::class)
        );
    }
}
