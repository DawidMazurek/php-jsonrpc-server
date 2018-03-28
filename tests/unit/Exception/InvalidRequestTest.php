<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Exception;

use DawidMazurek\JsonRpc\Error\JsonRpcErrorCodes;
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
