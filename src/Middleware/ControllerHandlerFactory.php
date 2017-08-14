<?php

namespace Bit55\Midcore\Middleware;

use Psr\Container\ContainerInterface;

class ControllerHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ControllerHandler($container);
    }
}
