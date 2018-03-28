<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\IO;

use DawidMazurek\JsonRpc\Request\JsonRpcRequestAggregate;
use DawidMazurek\JsonRpc\Request\JsonRpcRequestBuilder;

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
        return $this->requestBuilder->buildFromJson($this->customString);
    }
}
