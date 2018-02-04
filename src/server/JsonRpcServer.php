<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\server;

use dmazurek\JsonRpc\handler\JsonRpcRequestHandler;
use dmazurek\JsonRpc\request\JsonRpcRequestAggregate;
use dmazurek\JsonRpc\response\JsonRpcResponseAggregate;

class JsonRpcServer
{
    private $handler;

    public function __construct(JsonRpcRequestHandler $handler)
    {
        $this->handler = $handler;
    }

    public function run(JsonRpcRequestAggregate $requests): JsonRpcResponseAggregate
    {
        $responseAggregate = new JsonRpcResponseAggregate();

        foreach ($requests->getAll() as $request) {
            $responseAggregate->addResponse(
                $this->handler->handle($request)
            );
        }

        return $responseAggregate;
    }
}
