<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\io;

use dmazurek\JsonRpc\request\JsonRpcRequestAggregate;
use dmazurek\JsonRpc\request\JsonRpcRequestBuilder;
use PHPUnit\Framework\TestCase;

class CustomStringInputTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|JsonRpcRequestBuilder
     */
    private $builder;

    public function setUp()
    {
        $this->builder = $this->createMock(JsonRpcRequestBuilder::class);
    }

    /**
     * @test
     */
    public function passesStringToBuilder()
    {
        $expectedString = '{"jsonrpc":"2.0"}';
        $expectedOutput = $this->createMock(JsonRpcRequestAggregate::class);

        $this->builder->expects($this->once())
            ->method('buildFromJson')
            ->with($expectedString)
            ->willReturn($expectedOutput);

        $input = new CustomStringInput($expectedString, $this->builder);
        $output = $input->getRequest();
        $this->assertSame($expectedOutput, $output);
    }
}
