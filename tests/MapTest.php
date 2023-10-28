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

    public function testShouldRetrieveAllEntries()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'second test');
        $entries = $this->map->entries();
        $this->assertCount(2, $entries->toArray());
        $this->assertSame(
            [
                'one' => 'first test',
                'two' => 'second test',
            ],
            $entries->toArray()
        );
    }


    public function testShouldRetrieveOnlyKeys()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'second test');
        $this->assertSame(['one', 'two'], $this->map->keys());
    }

    public function testShouldRetrieveOnlyValues()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'second test');
        $this->assertSame(
            ['first test', 'second test'],
            $this->map->values()
        );
    }

    public function testShouldBeAbleToClearAllContent()
    {
        $this->map->set('one', 'first test');
        $this->map->set('two', 'second test');
        $this->assertSame(2, $this->map->size());
        $this->map->clear();
        $this->assertSame(0, $this->map->size());
    }

    public function testBuildAMapFromAnArray()
    {
        $data = [
            'one' => 'first test',
            'two' => 'second test',
        ];
        $map = $this->map::from($data);
        $this->assertSame('first test', $map->get('one'));
    }
}
