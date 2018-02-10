<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\request;

use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    /**
     * @test
     */
    public function transfersCorrectData()
    {
        $apiVersion = '2.0';
        $method = 'sampleMethod';
        $params = ['param' => 'value'];

        $request = new Notification($apiVersion, $method, $params);
        $this->assertEquals($apiVersion, $request->getApiVersion());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($params, $request->getParams());
    }
}
