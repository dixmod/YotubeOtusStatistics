<?php

namespace App\Service\Serialize;

abstract class ModelSerialize implements \JsonSerializable
{
    use PropertyIterator {
        PropertyIterator::jsonSerialize as toArrayWithoutFields;
    }

    public function jsonSerialize(): array
    {
        $arrayOfProperties = $this->toArrayWithoutFields($this->getSkipProperty());
        $arrayOfProperties = array_merge(
            $arrayOfProperties,
            $this->toArray()
        );

        return $arrayOfProperties;
    }

    public function getSkipProperty(): array
    {
        return [];
    }

    public function toArray(): array
    {
        return [];
    }
}