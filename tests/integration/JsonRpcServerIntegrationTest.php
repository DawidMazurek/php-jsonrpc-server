<?php

declare(strict_types = 1);

use DawidMazurek\JsonRpc\handler\MethodCallableHandler;
use DawidMazurek\JsonRpc\io\CustomStringInput;
use DawidMazurek\JsonRpc\io\JsonSerializer;
use DawidMazurek\JsonRpc\request\JsonRpcRequestBuilder;
use DawidMazurek\JsonRpc\response\JsonRpcResponseAggregate;
use DawidMazurek\JsonRpc\server\JsonRpcServer;
use PHPUnit\Framework\TestCase;

class JsonRpcServerIntegrationTest extends TestCase
{
    /**
     * @test
     */
    public function singleRequest()
    {
        $givenRequestPayload ='{"jsonrpc":"2.0","method": "sampleMethod","params":{"foo":"bar"},"id":1}';
        $expectedJson = '{"jsonrpc":"2.0","id":1,"result":{"status":"ok","params":{"foo":"bar"}}}';

        $result = $this->runWithCustomPayload($givenRequestPayload);

        $this->assertEquals($expectedJson, $result->serialize());
    }

    /**
     * @test
     */
    public function bulkRequests()
    {
        $givenRequestPayload ='[{"jsonrpc":"2.0","method":"sampleMethod","params":{"foo":"bar"},"id":1},';
        $givenRequestPayload .= '{"jsonrpc":"2.0", "method": "sampleMethod","params":{"bar":"baz"},"id":2}]';
        $expectedJson = '[{"jsonrpc":"2.0","id":1,"result":{"status":"ok","params":{"foo":"bar"}}},';
        $expectedJson .= '{"jsonrpc":"2.0","id":2,"result":{"status":"ok","params":{"bar":"baz"}}}]';

        $result = $this->runWithCustomPayload($givenRequestPayload);

        $this->assertEquals($expectedJson, $result->serialize());
    }

    /**
     * @test
     */
    public function emptyNotificationResponse()
    {
        $givenRequestPayload ='{"jsonrpc":"2.0", "method": "sampleMethod", "params":{"foo":"bar"}}';
        $expectedJson = '[]';

        $result = $this->runWithCustomPayload($givenRequestPayload);

        $this->assertEquals($expectedJson, $result->serialize());
    }



    private function runWithCustomPayload(string $json): JsonRpcResponseAggregate
    {
        $requestBuilder = new JsonRpcRequestBuilder(new JsonSerializer());

        $input = new CustomStringInput(
            $json,
            $requestBuilder
        );

        $sampleHandler = function (array $params) {
            return ["status" => 'ok', 'params' => $params];
        };

        $handler = new MethodCallableHandler();
        $handler->registerForMethod('sampleMethod', $sampleHandler);

        $server = new JsonRpcServer(
            $handler,
            new JsonRpcRequestBuilder(new JsonSerializer())
        );

       return $server->run($input->getRequest());
    }
}
