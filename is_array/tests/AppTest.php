<?php

use PHPUnit\Framework\TestCase;

class Class1 implements ArrayAccess {
    public $items = [];

    public function __construct(array $items = []) {
        $this->items = $items;
    }

    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    public function offsetGet($key): mixed
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value): void
    {
        $this->items[$key] = $value;
    }

    public function offsetUnset($key): void
    {
        unset($this->items[$key]);
    }
}

class AppTest extends TestCase {

    public function testArrayAccessImplementClass()
    {
        $cls = new Class1(['a' => 'aaa']);
        $this->assertFalse(is_array($cls));
    }
}
