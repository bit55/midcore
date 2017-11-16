<?php

namespace Bit55\Midcore\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use Middleland\Dispatcher;

class ActionHandler implements MiddlewareInterface
{
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
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
        return $delegate->process($request);
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
