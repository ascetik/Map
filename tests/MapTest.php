<?php

use Ascetik\Map\Map;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    private Map $map;

    protected function setUp(): void
    {
        $this->map = new Map();
    }

    public function testaddingContentInAMap()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'second test');
        $this->assertSame(2, $this->map->size());
    }

    public function testShouldRegisterUniqueValues()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'first test');
        $this->assertSame(1, $this->map->size());
    }

    public function testShouldReplaceTheValueOfARegisteredKey()
    {
        $this->map->set('one', 'first test');
        $this->map->set('one', 'second test');
        $this->assertSame(1, $this->map->size());
    }

    public function testShouldReturnExpectedValue()
    {
        $this->map->set('one', 'first test');
        $this->assertSame('first test', $this->map->get('one'));
    }

    public function testShouldBeAbleToDeleteAnElement()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'second test');
        $this->map->delete('one');
        $this->assertSame(1, $this->map->size());
    }

    public function testShouldRetrieveOnlyKeys()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'second test');
        $this->assertSame(
            [
                'one' => 'first test',
                'two' => 'second test',
            ],
            $this->map->entries()->toArray()
        );
    }
}
