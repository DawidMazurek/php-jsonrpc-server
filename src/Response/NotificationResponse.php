<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Response;

class NotificationResponse implements JsonRpcResponse
{
    public function getPayload(): array
    {
       return [];
    }
}
