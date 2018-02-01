<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

class JsonRpcResponseAggregate
{
    /**
     * @var JsonRpcResponse[]
     */
    private $responses = [];

    public function addResponse(JsonRpcResponse $response)
    {
        if ($response instanceof NotificationResponse) {
            return;
        }
        $this->responses []= $response;
    }

    /**
     * @return JsonRpcResponse[]
     */
    public function getAll(): array
    {
        return $this->responses;
    }

    public function serialize(): string
    {
        return json_encode($this->getResponse());
    }

    private function getResponse(): array
    {
        if (count($this->responses) === 1) {
            return reset($this->responses)->getPayload();
        }

        $response = [];

        foreach ($this->responses as $singleResponse) {
            $response[]= $singleResponse->getPayload();
        }

        return $response;
    }
}
