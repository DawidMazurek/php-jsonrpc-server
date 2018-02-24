<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;
use PHPUnit\Framework\TestCase;

class InvalidRequestTest extends TestCase
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new InvalidRequest('Request');
        $this->assertEquals(JsonRpcErrorCodes::INVALID_REQUEST, $exception->getCode());
        $this->assertEquals('Invalid request: Request', $exception->getMessage());
    }
}
