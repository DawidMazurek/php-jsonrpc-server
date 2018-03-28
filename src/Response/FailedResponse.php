<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Response;

class FailedResponse implements JsonRpcResponse
{
    private $apiVersion;
    private $errorCode;
    private $message;
    private $requestId;

    public function __construct(string $apiVersion, int $errorCode, string $message, int $requestId = null)
    {
        $this->apiVersion = $apiVersion;
        $this->errorCode = $errorCode;
        $this->message = $message;
        $this->requestId = $requestId;
    }

    public function getPayload(): array
    {
        return [
            'jsonrpc' => $this->apiVersion,
            'error' => [
                'code' => $this->errorCode,
                'message' => $this->message
            ],
            'id' => $this->requestId
        ];
    }
}

