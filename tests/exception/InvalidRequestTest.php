<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\exception;

use dmazurek\JsonRpc\error\JsonRpcErrorCodes;
use PHPUnit\Framework\TestCase;

class InvalidRequestTest extends TestCase
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new InvalidRequest();
        $this->assertEquals(JsonRpcErrorCodes::INVALID_REQUEST, $exception->getCode());
        $this->assertEquals('Invalid request', $exception->getMessage());
    }
}
