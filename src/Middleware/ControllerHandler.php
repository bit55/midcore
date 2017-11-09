<?php

namespace Bit55\Midcore\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use LogicException;
use Exception;
use Closure;

use Zend\Diactoros\Response\HtmlResponse;

class ControllerHandler implements MiddlewareInterface
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
            $routeInfo[1] = $this->prepareHandler($request, $routeInfo[1]);
        }
        
        //dump($routeInfo); exit;
        return $delegate->process($request->withAttribute('routeResult', $routeInfo));
    }
    
     /**
     * Executing application action.
     *
     * @param string|callable $handler
     * @param array $vars
     */
    public function prepareHandler($request, $handler)
    {
        // execute action in controllers
        if (!is_array($handler) && strpos($handler, '@')!==false) {
            return $this->createMiddlewareFromControllerAction($handler);
        }
        
        if (is_array($handler)) {
            $newHandlersArray = [];
            foreach ($handler as $h) {
                if (!is_array($h) && strpos($h, '@')!==false) {
                    $newHandlersArray[] = $this->createMiddlewareFromControllerAction($h);
                } else {
                    $newHandlersArray[] = $h;
                }
            }
            
            return $newHandlersArray;
        }
    }
    
    /**
     * Create a middleware from a controller action
     *
     * @param string $handler
     *
     * @return MiddlewareInterface
     */
    private function createMiddlewareFromControllerAction(string $handler): MiddlewareInterface
    {
        return new class($handler, $this->container) implements MiddlewareInterface {
            private $handler;
            private $container;

            /**
             * @param string $handler
             */
            public function __construct(string $handler, $container)
            {
                $this->handler = $handler;
                $this->container = $container;
            }

            /**
             * {@inheritdoc}
             */
            public function process(ServerRequestInterface $request, DelegateInterface $delegate)
            {
                $routeInfo = $request->getAttribute('routeResult');
                
                $ca = explode('@', $this->handler);
                $controllerName = $ca[0];
                $action = $ca[1];
                
                $vars = $request->getAttribute('routeParams');
                
                if (class_exists($controllerName)) {
                    $controller = new $controllerName($request, $this->container);
                } else {
                    throw new Exception("Controller class '{$controllerName}' not found");
                }
                
                if (!method_exists($controller, $action)) {
                    throw new Exception("Method '{$controllerName}::{$action}' not defined");
                }
                $response = call_user_func_array(array($controller, $action), $vars);

                if (!($response instanceof ResponseInterface)) {
                    throw new LogicException('The middleware must return a ResponseInterface');
                }

                return $response;
            }
        };
    }
    
    private function createMiddlewareFromControllerActionAlt(string $handler): Closure
    {
        $container = $this->container;
        return function (ServerRequestInterface $request, DelegateInterface $delegate) use ($handler, $container) {
            $routeInfo = $request->getAttribute('routeResult');
                
            $ca = explode('@', $handler);
            $controllerName = $ca[0];
            $action = $ca[1];
                
            $vars = $request->getAttribute('routeParams');
                
            if (class_exists($controllerName)) {
                $controller = new $controllerName($request, $container);
            } else {
                throw new \Exception("Controller class '{$controllerName}' not found");
            }
                
            if (!method_exists($controller, $action)) {
                throw new \Exception("Method '{$controllerName}::{$action}' not defined");
            }
            $response = call_user_func_array(array($controller, $action), $vars);

            if (!($response instanceof ResponseInterface)) {
                throw new LogicException('The middleware must return a ResponseInterface');
            }

            return $response;
        };
    }
}
