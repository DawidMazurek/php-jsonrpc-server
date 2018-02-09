<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function deliversCorrectPayload()
    {
        $jsonRpc = "2.0";
        $requestId = 1;
        $result = 'OK';

        $response = new Response($jsonRpc, $requestId, $result);
        $this->assertEquals(
            [
                'jsonrpc' => $jsonRpc,
                'id' => $requestId,
                'result' => $result
            ]
            , $response->getPayload()
        );
    }
}
