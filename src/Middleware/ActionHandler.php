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
        if ($routeInfo[0] == 1 && strpos($routeInfo[1], '@')===false) { // FOUND
            
            $response = $this->executeHandler($request, $routeInfo[1], $routeInfo[2]);
            
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
     * @param array $vars
     */
    public function executeHandler($request, $handler, $vars = null)
    {
        $request = $request->withAttribute('routeParams', $vars);
        
        // execute actions as middleware
        if (!is_array($handler) || is_callable($handler)) {
            $handler = [$handler];
        }
        $dispatcher = new Dispatcher($handler, $this->container);
        
        return $dispatcher->dispatch($request);
    }
}
