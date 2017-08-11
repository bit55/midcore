<?php

namespace Bit55\Midcore;

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
                    Response\ResponseEmitterInterface::class => Response\DiactorosResponseEmitter::class,
                    Middleware\FastRouteMiddleware::class => Middleware\FastRouteMiddleware::class,
                    Middleware\ErrorHandler::class => Middleware\ErrorHandler::class
                ],
                'callables' => [
                    function ($container) {
                        $container->share(Middleware\ControllerHandler::class)->withArgument($container);
                        $container->share(Middleware\ActionHandler::class)->withArgument($container);
                        $container->share(Middleware\NotFoundHandler::class)->withArgument($container);
                    }
                ]
            ]
        ];
    }
}
