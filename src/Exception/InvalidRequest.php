<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Exception;

use DawidMazurek\JsonRpc\Error\JsonRpcErrorCodes;

class InvalidRequest extends JsonRpcException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Invalid request: " . $message, JsonRpcErrorCodes::INVALID_REQUEST);
    }
}
