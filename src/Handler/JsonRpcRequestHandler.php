<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Handler;

use DawidMazurek\JsonRpc\Exception\JsonRpcException;
use DawidMazurek\JsonRpc\Request\JsonRpcRequest;
use DawidMazurek\JsonRpc\Response\JsonRpcResponse;

interface JsonRpcRequestHandler
{
    public function registerForMethod(string $method, callable $callback);
    public function handle(JsonRpcRequest $request): JsonRpcResponse;
    public function handleError(JsonRpcException $exception): JsonRpcResponse;
}
