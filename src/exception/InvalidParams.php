<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\exception;

use dmazurek\JsonRpc\error\JsonRpcErrorCodes;

class InvalidParams extends JsonRpcException
{
    public function __construct()
    {
        parent::__construct("Invalid params", JsonRpcErrorCodes::INVALID_PARAMS);
    }
}
