<?php

declare(strict_types = 1);

namespace DawidMazurek\JsonRpc\IO;

use DawidMazurek\JsonRpc\Exception\ParseError;

class JsonSerializer
{
    public function serialize(array $data): string
    {
        return json_encode($data);
    }

    public function unserialize(string $json): array
    {
        $unserialized = json_decode($json, true);
        if ($unserialized === null) {
            throw new ParseError();
        }
        return $unserialized;
    }
}
