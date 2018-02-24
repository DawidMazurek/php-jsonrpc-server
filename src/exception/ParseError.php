<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;

class ParseError extends JsonRpcException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Parse error: " .$message , JsonRpcErrorCodes::PARSE_ERROR);
    }
}
