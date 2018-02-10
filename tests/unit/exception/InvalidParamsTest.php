<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;
use PHPUnit\Framework\TestCase;

class InvalidParamsTest extends TestCase
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new InvalidParams();
        $this->assertEquals(JsonRpcErrorCodes::INVALID_PARAMS, $exception->getCode());
        $this->assertEquals('Invalid params', $exception->getMessage());
    }
}
