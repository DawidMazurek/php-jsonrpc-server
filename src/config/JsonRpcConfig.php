<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\config;

use dmazurek\JsonRpc\exception\MethodNotFoundException;

class JsonRpcConfig
{
    private $handlers;

    public function addMapping(string $method, callable $handler)
    {
        $this->handlers[$method] = $handler;
    }

    public function getMethodHandler(string $method): callable
    {
        if (!array_key_exists($method, $this->handlers)) {
            throw new MethodNotFoundException("Handler for method $method not found.");
        }

        return $this->handlers[$method];
    }
}
