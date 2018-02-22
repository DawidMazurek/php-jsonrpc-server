<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\server;

use DawidMazurek\JsonRpc\exception\JsonRpcException;
use DawidMazurek\JsonRpc\handler\JsonRpcRequestHandler;
use DawidMazurek\JsonRpc\io\JsonRpcInput;
use DawidMazurek\JsonRpc\response\JsonRpcResponseAggregate;

class JsonRpcServer
{
    private $handler;

    public function __construct(JsonRpcRequestHandler $handler)
    {
        $this->handler = $handler;
    }

    public function run(JsonRpcInput $input): JsonRpcResponseAggregate
    {
        try {
            $responseAggregate = new JsonRpcResponseAggregate();

            foreach ($input->getRequest()->getAll() as $request) {
                $responseAggregate->addResponse(
                    $this->handler->handle($request)
                );
            }
        } catch (JsonRpcException $exception) {
            $responseAggregate->addResponse(
                $this->handler->handleError($exception)
            );
        }

        return $responseAggregate;
    }
}
