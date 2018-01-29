<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

class NotificationResponse implements JsonRpcResponse
{
    public function getPayload(): array
    {
       return [];
    }
}
