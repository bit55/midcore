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
                    Middleware\RouteActionHandler::class     => Middleware\RouteActionHandlerFactory::class,
                    Middleware\NotFoundHandler::class        => Middleware\NotFoundHandlerFactory::class,
                    Middleware\FastRouteMiddleware::class    => Middleware\FastRouteMiddlewareFactory::class,
                ],
                'invokables' => [
                    Middleware\ErrorHandler::class           => Middleware\ErrorHandler::class
                ]
            ]
        ];
    }
}
