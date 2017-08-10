<?php

namespace Bit55\Midcore\Response;

use Bit55\Midcore\Response\ResponseEmitterInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * Class DiactorosResponseEmitter.
 */
final class DiactorosResponseEmitter implements ResponseEmitterInterface
{
    /**
     * @inheritDoc
     */
    public function emit(ResponseInterface $response)
    {
        (new SapiEmitter())->emit($response);
    }
}
