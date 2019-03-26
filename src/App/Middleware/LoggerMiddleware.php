<?php

namespace App\Middleware;

use Elasticsearch\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


class Authentication implements MiddlewareInterface
{
    protected $esClient;

    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $start = microtime(true);
        $response = $handler->handle($request);
        $end = microtime(true);

        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [
                // request and response
            ]
        ];
        $this->esClient->index($params);
    }
}
