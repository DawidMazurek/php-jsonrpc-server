<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\request;

use dmazurek\JsonRpc\exception\InvalidParams;
use dmazurek\JsonRpc\exception\ParseError;
use dmazurek\JsonRpc\io\JsonSerializer;

class JsonRpcRequestBuilder
{
    /**
     * @var JsonSerializer
     */
    private $serializer;

    public function __construct(JsonSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $json
     * @return JsonRpcRequest
     * @throws InvalidParams
     * @throws ParseError
     */
    public function build(string $json): JsonRpcRequest
    {
        $data = $this->serializer->unserialize($json);
        if ($data === null) {
            throw new ParseError();
        }
        if (!isset($data['jsonrpc'], $data['method'], $data['params'])) {
            throw new InvalidParams();
        }

        $request = $this->createRequest($data);
        return $request;
    }

    private function createRequest(array $data): JsonRpcRequest
    {
        if (isset($data['id'])) {
            return new Request(
                $data['jsonrpc'],
                $data['method'],
                $data['params'],
                $data['id']
            );
        }

        return $request = new Notification(
            $data['jsonrpc'],
            $data['method'],
            $data['params']
        );
    }
}
