<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Exception;

use DawidMazurek\JsonRpc\Error\JsonRpcErrorCodes;
use PHPUnit\Framework\TestCase;

class MethodNotFoundTest extends TestCase
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new MethodNotFound('sampleMethod');
        $this->assertEquals(JsonRpcErrorCodes::METHOD_NOT_FOUND, $exception->getCode());
        $this->assertEquals('Method not found: sampleMethod', $exception->getMessage());
    }
}
