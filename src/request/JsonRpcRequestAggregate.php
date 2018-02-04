<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\request;

class JsonRpcRequestAggregate
{
    private $requests = [];

    public function addRequest(JsonRpcRequest $request)
    {
        $this->requests []= $request;
    }

    /**
     * @return JsonRpcRequest[]
     */
    public function getAll(): array
    {
        return $this->requests;
    }
}
