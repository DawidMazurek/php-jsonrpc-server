<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\request;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function transfersCorrectData()
    {
        $apiVersion = '2.0';
        $method = 'sampleMethod';
        $params = ['param' => 'value'];
        $requestId = 1;

        $request = new Request($apiVersion, $method, $params, $requestId);
        $this->assertEquals($apiVersion, $request->getApiVersion());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($params, $request->getParams());
        $this->assertEquals($requestId, $request->getRequestId());
    }
}
