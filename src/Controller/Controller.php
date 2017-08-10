<?php

namespace Bit55\Midcore\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Abstract Controller class
 */
abstract class Controller
{
    protected $container;
    
    protected $request;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ServerRequestInterface $request, ContainerInterface $container)
    {
        $this->request      = $request;
        $this->container      = $container;
        $this->init();
    }
    
    /**
     * Initialization.
     */
    protected function init()
    {
    }
    
    /**
     * Render template and return response object
     *
     * @param string $template
     * @param array $data
     * @return HtmlResponse
     */
    protected function render($template, array $data = [])
    {
        return new HtmlResponse(
            $this->container->get('templates')->render($template, $data)
        );
    }
    
    /**
     * Render JSON response
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    protected function renderJson($data, $status = 200, array $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }
    
    /**
     * Redirect response
     *
     * @param string $uri
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    protected function redirect($uri, $status = 302, array $headers = [])
    {
        return new RedirectResponse($uri, $status, $headers);
    }
    
    /**
     * Index Action blueprint
     *
     * @return HtmlResponse
     */
    public function indexAction()
    {
        return new HtmlResponse('Abstract Index Action');
    }
}
