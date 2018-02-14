<?php

namespace Bit55\Midcore\Middleware;

use Psr\Container\ContainerInterface;

class FastRouteMiddleware
{
    public function __invoke(ContainerInterface $container)
    {
        return new FastRouteMiddleware($container->get('routesConfig'));
    }
}