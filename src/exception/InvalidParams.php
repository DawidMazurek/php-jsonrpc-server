<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;

class InvalidParams extends JsonRpcException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Invalid params: " . $message , JsonRpcErrorCodes::INVALID_PARAMS);
    }
}
