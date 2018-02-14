<?php

namespace Bit55\Midcore;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Middleland\Dispatcher;

class Application
{
    private $container;
    private $pipeline;

    public function __construct($containerConfig, $pipelineConfig)
    {
        // DI container
        $this->container = include $containerConfig;
        // Middleware pipeline
        $this->pipeline = include $pipelineConfig;
    }

    public function run()
    {
        $dispatcher = new Dispatcher($this->pipeline, $this->container);
        $emitter = new SapiEmitter();

        // Process request
        $request = ServerRequestFactory::fromGlobals();
        $response = $dispatcher->dispatch($request);
        $emitter->emit($response);
    }
}
