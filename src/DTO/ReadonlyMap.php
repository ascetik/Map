<?php

/**
 * This is part of the ascetik/map package
 *
 * @package    Map
 * @category   Data Transfer Object
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\Map\DTO;

use Ascetik\Box\Box;
use Ascetik\ContainerCore\Types\ReadableContainer;
use Ascetik\ContainerExt\Keys\StringKey;
use Closure;

/**
 * Immutable Map
 *
 * @version 1.0.0
 */
class ReadonlyMap implements ReadableContainer
{
    public function __construct(private Box $container)
    {
    }

    public function toArray(): array
    {
        $output = [];

        $this->container->each(function (StringKey $key) use (&$output) {
            $output[$key->id()] = $this->container->offsetGet($key)->content();
        });

        return $output;
    }

    public function filter(Closure $find): ReadableContainer
    {
        return $this->container->filter($find);
    }

    public function find(Closure $find): mixed
    {
        return $this->container->find($find);
    }

    public function each(Closure $find): void
    {
        $this->container->each($find);
    }

    public function count(): int
    {
        return $this->container->count();
    }
}
