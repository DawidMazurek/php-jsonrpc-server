<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\io;

use dmazurek\JsonRpc\request\JsonRpcRequestAggregate;
use dmazurek\JsonRpc\request\JsonRpcRequestBuilder;

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
