<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\handler;

use DawidMazurek\JsonRpc\request\JsonRpcRequest;
use DawidMazurek\JsonRpc\response\JsonRpcResponse;

interface JsonRpcRequestHandler
{
    public function registerForMethod(string $method, callable $callback);
    public function handle(JsonRpcRequest $request): JsonRpcResponse;
}
