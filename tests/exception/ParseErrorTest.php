<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\exception;

use dmazurek\JsonRpc\error\JsonRpcErrorCodes;

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
