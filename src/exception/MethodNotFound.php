<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\exception;

use dmazurek\JsonRpc\error\JsonRpcErrorCodes;

class MethodNotFound extends JsonRpcException
{
    public function __construct()
    {
        parent::__construct("Method not found", JsonRpcErrorCodes::METHOD_NOT_FOUND);
    }
}
