<?php

declare(strict_types=1);

use dmazurek\JsonRpc\config\JsonRpcConfig;
use dmazurek\JsonRpc\io\CustomStringInput;
use dmazurek\JsonRpc\io\InputStream;
use dmazurek\JsonRpc\io\JsonSerializer;
use dmazurek\JsonRpc\request\JsonRpcRequest;
use dmazurek\JsonRpc\request\JsonRpcRequestBuilder;
use dmazurek\JsonRpc\server\JsonRpcServer;

include __DIR__ . '/../vendor/autoload.php';

$config = new JsonRpcConfig();
$input = new InputStream();
$input = new CustomStringInput('{"jsonrpc":"2.0", "method": "sampleMethod", "params":[], "id":1}');
$jsonSerializer = new JsonSerializer();
$sampleHandler =  function(JsonRpcRequest $request) {
    return "called {$request->getMethod()}";
};

$config->addMapping('sampleMethod', $sampleHandler);

$server = new JsonRpcServer(
    $config,
    new JsonRpcRequestBuilder(
        $jsonSerializer
    )
);

$response = $server->run($input);

var_dump($jsonSerializer->serialize($response->getPayload()));
