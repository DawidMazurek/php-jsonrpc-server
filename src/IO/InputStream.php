<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\IO;

use DawidMazurek\JsonRpc\Request\JsonRpcRequestAggregate;
use DawidMazurek\JsonRpc\Request\JsonRpcRequestBuilder;

class InputStream implements JsonRpcInput
{
    /**
     * @var JsonRpcRequestBuilder
     */
    private $requestBuilder;

    public function __construct(JsonRpcRequestBuilder $requestBuilder)
    {
        $this->requestBuilder = $requestBuilder;
    }

    public function getRequest(): JsonRpcRequestAggregate
    {
        return $this->requestBuilder->buildFromJson($this->readFromInput());
    }

    private function readFromInput(): string
    {
        return file_get_contents('php://input');
    }
}
