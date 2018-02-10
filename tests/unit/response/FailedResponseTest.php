<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

use PHPUnit\Framework\TestCase;

class FailedResponseTest extends TestCase
{
    /**
     * @test
     */
    public function deliversCorrectPayload()
    {
        $jsonRpc = "2.0";
        $errorCode = 1;
        $errorMessage = 'Error occured';
        $requestId = 1;

        $response = new FailedResponse($jsonRpc, $errorCode, $errorMessage, $requestId);
        $this->assertEquals(
            [
                'jsonrpc' => $jsonRpc,
                'error' => [
                    'code' => $errorCode,
                    'message' => $errorMessage
                ],
                'id' => $requestId
            ],
            $response->getPayload()
        );

    }
}
