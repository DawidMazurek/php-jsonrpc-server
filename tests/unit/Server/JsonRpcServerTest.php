<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Server;

use DawidMazurek\JsonRpc\Exception\ParseError;
use DawidMazurek\JsonRpc\Handler\JsonRpcRequestHandler;
use DawidMazurek\JsonRpc\IO\JsonRpcInput;
use DawidMazurek\JsonRpc\Request\JsonRpcRequestAggregate;
use DawidMazurek\JsonRpc\Request\Request;
use DawidMazurek\JsonRpc\Response\JsonRpcResponse;
use PHPUnit\Framework\TestCase;

class JsonRpcServerTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|JsonRpcRequestAggregate
     */
    private $requests;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|JsonRpcRequestHandler
     */
    private $requestHandler;

    public function setUp()
    {
        $this->requests = $this->createPartialMock(JsonRpcRequestAggregate::class, []);
        $this->requestHandler = $this->createMock(JsonRpcRequestHandler::class);
    }

    /**
     * @test
     */
    public function handlesRequest()
    {
        $this->requestHandler->expects($this->once())
            ->method('handle');

        $this->requests->addRequest(new Request(
            "2.0",
            "sampleMethod",
            [],
            1
        ));

        $input = $this->createMock(JsonRpcInput::class);
        $input->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requests);

        $server = new JsonRpcServer($this->requestHandler);
        $server->run($input);
    }


    /**
     * @test
     */
    public function handlesMultipleRequests()
    {
        $this->requestHandler->expects($this->exactly(2))
            ->method('handle');

        $this->requests->addRequest(new Request(
            "2.0",
            "sampleMethod",
            [],
            1
        ));
        $this->requests->addRequest(new Request(
            "2.0",
            "sampleMethod",
            [],
            2
        ));

        $input = $this->createMock(JsonRpcInput::class);
        $input->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requests);

        $server = new JsonRpcServer($this->requestHandler);
        $server->run($input);
    }

    /**
     * @test
     */
    public function returnsEmptyResponseForEmptyInput()
    {
        $input = $this->createMock(JsonRpcInput::class);
        $input->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requests);

        $server = new JsonRpcServer($this->requestHandler);
        $this->assertEmpty(
            $server->run($input)->getAll()
        );
    }

    /**
     * @test
     */
    public function handlesExceptionWhileHandlingRequest()
    {
        $input = $this->createMock(JsonRpcInput::class);
        $input->expects($this->once())
            ->method('getRequest')
            ->willThrowException(new ParseError());

        $server = new JsonRpcServer($this->requestHandler);

        $response = $server->run($input)->getAll();

        $this->assertContainsOnlyInstancesOf(
            JsonRpcResponse::class,
            $response
        );

        $this->assertEquals(
            1,
            count($response)
        );
    }
}
