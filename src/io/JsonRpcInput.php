<?php

namespace dmazurek\JsonRpc\io;

use dmazurek\JsonRpc\request\JsonRpcRequestAggregate;

interface JsonRpcInput
{
    public function getRequest(): JsonRpcRequestAggregate;
}
