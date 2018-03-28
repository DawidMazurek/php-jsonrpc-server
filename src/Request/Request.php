<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Request;

class Request implements IdentifiedJsonRpcRequest
{
    /**
     * @var string
     */
    private $apiVersion;
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $params;
    /**
     * @var int
     */
    private $requestId;

    public function __construct(string $apiVersion, string $method, array $params, int $requestId)
    {
        $this->apiVersion = $apiVersion;
        $this->method = $method;
        $this->params = $params;
        $this->requestId = $requestId;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getRequestId(): int
    {
        return $this->requestId;
    }
}
