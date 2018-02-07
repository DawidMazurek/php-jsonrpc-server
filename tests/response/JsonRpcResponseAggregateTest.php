<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

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
}
