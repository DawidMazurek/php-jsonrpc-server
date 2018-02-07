<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

use PHPUnit\Framework\TestCase;

class NotificationResponseTest extends TestCase
{
    /**
     * @test
     */
    public function deliversEmptyPayload()
    {
        $response = new NotificationResponse();
        $this->assertEmpty($response->getPayload());
    }
}
