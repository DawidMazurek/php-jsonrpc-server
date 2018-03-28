<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\Request;

interface JsonRpcRequest
{
    public function getApiVersion(): string;
    public function getMethod(): string;
    public function getParams(): array;
}
