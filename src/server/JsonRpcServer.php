<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\server;

use dmazurek\JsonRpc\config\JsonRpcConfig;
use dmazurek\JsonRpc\exception\InvalidRequest;
use dmazurek\JsonRpc\exception\JsonRpcException;
use dmazurek\JsonRpc\handler\JsonRpcRequestHandler;
use dmazurek\JsonRpc\io\JsonRpcInput;
use dmazurek\JsonRpc\request\IdentifiedJsonRpcRequest;
use dmazurek\JsonRpc\request\JsonRpcRequest;
use dmazurek\JsonRpc\request\JsonRpcRequestAggregate;
use dmazurek\JsonRpc\request\JsonRpcRequestBuilder;
use dmazurek\JsonRpc\request\Notification;
use dmazurek\JsonRpc\response\FailedResponse;
use dmazurek\JsonRpc\response\JsonRpcResponse;
use dmazurek\JsonRpc\response\JsonRpcResponseAggregate;
use dmazurek\JsonRpc\response\NotificationResponse;
use dmazurek\JsonRpc\response\Response;

class JsonRpcServer
{
    private $handler;

    /**
     * @var JsonRpcRequestBuilder
     */
    private $requestBuilder;

    public function __construct(JsonRpcRequestHandler $handler) {
        $this->handler = $handler;
    }

    public function run(JsonRpcRequestAggregate $requests)
    {
        foreach ($requests->getAll() as $request) {
            $this->handler->handle($request);
        }
    }

    private function handleRequest(string $json): JsonRpcResponseAggregate
    {
        $result = null;
        $error = null;

        $responseAggregate = new JsonRpcResponseAggregate();
        $requests = $this->requestBuilder->buildFromJson($json);

        foreach ($requests->getAll() as $request) {
            try {
                $handler = $this->config->getMethodHandler($request->getMethod());
                $result = $handler($request);
                $responseAggregate->addResponse(
                    $this->createJsonRpcResponse($request, $result, $error)
                );
            } catch (JsonRpcException $exception) {
                $error = [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage()
                ];
                $responseAggregate->addResponse(
                    $this->createErrorResponse($error)
                );
            }
        }

        return $responseAggregate;
    }

    /**
     * @param JsonRpcRequest $request
     * @param null $result
     * @param null $error
     * @return JsonRpcResponse
     * @throws InvalidRequest
     */
    private function createJsonRpcResponse(JsonRpcRequest $request, $result = null, $error = null): JsonRpcResponse
    {
        if ($request instanceof Notification) {
            return new NotificationResponse();
        }

        if ($request instanceof IdentifiedJsonRpcRequest) {
            return new Response(
                $request->getApiVersion(),
                $request->getRequestId(),
                $result,
                $error
            );
        }

        throw new InvalidRequest();
    }

    private function createErrorResponse(array $error): JsonRpcResponse
    {
        return new FailedResponse($error['code'], $error['message']);
    }
}
