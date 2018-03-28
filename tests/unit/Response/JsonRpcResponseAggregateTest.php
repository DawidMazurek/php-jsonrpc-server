<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Response;

use PHPUnit\Framework\TestCase;

class JsonRpcResponseAggregateTest extends TestCase
{
    /**
     * @test
     */
    public function transfersResponse()
    {
        $response = $this->createMock(Response::class);
        $aggregate = new JsonRpcResponseAggregate();
        $aggregate->addResponse($response);

        $this->assertEquals(1, count($aggregate->getAll()));
        $this->assertContainsOnlyInstancesOf(Response::class, $aggregate->getAll());
    }

    /**
     * @test
     */
    public function skipsNotificationResponse()
    {
        $aggregate = new JsonRpcResponseAggregate();
        $aggregate->addResponse($this->createMock(Response::class));
        $aggregate->addResponse($this->createMock(NotificationResponse::class));

        $this->assertEquals(1, count($aggregate->getAll()));
        $this->assertContainsOnlyInstancesOf(Response::class, $aggregate->getAll());
    }

    /**
     * @test
     */
    public function returnsSingleSerializedResponse()
    {
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('getPayload')
            ->willReturn(['mock' => 'payload']);
        $expected = '{"mock":"payload"}';

        $aggregate = new JsonRpcResponseAggregate();
        $aggregate->addResponse($response);

        $this->assertEquals($expected, $aggregate->serialize());
    }

    /**
     * @test
     */
    public function returnsManySerializedResponses()
    {
        $response1 = $this->createMock(Response::class);
        $response1->expects($this->once())
            ->method('getPayload')
            ->willReturn(['mock' => 'payload']);

        $response2 = $this->createMock(Response::class);
        $response2->expects($this->once())
            ->method('getPayload')
            ->willReturn(['mock' => 'payload']);

        $expected = '[{"mock":"payload"},{"mock":"payload"}]';

        $aggregate = new JsonRpcResponseAggregate();
        $aggregate->addResponse($response1);
        $aggregate->addResponse($response2);

        $this->assertEquals($expected, $aggregate->serialize());
    }
}
