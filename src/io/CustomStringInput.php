<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\io;

use dmazurek\JsonRpc\request\JsonRpcRequestAggregate;
use dmazurek\JsonRpc\request\JsonRpcRequestBuilder;

class CustomStringInput implements JsonRpcInput
{
    /**
     * @var string
     */
    private $customString;
    /**
     * @var JsonRpcRequestBuilder
     */
    private $requestBuilder;

    public function __construct(string $customString, JsonRpcRequestBuilder $requestBuilder)
    {
        $this->customString = $customString;
        $this->requestBuilder = $requestBuilder;
    }

    public function getRequest(): JsonRpcRequestAggregate
    {
        return $this->requestBuilder->buildFromJson($this->readFromInput());
    }

    private function readFromInput(): string
    {
        return $this->customString;
    }
}
