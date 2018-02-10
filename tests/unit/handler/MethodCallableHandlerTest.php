<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\handler;

use dmazurek\JsonRpc\request\JsonRpcRequest;
use dmazurek\JsonRpc\request\Notification;
use dmazurek\JsonRpc\request\Request;
use dmazurek\JsonRpc\response\FailedResponse;
use dmazurek\JsonRpc\response\NotificationResponse;
use dmazurek\JsonRpc\response\Response;
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
    public function returnsErrorResponseForUnsupportedMethod()
    {
        $request = new Request("2.0", 'sampleMethod', [], 1);

        $handler = new MethodCallableHandler();
        $response = $handler->handle($request);
        $this->assertInstanceOf(FailedResponse::class, $response);
    }

    /**
     * @test
     */
    public function returnsIdentifiedResponseForIdentifiedRequest()
    {
        $request = new Request("2.0", 'sampleMethod', [], 1);
        $handler = new MethodCallableHandler();
        $handler->registerForMethod('sampleMethod', $this->callback);

        $response = $handler->handle($request);
        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @test
     */
    public function returnsEmptyResponseForNotificationRequest()
    {
        $request = new Notification("2.0", 'sampleMethod', [], 1);
        $handler = new MethodCallableHandler();
        $handler->registerForMethod('sampleMethod', $this->callback);

        $response = $handler->handle($request);
        $this->assertInstanceOf(NotificationResponse::class, $response);
    }

    /**
     * @test
     */
    public function returnsErrorResponseForNotificationRequest()
    {
        $request = new Notification("2.0", 'nonexistingMethod', []);

        $handler = new MethodCallableHandler();
        $response = $handler->handle($request);
        $this->assertInstanceOf(NotificationResponse::class, $response);
    }
}
