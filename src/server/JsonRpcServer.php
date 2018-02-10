<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\server;

use DawidMazurek\JsonRpc\handler\JsonRpcRequestHandler;
use DawidMazurek\JsonRpc\request\JsonRpcRequestAggregate;
use DawidMazurek\JsonRpc\response\JsonRpcResponseAggregate;

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
