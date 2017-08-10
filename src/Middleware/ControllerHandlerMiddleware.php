<?php

namespace Bit55\Midcore\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;

use Zend\Diactoros\Response\HtmlResponse;

class ControllerHandlerMiddleware implements MiddlewareInterface
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
     * @param string|callable $handler
     * @param array $vars
     */
    public function executeHandler($request, $handler, $vars = null)
    {
        // execute action in controllers
        if (!is_array($handler) && !is_callable($handler) && strpos($handler, '@')) {
            $ca = explode('@', $handler);
            $controllerName = $ca[0];
            $action = $ca[1];
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName($request, $this->container);
            } else {
                throw new \Exception("Controller class '{$controllerName}' not found");
            }
            
            if (!method_exists($controller, $action)) {
                throw new \Exception("Method '{$controllerName}::{$action}' not defined");
            }
            return call_user_func_array(array($controller, $action), $vars);
            
            // $reflectionMethod = new ReflectionMethod('HelloWorld', 'sayHelloTo');
            // echo $reflectionMethod->invokeArgs(new HelloWorld(), array('Mike'));
        }
    }
}
