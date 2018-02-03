<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\handler;

use dmazurek\JsonRpc\exception\MethodNotFoundException;
use dmazurek\JsonRpc\request\JsonRpcRequest;

class MethodCallableHandler implements JsonRpcRequestHandler
{
    private $callbacks = [];

    public function registerForMethod(string $method, callable $callback) {
        $this->callbacks[$method] = $callback;
    }

    public function handle(JsonRpcRequest $request)
    {
        $method = $request->getMethod();
        if (!isset($this->callbacks[$method])) {
            throw new MethodNotFoundException();
        }
        $this->callbacks[$method]($request->getParams());
    }
}
