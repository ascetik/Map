<?php

/**
 * This is part of the ascetik/map package
 *
 * @package    Map
 * @category   Main implementation
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\Map;

use Ascetik\Map\DTO\MapRegistry;
use Ascetik\Map\DTO\ReadonlyMap;
use Closure;

/**
 * Map container
 * holding associated key/value pairs
 *
 * @version 1.0.0
 */
class Map
{
    private MapRegistry $container;

    public function __construct()
    {
        $this->clear();
    }

    public function set(string|int $key, mixed $value): void
    {
        $this->container->setValue((string) $key, $value);
    }

    public function delete(string|int $key)
    {
        $this->container->delete($key);
    }

    public function clear()
    {
        $this->container = new MapRegistry();
    }

    public function get(string|int $key): mixed
    {
        return $this->container->valueOf((string) $key);
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

    public static function from(array $iterable): self
    {
        $map = new self();
        foreach ($iterable as $key => $value) {
            $map->set($key, $value);
        }
        return $map;
    }
}
