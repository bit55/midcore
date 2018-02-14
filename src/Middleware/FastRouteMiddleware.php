<?php

namespace Bit55\Midcore\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;

class FastRouteMiddleware implements MiddlewareInterface
{
    private $routesConfig;

    public function __construct($routesConfig)
    {
        $this->routesConfig = $routesConfig;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Process routes
        $dispatcher = \FastRoute\simpleDispatcher(
            function (\FastRoute\RouteCollector $route) {
                include $this->routesConfig;
            }
        );

        // Dispatch request
        $method = strtoupper($request->getMethod());

        $routeInfo = $dispatcher->dispatch($method, $request->getUri()->getPath());

        $request = $request->withAttribute('routeResult', $routeInfo);

        return $handler->handle($request);
    }
}
