<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;

class ParseErrorTest
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new ParseError();
        $this->assertEquals(JsonRpcErrorCodes::PARSE_ERROR, $exception->getCode());
        $this->assertEquals('parseError', $exception->getMessage());
    }
}
