<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;
use PHPUnit\Framework\TestCase;

class ParseErrorTest extends TestCase
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new ParseError('Received empty body');
        $this->assertEquals(JsonRpcErrorCodes::PARSE_ERROR, $exception->getCode());
        $this->assertEquals('parseError: Received empty body', $exception->getMessage());
    }
}
