<?php

declare(strict_types = 1);


namespace DawidMazurek\JsonRpc\IO;

use DawidMazurek\JsonRpc\Request\JsonRpcRequestAggregate;
use DawidMazurek\JsonRpc\Request\JsonRpcRequestBuilder;
use PHPUnit\Framework\TestCase;

function file_get_contents()
{
    return '{"jsonrpc":"2.0"}';
}

class InputStreamTest extends TestCase
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

        $input = new InputStream($this->builder);
        $output = $input->getRequest();
        $this->assertSame($expectedOutput, $output);
    }

}
