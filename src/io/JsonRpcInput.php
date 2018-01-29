<?php

namespace dmazurek\JsonRpc\io;

interface JsonRpcInput
{
    public function readFromInput(): string;
}
