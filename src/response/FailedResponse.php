<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

class FailedResponse implements JsonRpcResponse
{
    private $errorCode;
    private $message;

    public function __construct(int $errorCode, string $message)
    {
        $this->errorCode = $errorCode;
        $this->message = $message;
    }

    public function getPayload(): array
    {
        return [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => $this->errorCode,
                'message' => $this->message
            ]
        ];
    }
}

