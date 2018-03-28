<?php

namespace DawidMazurek\JsonRpc\IO;

use DawidMazurek\JsonRpc\Request\JsonRpcRequestAggregate;

interface JsonRpcInput
{
    public function getRequest(): JsonRpcRequestAggregate;
}
