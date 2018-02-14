<?php

namespace Bit55\Midcore\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\TextResponse;

class ErrorHandler implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PlainTextHandler);
        $whoops->register();
        
        /* set_error_handler($this->createErrorHandler());

        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
        } catch (Exception $e) {
        }

        //restore_error_handler();

        return new TextResponse(sprintf(
            "[%d] %s\n\n%s",
            $e->getCode(),
            $e->getMessage(),
            $e->getTraceAsString()
        ), 500); */
        
        return $handler->handle($request);
    }
    
    /**
     * Creates and returns a callable error handler that raises exceptions.
     *
     * Only raises exceptions for errors that are within the error_reporting mask.
     *
     * @return callable
     */
    private function createErrorHandler()
    {
        /**
         * @param int $errno
         * @param string $errstr
         * @param string $errfile
         * @param int $errline
         * @return void
         * @throws \ErrorException if error is not within the error_reporting mask.
         */
        return function ($errno, $errstr, $errfile, $errline) {
            if (! (error_reporting() & $errno)) {
                // error_reporting does not include this error
                return;
            }

            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        };
    }
}
