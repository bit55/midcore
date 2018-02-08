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
                    //'templates'  => Template\TemplateManagerFactory::class,
                    Middleware\ActionHandler::class => Middleware\ActionHandlerFactory::class,
                    Middleware\NotFoundHandler::class => Middleware\NotFoundHandlerFactory::class,
                ],
                'invokables' => [
                    Response\ResponseEmitterInterface::class => Response\DiactorosResponseEmitter::class,
                    Middleware\FastRouteMiddleware::class => Middleware\FastRouteMiddleware::class,
                    Middleware\ErrorHandler::class => Middleware\ErrorHandler::class
                ]
            ]
        ];
    }
}
