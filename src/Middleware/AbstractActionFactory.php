<?php


namespace Bit55\Midcore\Middleware;

use Psr\Container\ContainerInterface;

class AbstractActionFactory
{
    public function __invoke(ContainerInterface $container, string $alias)
    {
        $template = $container->get('templates'); //@todo TemplateManager, TemplateRenderer
        return new $alias($template, $container); //@note Prevent using container in Actions as possible
    }
}
