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
     * Return configuration for this component.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            
            'containerConfigCallables' => [function ($container) {
                $container->share(Middleware\ControllerHandlerMiddleware::class)->withArgument($container);
                $container->share(Middleware\ActionHandlerMiddleware::class)->withArgument($container);
                $container->share(Middleware\NotFoundHandler::class)->withArgument($container);
            }]
        ];
    }

    /**
     * Return dependency mappings for this component.
     * @return array
     */
    public function getDependencyConfig()
    {
        return [

            'factories' => [
                'templates'  => Factory\TemplaterFactory::class,
                // ActionHandlerMiddleware::class => ActionHandlerMiddleware::class,
                // ControllerHandlerMiddleware::class => ControllerHandlerMiddleware::class,
                // NotFoundHandler::class => NotFoundHandler::class,
            ],
            'invokables' => [
                ResponseEmitterInterface::class => DiactorosResponseEmitter::class,                
                FastRouteMiddleware::class => FastRouteMiddleware::class,                
                ErrorHandler::class => ErrorHandler::class
            ],
        ];
    }
}
