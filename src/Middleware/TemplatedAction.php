<?php


namespace Bit55\Midcore\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Bit55\Templater\TemplateManager;

abstract class TemplatedAction implements MiddlewareInterface
{
    protected $template;
    
    public function __construct(TemplateManager $template = null)
    {
        $this->template = $template;
    }
    
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        
    }
    
    /**
     * Render template and return response object
     *
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     */
    protected function render($template, array $data = [])
    {
        return new HtmlResponse(
            $this->template->render($template, $data)
        );
    }
    
    /**
     * Render JSON response
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
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
     * @return ResponseInterface
     */
    protected function redirect($uri, $status = 302, array $headers = [])
    {
        return new RedirectResponse($uri, $status, $headers);
    }
}
