<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\request;

use DawidMazurek\JsonRpc\exception\InvalidParams;
use DawidMazurek\JsonRpc\io\JsonSerializer;

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
        $data = $this->serializer->unserialize($json);

        if (isset($data['jsonrpc'], $data['method'], $data['params'])) {
            return $this->createSingleRequest($data);
        }

        return $this->createMultipleRequests($data);
    }

    private function createSingleRequest(array $data): JsonRpcRequestAggregate
    {
        $requests = new JsonRpcRequestAggregate();
        $requests->addRequest($this->createRequest($data));
        return $requests;
    }

    private function createMultipleRequests(array $data): JsonRpcRequestAggregate
    {
        $requests = new JsonRpcRequestAggregate();
        foreach ($data as $singleRequest) {
            if (isset($singleRequest['jsonrpc'], $singleRequest['method'], $singleRequest['params'])) {
                $requests->addRequest($this->createRequest($singleRequest));
            }
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
