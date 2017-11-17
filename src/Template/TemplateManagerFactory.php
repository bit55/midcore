<?php

namespace Bit55\Midcore\Template;

use Psr\Container\ContainerInterface;
use Bit55\Templater\TemplateManager;

class TemplateManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
    
        $templates = new TemplateManager($config['templates']?:[], $container);
        
        return $templates;
    }
}
