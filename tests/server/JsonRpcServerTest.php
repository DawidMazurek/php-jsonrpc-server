<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\server;

use dmazurek\JsonRpc\handler\JsonRpcRequestHandler;
use dmazurek\JsonRpc\io\JsonRpcInput;
use dmazurek\JsonRpc\request\JsonRpcRequestAggregate;
use dmazurek\JsonRpc\request\Request;
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

        $server = new JsonRpcServer($this->requestHandler);
        $server->run($this->requests);
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


        $server = new JsonRpcServer($this->requestHandler);
        $server->run($this->requests);
    }
}
