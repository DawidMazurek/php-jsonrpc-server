<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\handler;

use dmazurek\JsonRpc\exception\JsonRpcException;
use dmazurek\JsonRpc\exception\MethodNotFoundException;
use dmazurek\JsonRpc\request\JsonRpcRequest;
use dmazurek\JsonRpc\request\Request;
use dmazurek\JsonRpc\response\FailedResponse;
use dmazurek\JsonRpc\response\JsonRpcResponse;
use dmazurek\JsonRpc\response\NotificationResponse;
use dmazurek\JsonRpc\response\Response;

class MethodCallableHandler implements JsonRpcRequestHandler
{
    private $callbacks = [];

    public function registerForMethod(string $method, callable $callback) {
        $this->callbacks[$method] = $callback;
    }

    public function handle(JsonRpcRequest $request): JsonRpcResponse
    {
        try {
            $method = $request->getMethod();
            if (!isset($this->callbacks[$method])) {
                throw new MethodNotFoundException();
            }
            $result = $this->callbacks[$method]($request->getParams());
            return $this->createResponse($request, $result);
        } catch (JsonRpcException $ex) {
            return $this->createErrorResponse($request, $ex);
        }
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
