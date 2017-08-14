<?php

namespace Bit55\Midcore\Template;

use Psr\Container\ContainerInterface;
use Bit55\Templater\TemplateRenderer;

class TemplaterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
    
        $templates = new TemplateRenderer($config['templates']?:[], $container);
        
        return $templates;
    }
}
