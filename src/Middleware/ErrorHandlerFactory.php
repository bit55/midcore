<?php

namespace Bit55\Midcore\Middleware;

use Psr\Container\ContainerInterface;

class ErrorHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ErrorHandler($container);
    }
}
