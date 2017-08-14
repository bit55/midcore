<?php

namespace Bit55\Midcore\Middleware;

use Psr\Container\ContainerInterface;

class ActionHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ActionHandler($container);
    }
}
