<?php

namespace Ascetik\Map\DTO;

use Ascetik\Box\Box;
use Ascetik\ContainerExt\keys\StringKey;
use Ascetik\ContainerExt\Values\Content;

class MapBox extends Box
{
    public function hasValue(mixed $value): bool
    {
        $found = $this->find(
            function(StringKey $key) use ($value){
                $content = $this->getValueFrom($key);
                return $content->value == $value;
            }
        );
        return !is_null($found);
    }

    private function getValueFrom(StringKey $key):Content
    {
        return $this->offsetGet($key);
    }
}
