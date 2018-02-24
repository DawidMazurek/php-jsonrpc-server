<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;

class MethodNotFound extends JsonRpcException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Method not found: " . $message, JsonRpcErrorCodes::METHOD_NOT_FOUND);
    }
}
