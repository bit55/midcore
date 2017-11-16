<?php


namespace Bit55\Midcore\Middleware;

use Psr\Container\ContainerInterface;

class TemplatedActionFactory
{
    public function __invoke(ContainerInterface $container, string $alias)
    {
        $template = $container->get('templates'); //@todo TemplateManager, TemplateRenderer
        return new $alias($template); //@note Prevent using container in Actions as possible
    }
}
