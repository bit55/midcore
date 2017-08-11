<?php

namespace Bit55\Midcore;

use Bit55\Midcore\Response\ResponseEmitterInterface;
use Bit55\Midcore\Response\DiactorosResponseEmitter;
use Bit55\Midcore\Middleware\FastRouteMiddleware;
use Bit55\Midcore\Middleware\ActionHandlerMiddleware;
use Bit55\Midcore\Middleware\ControllerHandlerMiddleware;
use Bit55\Midcore\Middleware\NotFoundHandler;
use Bit55\Midcore\Middleware\ErrorHandler;

class ConfigProvider
{
    /**
     * Return configuration array.
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    'templates'  => Factory\TemplaterFactory::class,
                ],
                'invokables' => [
                    ResponseEmitterInterface::class => DiactorosResponseEmitter::class,
                    FastRouteMiddleware::class => FastRouteMiddleware::class,
                    ErrorHandler::class => ErrorHandler::class
                ],
                'callables' => [
                    function ($container) {
                        $container->share(Middleware\ControllerHandlerMiddleware::class)->withArgument($container);
                        $container->share(Middleware\ActionHandlerMiddleware::class)->withArgument($container);
                        $container->share(Middleware\NotFoundHandler::class)->withArgument($container);
                    }
                ]
            ]
        ];
    }
}
