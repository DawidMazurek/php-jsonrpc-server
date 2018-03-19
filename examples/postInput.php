<?php

declare(strict_types=1);

use DawidMazurek\JsonRpc\handler\MethodCallableHandler;
use DawidMazurek\JsonRpc\io\InputStream;
use DawidMazurek\JsonRpc\io\JsonSerializer;
use DawidMazurek\JsonRpc\request\JsonRpcRequestBuilder;
use DawidMazurek\JsonRpc\server\JsonRpcServer;

include __DIR__ . '/../vendor/autoload.php';
$requestBuilder = new JsonRpcRequestBuilder(new JsonSerializer());

$input = new InputStream($requestBuilder);

$sampleHandler =  function(array $params) {
    return "called with params:" . json_encode($params);
};

$handler = new MethodCallableHandler();
$handler->registerForMethod('sampleMethod', $sampleHandler);

$server = new JsonRpcServer(
    $handler
);

$response = $server->run($input);

header('ContentType: application/json');
echo $response->serialize();
