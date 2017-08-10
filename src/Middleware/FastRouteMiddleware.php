<?php

namespace Bit55\Midcore\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;

class FastRouteMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        // Process routes
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $route) {
            require 'config/routes.php';
        });

        // Dispatch request
        $method = strtoupper($request->getMethod());
        
        $routeInfo = $dispatcher->dispatch($method, $request->getUri()->getPath());
        
        $request = $request->withAttribute('routeResult', $routeInfo);

        return $delegate->process($request);
    }
}
