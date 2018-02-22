<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\handler;

use DawidMazurek\JsonRpc\exception\JsonRpcException;
use DawidMazurek\JsonRpc\exception\MethodNotFound;
use DawidMazurek\JsonRpc\request\JsonRpcRequest;
use DawidMazurek\JsonRpc\request\Request;
use DawidMazurek\JsonRpc\response\FailedResponse;
use DawidMazurek\JsonRpc\response\JsonRpcResponse;
use DawidMazurek\JsonRpc\response\NotificationResponse;
use DawidMazurek\JsonRpc\response\Response;

class MethodCallableHandler implements JsonRpcRequestHandler
{
    private $callbacks = [];

    public function registerForMethod(string $method, callable $callback)
    {
        $this->callbacks[$method] = $callback;
    }

    public function handle(JsonRpcRequest $request): JsonRpcResponse
    {
        try {
            $method = $request->getMethod();
            if (!isset($this->callbacks[$method])) {
                throw new MethodNotFound();
            }
            $result = $this->callbacks[$method]($request->getParams());
            return $this->createResponse($request, $result);
        } catch (JsonRpcException $ex) {
            return $this->createErrorResponse($request, $ex);
        }
    }

    public function handleError(JsonRpcException $exception): JsonRpcResponse
    {
        return new FailedResponse(
            "2.0",
            $exception->getCode(),
            $exception->getMessage()
        );
    }

    private function createErrorResponse(JsonRpcRequest $request, JsonRpcException $exception): JsonRpcResponse
    {
        if ($request instanceof Request) {
            return new FailedResponse(
                $request->getApiVersion(),
                $exception->getCode(),
                $exception->getMessage(),
                $request->getRequestId()
            );
        }
        return new NotificationResponse();
    }

    private function createResponse(JsonRpcRequest $request, $result): JsonRpcResponse
    {
        if ($request instanceof Request) {
            return new Response(
                $request->getApiVersion(),
                $request->getRequestId(),
                $result
            );
        }
        return new NotificationResponse();
    }
}
