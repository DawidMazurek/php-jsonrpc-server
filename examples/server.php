<?php

declare(strict_types=1);

use dmazurek\JsonRpc\handler\MethodCallableHandler;
use dmazurek\JsonRpc\io\CustomStringInput;
use dmazurek\JsonRpc\io\InputStream;
use dmazurek\JsonRpc\io\JsonSerializer;
use dmazurek\JsonRpc\request\JsonRpcRequest;
use dmazurek\JsonRpc\request\JsonRpcRequestBuilder;
use dmazurek\JsonRpc\server\JsonRpcServer;

include __DIR__ . '/../vendor/autoload.php';
$requestBuilder = new JsonRpcRequestBuilder(new JsonSerializer());

$input = new InputStream($requestBuilder);
$input = new CustomStringInput(
    '{"jsonrpc":"2.0", "method": "sampleMethod", "params":[], "id":1}',
    $requestBuilder
);

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
