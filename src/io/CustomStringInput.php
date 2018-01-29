<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\io;

class CustomStringInput implements JsonRpcInput
{
    /**
     * @var string
     */
    private $customString;

    public function __construct(string $customString)
    {
        $this->customString = $customString;
    }

    public function readFromInput(): string
    {
        return $this->customString;
    }
}
