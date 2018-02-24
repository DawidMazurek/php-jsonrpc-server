<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;

class InvalidRequest extends JsonRpcException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Invalid request: " . $message, JsonRpcErrorCodes::INVALID_REQUEST);
    }
}
