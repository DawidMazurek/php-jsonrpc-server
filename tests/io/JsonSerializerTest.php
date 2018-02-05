<?php

declare(strict_types = 1);

namespace dmazurek\JsonRpc\io;

use dmazurek\JsonRpc\exception\ParseError;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function serializesArray()
    {
        $expected = '{"jsonrpc":"2.0"}';
        $serializer = new JsonSerializer();
        $serialized = $serializer->serialize(['jsonrpc' => '2.0']);
        $this->assertEquals($expected, $serialized);
    }

    /**
     * @test
     */
    public function unserializesJson()
    {
        $expected = ['jsonrpc' => '2.0'];
        $serializer = new JsonSerializer();
        $unserialized = $serializer->unserialize('{"jsonrpc":"2.0"}');
        $this->assertEquals($expected, $unserialized);
    }

    /**
     * @test
     */
    public function throwsExceptionWhenUnserializingIncorrectJson()
    {
        $this->expectException(ParseError::class);
        $serializer = new JsonSerializer();
        $serializer->unserialize('{someincorrect:Json');
    }
}
