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
    /**
     * @var null
     */
    private $error;

    public function __construct(string $jsonrpc, int $requestId = null, $result = null, array $error = null)
    {
        $this->jsonrpc = $jsonrpc;
        $this->requestId = $requestId;
        $this->result = $result;
        $this->error = $error;
    }

    public function getPayload(): array
    {
        $response = [
            'jsonrpc' => $this->jsonrpc,
            'id' => $this->requestId
        ];

        if (isset($this->result)) {
            $response['result'] = $this->result;
        }

        if (isset($this->error)) {
            $response['error'] = $this->error;
        }

        return $response;
    }
}
