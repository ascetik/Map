<?php

namespace Ascetik\Map;

use Ascetik\Map\DTO\MapBox;
use Ascetik\Map\DTO\ReadonlyMap;
use Closure;

class Map
{
    private MapBox $container;

    public function __construct()
    {
        $this->clear();
    }

    public function set(string|int $key, mixed $value): void
    {
        $this->container->setValue((string) $key, $value);
    }

    public function get(string|int $key): mixed
    {
        return $this->container->valueOf((string) $key);
    }

    public function delete(string|int $key)
    {
        $this->container->delete($key);
    }

    public function clear()
    {
        $this->container = new MapBox();
    }

    public function size(): int
    {
        return $this->container->content()->count();
    }

    public function forEach(Closure $func)
    {
        $this->container->content()->each($func);
    }

    public function keys()
    {
        return $this->container->getKeys();
    }

    public function values()
    {
        return $this->container->getValues();
    }

    public function entries(): ReadonlyMap
    {
        return $this->container->content();
    }

    public static function from(iterable $iterable):self
    {
        $map = new self();
        foreach($iterable as $key=>$value)
        {
            $map->set($key,$value);
        }
        return $map;
    }

}
