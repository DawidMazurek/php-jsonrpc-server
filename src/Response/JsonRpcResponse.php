<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Response;

interface JsonRpcResponse
{
    public function getPayload(): array;
}
