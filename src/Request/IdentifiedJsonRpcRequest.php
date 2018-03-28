<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Request;

interface IdentifiedJsonRpcRequest extends JsonRpcRequest
{
    public function getRequestId(): int;
}
