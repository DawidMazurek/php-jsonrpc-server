<?php

declare(strict_types=1);

use DawidMazurek\JsonRpc\handler\MethodCallableHandler;
use DawidMazurek\JsonRpc\io\CustomStringInput;
use DawidMazurek\JsonRpc\io\InputStream;
use DawidMazurek\JsonRpc\io\JsonSerializer;
use DawidMazurek\JsonRpc\request\JsonRpcRequestBuilder;
use DawidMazurek\JsonRpc\server\JsonRpcServer;

include __DIR__ . '/../vendor/autoload.php';
$requestBuilder = new JsonRpcRequestBuilder(new JsonSerializer());

$input = new InputStream($requestBuilder);

$input = new CustomStringInput(
    '[{"jsonrpc":"2.0", "method": "sampleMethod", "params":[], "id":1}, {"jsonrpc":"2.0", "method": "sampleMethod", "params":[]}]',
    $requestBuilder
);

$sampleHandler =  function(array $params) {
    return "called with params:" . json_encode($params);
};

$handler = new MethodCallableHandler();
$handler->registerForMethod('sampleMethod', $sampleHandler);

$server = new JsonRpcServer(
    $handler,
    new JsonRpcRequestBuilder(new JsonSerializer())
);

$response = $server->run($input->getRequest());

echo json_encode($response->serialize());
