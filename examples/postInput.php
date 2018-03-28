<?php

declare(strict_types=1);

use DawidMazurek\JsonRpc\handler\MethodCallableHandler;
use DawidMazurek\JsonRpc\IO\InputStream;
use DawidMazurek\JsonRpc\IO\JsonSerializer;
use DawidMazurek\JsonRpc\Request\JsonRpcRequestBuilder;
use DawidMazurek\JsonRpc\Server\JsonRpcServer;

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
