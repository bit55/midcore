<?php

namespace Bit55\Midcore\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller Interface
 */
interface ControllerInterface
{
    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ServerRequestInterface $request, ContainerInterface $container);
    
    /**
     * Initialization.
     */
    function init();
    
    /**
     * Render template and return response object
     *
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    function render($template, array $data = []);
    
    /**
     * Render JSON response
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     */
    function renderJson($data, $status = 200, array $headers = []);
    
    /**
     * Redirect response
     *
     * @param string $uri
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     */
    function redirect($uri, $status = 302, array $headers = []);

}
