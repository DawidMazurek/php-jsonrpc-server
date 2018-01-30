<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\exception;

use dmazurek\JsonRpc\error\JsonRpcErrorCodes;

class InvalidRequest extends JsonRpcException
{
    public function __construct()
    {
        parent::__construct("Invalid request", JsonRpcErrorCodes::INVALID_REQUEST);
    }
}
