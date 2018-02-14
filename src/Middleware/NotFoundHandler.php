<?php

namespace Bit55\Midcore\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class NotFoundHandler implements MiddlewareInterface
{
    private $container;

    private $template;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->template = $container->get('templates');
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        return (new HtmlResponse(
            $this->template->render('error::404')
        ))->withStatus(404);
    }
}
