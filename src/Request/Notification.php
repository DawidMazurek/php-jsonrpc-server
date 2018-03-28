<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Request;

class Notification implements JsonRpcRequest
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

    public function __construct(string $apiVersion, string $method, array $params)
    {
        $this->apiVersion = $apiVersion;
        $this->method = $method;
        $this->params = $params;
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
}
