<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\request;

interface IdentifiedJsonRpcRequest extends JsonRpcRequest
{
    public function getRequestId(): int;
}
