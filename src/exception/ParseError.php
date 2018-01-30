<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\exception;

use dmazurek\JsonRpc\error\JsonRpcErrorCodes;

class ParseError extends JsonRpcException
{
    public function __construct()
    {
        parent::__construct("Parse error", JsonRpcErrorCodes::PARSE_ERROR);
    }
}
