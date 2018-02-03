<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\handler;

use dmazurek\JsonRpc\exception\MethodNotFoundException;
use dmazurek\JsonRpc\request\JsonRpcRequest;
use PHPUnit\Framework\TestCase;

class MethodCallableHandlerTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|callable
     */
    private $callback;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|JsonRpcRequest
     */
    private $request;

    public function setUp()
    {
        $this->callback = $this->createPartialMock(\stdClass::class, ['__invoke']);
        $this->request = $this->createMock(JsonRpcRequest::class);
    }

    /**
     * @test
     */
    public function executesRegisteredHandler()
    {
        $this->callback
          ->expects($this->once())
          ->method('__invoke');

        $this->request
            ->method('getMethod')
            ->willReturn('testMethod');

        $handler = new MethodCallableHandler();
        $handler->registerForMethod('testMethod', $this->callback);
        $handler->handle($this->request);
    }

    /**
     * @test
     */
    public function throwsExceptionForUnsupportedMethod()
    {
        $this->expectException(MethodNotFoundException::class);

        $this->request
            ->method('getMethod')
            ->willReturn('unmappedMethod');

        $handler = new MethodCallableHandler();
        $handler->handle($this->request);
    }
}
