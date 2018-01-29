<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\io;

class JsonSerializer
{
    public function serialize(array $data): string
    {
        return json_encode($data);
    }

    public function unserialize(string $json): array
    {
        return json_decode($json, true);
    }
}
