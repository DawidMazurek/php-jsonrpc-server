<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Exception;

use DawidMazurek\JsonRpc\Error\JsonRpcErrorCodes;

class InvalidParams extends JsonRpcException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Invalid params: " . $message , JsonRpcErrorCodes::INVALID_PARAMS);
    }
}
