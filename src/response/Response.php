<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

class Response implements JsonRpcResponse
{
    /**
     * @var float
     */
    private $jsonrpc;
    /**
     * @var array
     */
    private $result;
    /**
     * @var int
     */
    private $requestId;

    public function __construct(string $jsonrpc, int $requestId, $result)
    {
        $this->jsonrpc = $jsonrpc;
        $this->requestId = $requestId;
        $this->result = $result;
    }

    public function getPayload(): array
    {
        return [
            'jsonrpc' => $this->jsonrpc,
            'id' => $this->requestId,
            'result' => $this->result
        ];
    }
}
