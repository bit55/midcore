<?php

namespace Bit55\Midcore\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use Middleland\Dispatcher;

class RouteActionHandler implements MiddlewareInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        $routeInfo = $request->getAttribute('routeResult');

        // Check found
        if ($routeInfo[0] == 1) { // FOUND
            $request = $request->withAttribute('routeParams', $routeInfo[2]);
            $response = $this->executeHandler($request, $routeInfo[1]);

            if ($response instanceof ResponseInterface) {
                return $response;
            }
        }

        // dump($routeInfo); exit;
        return $handler->handle($request);
    }

    /**
     * Executing application action.
     *
     * @param string|callable|array $handler
     */
    public function executeHandler($request, $handler)
    {
        // execute actions as middleware
        if (!is_array($handler) || is_callable($handler)) {
            $handler = [$handler, \Bit55\Midcore\Middleware\NotFoundHandler::class];
        }
        $dispatcher = new Dispatcher($handler, $this->container);

        return $dispatcher->dispatch($request);
    }
}
