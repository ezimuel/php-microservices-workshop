<?php

namespace App\Middleware;

use Elasticsearch\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


class LoggerMiddleware implements MiddlewareInterface
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
            'index' => sprintf("log-%d-%d", date("m"), date("Y")),
            'type' => 'log',
            'body' => [
                'ip_address' => $request->getAttribute('ip_address'),
                'date' => date("c", time()),
                'method' => $request->getMethod(),
                'url' => $request->getUri()->getPath(),
                'status' => $response->getStatusCode(),
                'size' => mb_strlen((string) $response->getBody(), '8bit'),
                'execution' => sprintf("%.2f ms", ($end - $start) * 1000)
              ]   
        ];
        $this->esClient->index($params);
        return $response;
    }
}
