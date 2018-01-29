<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\request;

interface JsonRpcRequest
{
    public function getApiVersion(): string;
    public function getMethod(): string;
    public function getParams(): array;
}
