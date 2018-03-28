<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Exception;

use DawidMazurek\JsonRpc\Error\JsonRpcErrorCodes;
use PHPUnit\Framework\TestCase;

class InvalidParamsTest extends TestCase
{
    /**
     * @test
     */
    public function givesCorrectErrorInfo()
    {
        $exception = new InvalidParams('Missing param id');
        $this->assertEquals(JsonRpcErrorCodes::INVALID_PARAMS, $exception->getCode());
        $this->assertEquals('Invalid params: Missing param id', $exception->getMessage());
    }
}
