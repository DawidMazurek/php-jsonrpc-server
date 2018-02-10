<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;

class InvalidRequest extends JsonRpcException
{
    public function __construct()
    {
        parent::__construct("Invalid request", JsonRpcErrorCodes::INVALID_REQUEST);
    }
}
