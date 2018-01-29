<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\response;

interface JsonRpcResponse
{
    public function getPayload(): array;
}
