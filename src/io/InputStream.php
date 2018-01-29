<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\io;

class InputStream implements JsonRpcInput
{
    public function readFromInput(): string
    {
        return file_get_contents('php://input');
    }
}
