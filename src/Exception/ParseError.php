<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Exception;

use DawidMazurek\JsonRpc\Error\JsonRpcErrorCodes;

class ParseError extends JsonRpcException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Parse error: " .$message , JsonRpcErrorCodes::PARSE_ERROR);
    }
}
