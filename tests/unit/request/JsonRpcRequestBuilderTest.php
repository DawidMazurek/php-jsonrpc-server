<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\request;

use DawidMazurek\JsonRpc\io\JsonSerializer;
use PHPUnit\Framework\TestCase;

class JsonRpcRequestBuilderTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|JsonSerializer
     */
    private $serializer;

    public function setUp()
    {
        $this->serializer = $this->createMock(JsonSerializer::class);
    }

    /**
     * @test
     */
    public function createsRequest()
    {
        $json = '{"jsonrpc":"2.0", "method":"sampleMethod", "params": [], "id":1}';

        $this->serializer->expects($this->once())
            ->method('unserialize')
            ->with($json)
            ->willReturn([
                'jsonrpc' => '2.0',
                'method' => 'sampleMethod',
                'params' => [],
                'id' => 1
            ]);

        $builder = new JsonRpcRequestBuilder($this->serializer);
        $requests = $builder->buildFromJson($json);
        $this->assertContainsOnlyInstancesOf(Request::class, $requests->getAll());
        $this->assertEquals(1, count($requests->getAll()));
    }

    /**
     * @test
     */
    public function createsNotificationWhenNoIdGiven()
    {
        $json = '{"jsonrpc":"2.0", "method":"sampleMethod", "params": []}';

        $this->serializer->expects($this->once())
            ->method('unserialize')
            ->with($json)
            ->willReturn([
                'jsonrpc' => '2.0',
                'method' => 'sampleMethod',
                'params' => [],
            ]);

        $builder = new JsonRpcRequestBuilder($this->serializer);
        $requests = $builder->buildFromJson($json);
        $this->assertContainsOnlyInstancesOf(Notification::class, $requests->getAll());
        $this->assertEquals(1, count($requests->getAll()));
    }


    /**
     * @test
     */
    public function createsMultipleRequests()
    {
        $json = '[{"jsonrpc":"2.0", "method":"sampleMethod", "params": [], "id":1},
        {"jsonrpc":"2.0", "method":"sampleMethod", "params": [], "id":1}]';

        $this->serializer->expects($this->once())
            ->method('unserialize')
            ->with($json)
            ->willReturn([[
                'jsonrpc' => '2.0',
                'method' => 'sampleMethod',
                'params' => [],
            ], [
                'jsonrpc' => '2.0',
                'method' => 'sampleMethod',
                'params' => [],
            ]]);

        $builder = new JsonRpcRequestBuilder($this->serializer);
        $requests = $builder->buildFromJson($json);
        $this->assertContainsOnlyInstancesOf(Notification::class, $requests->getAll());
        $this->assertEquals(2, count($requests->getAll()));
    }
}
