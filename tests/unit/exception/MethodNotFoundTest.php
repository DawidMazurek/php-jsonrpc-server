<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\exception;

use DawidMazurek\JsonRpc\error\JsonRpcErrorCodes;
use PHPUnit\Framework\TestCase;

class MethodNotFoundTest extends TestCase
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new MethodNotFound();
        $this->assertEquals(JsonRpcErrorCodes::METHOD_NOT_FOUND, $exception->getCode());
        $this->assertEquals('Method not found', $exception->getMessage());
    }
}
