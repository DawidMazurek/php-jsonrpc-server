<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\response;

interface JsonRpcResponse
{
    public function getPayload(): array;
}
