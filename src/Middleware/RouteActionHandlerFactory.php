<?php

namespace Bit55\Midcore\Middleware;

use Psr\Container\ContainerInterface;

class RouteActionHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RouteActionHandler($container);
    }
}
