<?php

namespace Ascetik\Map;

use Ascetik\Box\Box;
use Ascetik\Map\DTO\MapBox;

class Map
{
    private MapBox $container;

    public function __construct()
    {
        $this->container = new MapBox();
    }

    public function push(string|int $key, mixed $value):void
    {
        if($this->container->hasValue($value)){
            return;
        }
    }
}
