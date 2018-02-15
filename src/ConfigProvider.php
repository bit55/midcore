<?php

namespace Bit55\Midcore;

//use Bit55\Midcore\Middleware;

class ConfigProvider
{
    /**
     * Return configuration array.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    Middleware\FastRouteMiddleware::class    => Middleware\FastRouteMiddlewareFactory::class,
                    Middleware\RouteActionHandler::class     => Middleware\RouteActionHandlerFactory::class,                   
                ],
                'invokables' => [
                    Middleware\ErrorHandler::class           => Middleware\ErrorHandler::class,
                    Middleware\NotFoundHandler::class           => Middleware\NotFoundHandler::class
                ]
            ]
        ];
    }
}
