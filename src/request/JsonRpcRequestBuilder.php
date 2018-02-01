<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\request;

use dmazurek\JsonRpc\exception\InvalidParams;
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
     * @return JsonRpcRequestAggregate
     * @throws InvalidParams
     */
    public function buildFromJson(string $json): JsonRpcRequestAggregate
    {
        $requests = new JsonRpcRequestAggregate();
        $data = $this->serializer->unserialize($json);

        if (isset($data['jsonrpc'], $data['method'], $data['params'])) {
            $requests->addRequest($this->createRequest($data));
            return $requests;
        }

        foreach ($data as $singleRequest) {
            if (!isset($singleRequest['jsonrpc'], $singleRequest['method'], $singleRequest['params'])) {
                throw new InvalidParams();
            }
            $requests->addRequest($this->createRequest($singleRequest));
        }

        return $requests;
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
