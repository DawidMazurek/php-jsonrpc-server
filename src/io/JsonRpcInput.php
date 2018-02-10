<?php

namespace DawidMazurek\JsonRpc\io;

use DawidMazurek\JsonRpc\request\JsonRpcRequestAggregate;

interface JsonRpcInput
{
    public function getRequest(): JsonRpcRequestAggregate;
}
