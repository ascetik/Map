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
use Ascetik\ContainerExt\Keys\StringKey;
use Ascetik\ContainerExt\Types\ContainerKey;
use Ascetik\ContainerExt\Types\ContainerValue;
use Ascetik\ContainerExt\Values\MixedValue;

/**
 * Map elements registry
 * using a Box to register keys and values
 *
 * @version 1.0.0
 */
class MapRegistry
{
    /**
     * @var Box<ContainerKey,ContainerValue>
     */
    private Box $box;

    public function __construct()
    {
        $this->box = new Box();
    }

    public function content(): ReadonlyMap
    {
        return new ReadonlyMap($this->box);
    }

    public function hasValue(mixed $content): bool
    {
        $found = $this->box->find(
            function (StringKey $key) use ($content) {
                $value = $this->getValueFrom($key);
                return $value->content() == $content;
            }
        );
        return !is_null($found);
    }

    public function hasKey(string $key)
    {
        $found = $this->getKey($key);
        return !is_null($found);
    }

    public function valueOf(string $key)
    {
        return $this->getValueFrom($this->getKey($key))->content();
    }

    public function setValue(string $key, mixed $value)
    {
        if ($this->hasValue($value)) {
            return;
        }

        $content = new MixedValue($value);

        if ($Key = $this->getKey($key)) {
            $this->box->offsetSet($Key, $content);
            return;
        }

        $this->box->attach(new StringKey($key), $content);
    }

    public function delete(string $name)
    {
        $key = $this->getKey($name);
        $this->box->detach($key);
    }

    public function getKeys(): array
    {
        $keys = [];
        $this->box->each(
            function (StringKey $key) use (&$keys) {
                $keys[] = $key->id();
            }
        );
        return $keys;
    }

    public function getValues(): array
    {
        $values = [];
        $this->box->each(
            function (StringKey $key) use (&$values) {
                $values[] = $this->box->offsetGet($key)->content();
            }
        );
        return $values;
    }

    private function getKey(string $key): ?StringKey
    {
        return $this->box->find(
            fn (StringKey $Key) => $Key->id() == $key
        );
    }

    private function getValueFrom(StringKey $key): MixedValue
    {
        return $this->box->offsetGet($key);
    }
}
